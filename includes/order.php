<?php

if (class_exists('WeixinAPI') && $_GET['code']) {

	$wx = new WeixinAPI();

	$user = wp_get_current_user();

	$openid_before = get_user_meta($user->ID, 'wx_openid', true);

	if ($user_info = $wx->oauth_get_user_info()) {
		update_user_meta($user_id, 'sex', $user_info->sex);
		update_user_meta($user_id, 'country', $user_info->country);
		update_user_meta($user_id, 'province', $user_info->province);
		update_user_meta($user_id, 'language', $user_info->language);
		update_user_meta($user_id, 'headimgurl', $user_info->headimgurl);
		update_user_meta($user_id, 'subscribe_time', $user_info->subscribe_time);
	}

	if (!$openid_before && $user_info) {
		add_limited_free($user->ID, 3);
	}

	if (get_user_meta($user->ID, 'invited_by_user')) {
		add_limited_free($user->ID, 2);
	}

	$redirect_query = parse_url(site_url($_SERVER['REQUEST_URI']), PHP_URL_QUERY);
	$redirect_path = parse_url(site_url($_SERVER['REQUEST_URI']), PHP_URL_PATH);
	parse_str($redirect_query, $redirect_query_object);
	unset($redirect_query_object['code']);
	header('Location: ' . site_url($redirect_path . '?' . http_build_query($redirect_query_object))); exit;
}

function add_limited_free ($user_id, $days) {
	$service_tips_valid_after = get_user_meta($user_id, 'service_tips_valid_before', true);
	$service_exercises_valid_after = get_user_meta($user_id, 'service_exercises_valid_before', true);

	if (!$service_tips_valid_after || $service_tips_valid_after < time()) {
		$service_tips_valid_after = time();
		update_user_meta($user_id, 'limited_free', 'yes');
	}

	if (!$service_exercises_valid_after || $service_exercises_valid_after < time()) {
		$service_exercises_valid_after = time();
		update_user_meta($user_id, 'limited_free', 'yes');
	}

	update_user_meta($user_id, 'service_tips_valid_before', $service_tips_valid_after + 86400 * $days);
	update_user_meta($user_id, 'service_exercises_valid_before', $service_exercises_valid_after + 86400 * $days);
}

function is_limited_free ($user_id = null) {
	if (!$user_id) {
		$user_id = get_current_user_id();
	}
	return 'yes' === get_user_meta($user_id, 'limited_free', true);
}

function order_paid ($order_no, $gateway = null) {
	// find the order
	$order = get_posts(array('name' => sanitize_title($order_no), 'post_type' => 'member_order', 'post_status' => 'private'))[0];

	if (!$order) {
		error_log('order_paid(): order not found. (order no: ' . $order_no . ')');
		exit;
	}

	// update order payment status
	update_post_meta($order->ID, 'status', 'paid');
	update_post_meta($order->ID, 'refundable_amount', get_post_meta($order->ID, 'price', true));

	if ($gateway) {
		update_post_meta($order->ID, 'gateway', $gateway);
	}

	// TODO price-service needs to be verified

	// get the user and add cap
	$user_id = get_post_meta($order->ID, 'user', true);
	$user = get_user_by('ID', $user_id);

	if (!$user) {
		error_log('order_paid(): order user not found. (order no: ' . $order_no . ')');
	}

	$products = get_field('products', $order->ID);
	$duration = get_post_meta($order->ID, 'duration', true);

	if (in_array($products, array('pte-reading'))) {
		$inactivated_readings = get_user_meta($user->ID, 'video_reading_inactivated', true) ?: 0;
		update_user_meta($user->ID, 'video_reading_inactivated', $inactivated_readings + 3);
	}

	if (in_array($products, array('pte-writing'))) {
		$inactivated_writings = get_user_meta($user->ID, 'video_writing_inactivated', true) ?: 0;
		update_user_meta($user->ID, 'video_writing_inactivated', $inactivated_writings + 3);
	}

	foreach ($products as $product) {
		$product_valid_after = get_user_meta($user->ID, 'product_' . $product . '_valid_before', true);
		if (!$product_valid_after || $product_valid_after < time()) {
			$product_valid_after = time();
		}
		update_user_meta($user->ID, 'product_' . $product . '_valid_before', $product_valid_after + 86400 * $duration);
	}

	if (isset($product_valid_after)) {
		$products_expire_at = $product_valid_after + 86400 * $duration;
	}

	$order_price = get_post_meta($order->ID, 'price', true);

	// user total pay
	update_user_meta($user->ID, 'total_paid', (get_user_meta($user->ID, 'total_paid', true) ?: 0) + $order_price);

	// log to promotion_code for base & full package
	$promotion_code_id = get_post_meta($order->ID, 'promotion_code', true);
	if ($promotion_code_id) {
		add_post_meta($promotion_code_id, 'user', $user->ID);
		$promotion_code_total_paid = get_post_meta($promotion_code_id, 'total_paid', true) ?: 0;
		update_post_meta($promotion_code_id, 'total_paid', $promotion_code_total_paid + $order_price);
	}

	// invitation award and discount
	$inviter_id = get_user_meta($user->ID, 'invited_by_user', true);
	$discount_order = get_user_meta($user->ID, 'discount_order', true);

	if ($inviter_id && !$discount_order) {

		add_user_meta($user->ID, 'discount_order', $order->ID);

		// award the inviter
		$award_amount_fixed = get_post_meta(get_page_by_path('pricing-table')->ID, 'intro_award', true);
		$awardable_amount = round(get_user_meta($inviter_id, 'total_paid', true) - get_user_meta($inviter_id, 'total_awarded', true), 2);

		$award_amount = min($award_amount_fixed, $awardable_amount);

		if  ($award_amount > 0) {
			// get oldest refundable orders
			$refundable_orders = get_posts(array(
				'post_type' => 'member_order',
				'post_status' => 'private',
				'author' => $inviter_id,
				'date_query' => array('after' => '-3 months'),
				'order' => 'asc',
				'posts_per_page' => '-1',
				'meta_key' => 'refundable_amount',
				'meta_compare' => '>',
				'meta_value' => '0')
			);

			foreach ($refundable_orders as $refundable_order) {
				$refund_amount = min(get_post_meta($refundable_order->ID, 'refundable_amount', true), $award_amount);
				refund_order($refundable_order->ID, $refund_amount);
				$award_amount -= $refund_amount;
				if ($award_amount <= 0) {
					break;
				}
			}
		}
	}

	send_template_mail('subscribed-email', $user->user_email, array(
		'user_name' => $user->display_name,
		'package_name' => get_the_title($order->ID),
		'expires_at' => isset($products_expire_at) ? date('Y-m-d H:i', $products_expire_at + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS) : __('激活后24小时', 'bingo')
	));
// echo get_post_meta($order->ID, 'status', true); exit;
	return $order;
}

/**
 * @param $out_trade_no string order no in our system
 * @param $subject string order title
 * @param $total_fee number a price in basic unit
 * @param $currency string
 * @param $products array array of slugs of question_types that this order is subject to
 * @param $duration int days of service package
 * @param $promotion_code string promotion code
 * @param $gateway string alipay, wechatpay or paypal
 */
function create_order ($out_trade_no, $subject, $total_fee, $currency, $products, $duration, $promotion_code, $gateway) {
	$order_id = wp_insert_post(array(
		'post_type' => 'member_order',
		'post_author' => get_current_user_id(),
		'post_name' => $out_trade_no,
		'post_title' => $subject,
		'post_status' => 'private'
	));

	add_post_meta($order_id, 'price', $total_fee);
	add_post_meta($order_id, 'currency', $currency);
	add_post_meta($order_id, 'no', $out_trade_no);
	add_post_meta($order_id, 'user', get_current_user_id());
	update_field('products', $products, $order_id);
	add_post_meta($order_id, 'duration', $duration);
	add_post_meta($order_id, 'status', 'pending_payment');

	add_post_meta($order_id, 'gateway', $gateway);

	if ($promotion_code) {
		$promotion_code_object = get_posts(array('post_type' => 'promotion_code', 'name' => $promotion_code, 'post_status' => 'private'))[0];

		if (!$promotion_code_object) {
			exit(__('错误的优惠码', 'bingo'));
		}

		add_post_meta($order_id, 'promotion_code', $promotion_code_object->ID);
	}
}

/**
 * refund an order through it's gateway
 * @param $order_id
 */
function refund_order ($order_id, $amount) {

	$amount = round($amount, 2);
	$order_no = get_post_meta($order_id, 'no', true);
	$service = get_post_meta($order_id, 'service', true);

	if ($amount <= 0) {
		return;
	}

	$refundable = get_post_meta($order_id, 'refundable_amount', true);

	if ($refundable <= 0) {
		return;
	}

	if ($refundable < $amount) {
		$amount = $refundable;
	}

	$gateway = get_post_meta($order_id, 'gateway', true);

	switch ($gateway) {
		case 'wechatpay':
			$input = new RoyalPayApplyRefund($service);
			$input->setOrderId($order_no);
			$input->setRefundId('refund.' . $order_no);
			$input->setFee($amount * 100);
			RoyalPayApi::refund($input, 10, $service);
			break;
		case 'paypal':
			$sale_id = get_post_meta($order_id, 'sale_id', true);
			paypal_sale_refund($sale_id, $amount, $service);
			break;
		case 'alipay':
		default:
			(new AlipayRefund(get_alipay_config()))->refund($order_no, $amount);
	}

	update_post_meta($order_id, 'refundable_amount',
		round($refundable - $amount, 2)
	);

	$user = get_post_meta(get_post($order_id)->ID, 'user', true);

	update_user_meta($user, 'total_awarded', get_user_meta($user, 'total_awarded', true) + $amount);
}
