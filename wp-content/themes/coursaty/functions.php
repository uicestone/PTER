<?php

add_action('wp', function() {

	wp_register_style('style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.19');
	wp_register_style('responsive', get_stylesheet_directory_uri() . '/assets/css/responsive.css', array(), '1.0.0');

	wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/vendor/jquery-1.11.2.min.js', array(), '1.11.2', true);
	wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/assets/js/bsmodal.min.js', array('jquery'), '3.3.4', true);
	wp_register_script('easydropdown', get_stylesheet_directory_uri() . '/assets/js/jquery.easydropdown.min.js', array('jquery'), '2.1.4', true);
	wp_register_script('flexslider', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), '2.2.2', true);
	wp_register_script('isotope', get_stylesheet_directory_uri() . '/assets/js/jquery.isotope.min.js', array('jquery'), '1.5.26', true);
	wp_register_script('revolution', get_stylesheet_directory_uri() . '/assets/js/jquery.themepunch.revolution.min.js', array('jquery'), '4.6.4', true);
	wp_register_script('tools', get_stylesheet_directory_uri() . '/assets/js/jquery.themepunch.tools.min.js', array('jquery'), '1.0.0', true);
	wp_register_script('viewportchecker', get_stylesheet_directory_uri() . '/assets/js/jquery.viewportchecker.min.js', array('jquery'), '1.8.0', true);
	wp_register_script('waypoints', get_stylesheet_directory_uri() . '/assets/js/jquery.waypoints.min.js', array('jquery'), '3.0.0', true);
	wp_register_script('sticky', get_stylesheet_directory_uri() . '/assets/js/jquery.sticky.min.js', array('jquery'), '1.0.4', true);
	wp_register_script('jsdiff', get_stylesheet_directory_uri() . '/assets/js/jsdiff.js', array(), '3.3.0', true);
	wp_register_script('scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.2', true);

});

add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('style');
	wp_enqueue_style('responsive');

	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap');
	wp_enqueue_script('easydropdown');
	wp_enqueue_script('flexslider');
	wp_enqueue_script('isotope');
	wp_enqueue_script('revolution');
	wp_enqueue_script('tools');
	wp_enqueue_script('viewportchecker');
	wp_enqueue_script('waypoints');
	wp_enqueue_script('sticky');
	wp_enqueue_script('jsdiff');
	wp_enqueue_script('scripts');
});

add_action('after_switch_theme', function () {
	$administrator = get_role('administrator');
	$administrator->add_cap('view_tips');
	$administrator->add_cap('view_exercises');

	if (! wp_next_scheduled ( 'bingo_caps_clean' )) {
		wp_schedule_event(strtotime('+1 hour') - time() % 3600, 'hourly', 'bingo_caps_clean');
	}

	if (! wp_next_scheduled ( 'bingo_subscription_remind' )) {
		wp_schedule_event(strtotime('next monday 20:00') - get_option( 'gmt_offset' ) * HOUR_IN_SECONDS, 'daily', 'bingo_subscription_remind');
	}

	if (! wp_next_scheduled ( 'bingo_refresh_apnic_cn_ip_range' )) {
		wp_schedule_event(time(), 'daily', 'bingo_refresh_apnic_cn_ip_range');
	}
});

add_action('after_setup_theme', function () {
	register_nav_menu('primary', '主导航');
	add_theme_support('post-thumbnails');
	add_image_size('headline', 1600, 700, true);
	add_image_size('mentor', 270, 270, true);
	add_image_size('post-thumbnail', 1280, 720, true);
});

add_action('init', function () {

	add_post_type_support('post', 'page-attributes');

	register_taxonomy('question_type', null, array(
		'label' => '题型分类',
		'labels' => array(
			'all_items' => '所有题型',
			'add_new' => '添加题型',
			'add_new_item' => '新题型',
		),
		'public' => true,
		'show_admin_column' => true,
		'hierarchical' => true
	));

	register_post_type('question_type_desc', array(
		'label' => '题型',
		'labels' => array(
			'all_items' => '所有题型',
			'add_new' => '添加题型',
			'add_new_item' => '新题型',
			'not_found' => '未找到题型'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes'),
		'taxonomies' => array('question_type', 'post_tag'),
		'menu_icon' => 'dashicons-feedback',
		'has_archive' => true
	));

	add_post_type_support('question_type_desc', 'wps_subtitle');

	register_post_type('tip', array(
		'label' => '技巧',
		'labels' => array(
			'all_items' => '所有技巧',
			'add_new' => '添加技巧',
			'add_new_item' => '新技巧',
			'edit_item' => '编辑技巧',
			'not_found' => '未找到技巧'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes'),
		'taxonomies' => array('question_type', 'post_tag'),
		'menu_icon' => 'dashicons-clipboard',
		'has_archive' => true
	));

	add_post_type_support('tip', 'wps_subtitle');

	register_post_type('exercise', array(
		'label' => '练习',
		'labels' => array(
			'all_items' => '所有练习',
			'add_new' => '添加练习',
			'add_new_item' => '新练习',
			'edit_item' => '编辑练习',
			'not_found' => '未找到练习'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes'),
		'taxonomies' => array('question_type', 'post_tag'),
		'menu_icon' => 'dashicons-editor-spellcheck',
		'has_archive' => true
	));

	register_post_type('member_order', array(
		'label' => '订单',
		'labels' => array(
			'all_items' => '所有订单',
			'add_new' => '手动添加订单',
			'add_new_item' => '新订单',
			'edit_item' => '编辑订单',
			'not_found' => '未找到订单'
		),
		'show_ui' => true,
		'show_in_menu' => true,
		'supports' => array('title'),
		'taxonomies' => array('post_tag'),
		'menu_icon' => 'dashicons-cart',
	));

	add_filter('manage_member_order_posts_columns', function($columns) {
		$new_columns = array(
			'cb' => $columns['cb'],
			'title' => $columns['title'],
			'date' => '下单时间',
			'status' => '状态',
			'user'=>'用户',
			'price'=>'金额',
			'gateway' => '通道'
		);
		return $new_columns;
	});

	add_action('manage_member_order_posts_custom_column', function($column_name) {
		global $post;
		switch ($column_name ) {
			case 'user' :
			    $user_id = get_post_meta($post->ID, 'user', true);
				$user = get_user_by('ID', $user_id);
				echo '<a href="' . admin_url() . 'user-edit.php?user_id=' . $user->ID . '">' . $user->display_name . '</a>';
				break;
			case 'price' :
				$price = get_post_meta($post->ID, 'price', true);
				echo $price;
				break;
			case 'status' :
				$status = get_post_meta($post->ID, 'status', true);
				switch ($status) {
					case 'pending_payment': echo '待付款'; break;
					case 'paid': echo '已付款'; break;
					case 'cancelled': echo '已取消'; break;
					default;
				}
				break;
            case 'gateway':
				$gateway = get_post_meta($post->ID, 'gateway', true);
				echo $gateway;
                break;
			default;
		}
	});

	add_action('post_submitbox_minor_actions', function ($post){
	    if ($post->post_type === 'member_order' && get_post_meta($post->ID, 'status', true) === 'pending_payment') {
			echo '<div id="save-action">
                <input type="submit" name="set_paid" id="set_paid" value="手动授权" class="button" style="float:right">
            </div>';
        }
	});

	add_action('save_post_member_order', function ($order_id) {

	    if (!is_admin()) {
	        return;
        }

	    $order_no = get_post_meta($order_id, 'no', true);
	    $status = get_post_meta($order_id, 'status', true);

	    $order = get_post($order_id);

	    if (!$order_no) {
	        update_post_meta($order_id, 'no', 'manual.' . $order_id);
        }

		if ($order->post_name !== sanitize_title($order_no)) {
			$order->post_name = sanitize_title($order_no);
			wp_update_post($order);
		}

		if ($order->post_status === 'publish') {
			$order->post_status = 'private';
			wp_update_post($order);
        }

	    if ($order_no && $status === 'pending_payment' && $_POST['set_paid']) {
			order_paid($order_no);
        }
    });

	register_post_type('promotion_code', array(
		'label' => '优惠码',
		'labels' => array(
			'all_items' => '所有优惠码',
			'add_new' => '添加优惠码',
			'add_new_item' => '新优惠码',
			'edit_item' => '编辑优惠码',
			'not_found' => '未找到优惠码'
		),
		'show_ui' => true,
		'show_in_menu' => true,
		'supports' => array('title'),
		'taxonomies' => array('post_tag'),
		'menu_icon' => 'dashicons-megaphone',
	));

	add_filter('manage_promotion_code_posts_columns', function($columns) {
		$new_columns = array(
			'cb' => $columns['cb'],
			'title' => $columns['title'],
			'user' => '付款用户',
			'total_paid' => '总付款',
			'expires_at' => '过期时间'
		);
		return $new_columns;
	});

	add_action('manage_promotion_code_posts_custom_column', function($column_name) {
		global $post;
		switch ($column_name ) {
			case 'user' :
				$users = get_post_meta($post->ID, 'user');
				echo count($users);
				break;
			case 'total_paid' :
				$total_paid = get_post_meta($post->ID, 'total_paid', true);
				echo $total_paid;
				break;
			case 'expires_at' :
				$expires_at = get_post_meta($post->ID, 'expires_at', true);
				echo date('Y-m-d', $expires_at + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
				break;
			default;
		}
	});

	add_action('acf/update_value/name=expires_at', function ($expires_at_date) {
        if(strtotime($expires_at_date)) {
            return strtotime($expires_at_date) - get_option( 'gmt_offset' ) * HOUR_IN_SECONDS;
        }
        else {
            return $expires_at_date;
        }
    });

	add_action('acf/load_value/name=expires_at', function ($expires_at) {
	    if ($expires_at) {
			return date('Y-m-d', $expires_at + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
        }
    });

	add_action('restrict_manage_posts', function() {
		
	    global $current_screen;
		
		if ($current_screen->post_type == 'member_order') {
			
			$available_statuses = array('pending_payment' => '待付款', 'paid' => '已付款', 'cancelled' => '已取消');
			
			echo '<select name="status">';
			echo '<option value="">所有状态</option>';
			
			foreach ($available_statuses as $status_name => $status_label) {
				$selected = (!empty($_GET['status']) && $_GET['status'] == $status_name ) ? ' selected="selected"' : '';
				echo '<option' . $selected . ' value="' . $status_name . '">' . $status_label . '</option>';
			}
			
			echo '</select>';
		}
	});

	add_filter('parse_query', function ($query) {
		if (is_admin() && $query->query['post_type'] === 'member_order') {
			$qv = &$query->query_vars;
			$qv['meta_query'] = array();
			if (!empty($_GET['status'])) {
				$qv['meta_query'][] = array(
					'field' => 'status',
					'value' => $_GET['status']
				);
			}
			if (!empty($_GET['price'])) {
				$qv['meta_query'][] = array(
					'field' => 'price',
					'value' => $_GET['price']
				);
			}
		}

		if (is_admin() && $query->query['post_type'] === 'promotion_code') {
			$qv = &$query->query_vars;
			if (empty($_GET['multi_time'])) {
				$qv['meta_query'][] = array(
					'field' => 'multi_time',
					'value' => '1'
				);
			}
        }
	});
});

add_filter('nav_menu_link_attributes', function($attrs, $item) {

	$attrs['class'] = $attrs['class'] ?: [];

	$attrs['class'][] = 'ln-tr';

	$attrs['class'] = implode(' ', $attrs['class']);

	$attrs['role'] = 'button';

	return $attrs;

}, 10, 2);

add_filter('nav_menu_css_class', function($classes, $item) {

	if(in_array('menu-item-has-children', $classes)) {
		$classes[] = 'haschild';
	}

	if(array_intersect(['current-menu-item', 'current-page-ancestor', 'current-post-ancestor', 'current-question_type_desc-ancestor', 'current-exercise-ancestor'], $classes ?: [])) {
		$classes[] = 'current_page_item';
	}

	if($item->menu_item_parent) {
		$classes[] = 'sub-item';
	}
	elseif(in_array('menu-item-has-children', $classes)) {
		$classes[] = 'parent-item';
	}

	if($item->title === 'Login') {
		$classes[] = 'login';
	}

	return $classes;

}, 10, 2);

/**
 * Simple helper function for make menu item objects
 *
 * @param $title      - menu item title
 * @param $url        - menu item url
 * @param $order      - where the item should appear in the menu
 * @param int $parent - the item's parent item
 * @return \stdClass
 */
function custom_nav_menu_item( $title, $url, $order, $parent = 0 ){
	$item = new stdClass();
	$item->ID = 1000000 + $order + parent;
	$item->db_id = $item->ID;
	$item->title = $title;
	$item->url = $url;
	$item->menu_order = $order;
	$item->menu_item_parent = $parent;
	$item->type = '';
	$item->object = '';
	$item->object_id = '';
	$item->classes = array();
	$item->target = '';
	$item->attr_title = '';
	$item->description = '';
	$item->xfn = '';
	$item->status = '';
	return $item;
}

add_filter('wp_get_nav_menu_items', function ($items, $menu) {

	if ( $menu->slug == 'primary' ) {
		// only add item to a specific menu
		if ( $menu->slug == 'primary' ){

			// only add profile link if user is logged in
			if ( get_current_user_id() ){
				$top = custom_nav_menu_item( '我的账户', get_author_posts_url( get_current_user_id() ), 100 );
				$items[] = $top;
				$items[] = custom_nav_menu_item( wp_get_current_user()->display_name, null, 101, $top->ID );
				$items[] = custom_nav_menu_item( '个人中心', site_url() . '/profile/', 103, $top->ID );
				$items[] = custom_nav_menu_item( '退出登录', site_url() . '/login/?logout=true', 102, $top->ID );
			}
		}

		return $items;
	}

	return $items;
}, 10, 2);

show_admin_bar( false );

/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'add_extra_tablenav');
function add_extra_tablenav($post_type) {
	$taxonomy  = 'question_type'; // change to your taxonomy
	$post_types = array('question_type_desc', 'tip', 'exercise');
	if (in_array($post_type, $post_types)) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => "全部{$info_taxonomy->label}",
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'hide_empty'      => false,
			'hierarchical'	  => true,
			'value_field'     => 'slug'
		));
	};
}
/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'team'; // change to your post type
	$taxonomy  = 'group'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

function redirect_login ($force = false) {

	if (!$force && is_user_logged_in()) {
		return;
	}

	header('Location: ' . site_url() . '/register/?intend=' . ($_SERVER['REQUEST_URI'])); exit;
}

function redirect_pricing_table ($cap) {
	if (current_user_can($cap)) {
		return;
	}
	else {
		header('Location: ' . site_url() . '/pricing-table/?intend=' . ($_SERVER['REQUEST_URI'])); exit;
	}
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
	add_post_meta($order->ID, 'refundable_amount', get_post_meta($order->ID, 'price', true));

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

	$service = get_post_meta($order->ID, 'service', true);

	if (in_array($service, array('tips', 'base', 'full'))) {
		$user->add_cap('view_tips');
	}

	if (in_array($service, array('exercises', 'base', 'full'))) {
		$user->add_cap('view_exercises');
	}

	if (in_array($service, array('full', 'reading'))) {
	    $inactivated_readings = get_user_meta($user->ID, 'service_reading_inactivated', true) ?: 0;
		update_user_meta($user->ID, 'service_reading_inactivated', ++$inactivated_readings);
	}

	if (in_array($service, array('full', 'writing'))) {
		$inactivated_writings = get_user_meta($user->ID, 'service_writing_inactivated', true) ?: 0;
		update_user_meta($user->ID, 'service_writing_inactivated', ++$inactivated_writings);
	}

	if (in_array($service, array('base', 'full'))) {
	    $service_tips_valid_after = get_user_meta($user->ID, 'service_tips_valid_before', true) ?: time();
		$service_exercises_valid_after = get_user_meta($user->ID, 'service_exercises_valid_before', true) ?: time();
		update_user_meta($user->ID, 'service_tips_valid_before', $service_tips_valid_after + 86400 * 30);
		update_user_meta($user->ID, 'service_exercises_valid_before', $service_exercises_valid_after + 86400 * 30);
    }

	if (in_array($service, array('tips', 'exercises', 'base', 'full'))) {
		$service_valid_after = get_user_meta($user->ID, 'service_' . $service . '_valid_before', true) ?: time();
		$service_expires_at = $service_valid_after + 86400 * 30;
		update_user_meta($user->ID, 'service_' . $service . '_valid_before', $service_expires_at);
	}

	$order_price = get_post_meta($order->ID, 'price', true);
	$order_service = get_post_meta($order->ID, 'service', true);

	// user total pay
	update_user_meta($user->ID, 'total_paid', (get_user_meta($user->ID, 'total_paid', true) ?: 0) + $order_price);

	// log to promotion_code for base & full package
	$promotion_code_id = get_post_meta($order->ID, 'promotion_code', true);
    if ($promotion_code_id && in_array($order_service, array('base', 'full'))) {
		add_post_meta($promotion_code_id, 'user', $user->ID);
		$promotion_code_total_paid = get_post_meta($promotion_code_id, 'total_paid', true) ?: 0;
		update_post_meta($promotion_code_id, 'total_paid', $promotion_code_total_paid + $order_price);
    }

	// invitation award and discount
	$inviter_id = get_user_meta($user->ID, 'invited_by_user', true);
	$service_awardable = in_array(get_post_meta($order->ID, 'service', true), array('base', 'full'));
	$discount_order = get_user_meta($user->ID, 'discount_order', true);

	if ($inviter_id && $service_awardable && !$discount_order) {

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

	$services = array ('full' => '听说读写大礼包', 'base' => '听力口语技巧+练习包', 'tips' => '听力口语技巧包', 'exercises' => '听力口语练习包', 'reading' => '阅读技巧包', 'writing' => '写作技巧包');
    $package_name = $services[$service];

    if (!$package_name) {
        error_log('Service package name not found: ' . $service);
        return false;
    }

	send_template_mail('subscribed-email', $user->user_email, array(
        'user_name' => $user->display_name,
        'package_name' => $services[$service],
        'expires_at' => isset($service_expires_at) ? date('Y-m-d H:i', $service_expires_at + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS) : '激活后24小时'
    ));

	return $order;
}

/**
 * @param $out_trade_no string order no in our system
 * @param $subject string order title
 * @param $total_fee number a price in basic unit
 * @param $currency string
 * @param $service string base, full, tips, exercises, reading or writing
 * @param $promotion_code string promotion code
 * @param $gateway string alipay, wechatpay or paypal
 */
function create_order ($out_trade_no, $subject, $total_fee, $currency, $service, $promotion_code, $gateway) {
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
	add_post_meta($order_id, 'service', $service);
	add_post_meta($order_id, 'status', 'pending_payment');

	add_post_meta($order_id, 'gateway', $gateway);

	if ($promotion_code) {
		$promotion_code_object = get_posts(array('post_type' => 'promotion_code', 'name' => $promotion_code, 'post_status' => 'private'))[0];

		if (!$promotion_code_object) {
			exit('错误的优惠码');
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

	if ($amount <= 0) {
		return;
	}

	$refundable = get_post_meta($order_id, 'refundable', true);

	if ($refundable <= 0) {
	    return;
    }

	switch (get_post_meta($order_id, 'gateway', true)) {
		case 'wechatpay':
			$input = new RoyalPayApplyRefund();
			$input->setOrderId($order_no);
			$input->setRefundId('refund.' . $order_no);
			$input->setFee($amount * 100);
			RoyalPayApi::refund($input);
			break;
		case 'paypal':
			$sale_id = get_post_meta($order_id, 'sale_id', true);
			paypal_sale_refund($sale_id, $amount);
			break;
		case 'alipay':
		default:
			(new AlipayRefund(get_alipay_config()))->refund($order_no, $amount);
	}

	update_post_meta($order_id, 'refundable_amount',
		round(get_post_meta($order_id, 'refundable_amount', true) - $amount, 2)
	);

	$user = get_post_meta(get_post($order_id)->ID, 'user', true);

	update_user_meta($user, 'total_awarded', get_user_meta($user, 'total_awarded', true) + $amount);
}

function pter_adjacent_post_where ($where) {

	global $post;

	if ($post->post_type === 'exercise' && $_GET['tag'] !== 'free-trial') {
		$where = str_replace('p.post_date', 'p.ID', $where);
		$where = preg_replace('/\'\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}\'/', $post->ID, $where);
		return $where;
	}

	return $where;
};

function pter_previous_post_sort ($orderby) {

	global $post;

	if ($post->post_type === 'exercise' && $_GET['tag'] !== 'free-trial') {
		return 'ORDER BY p.ID DESC LIMIT 1';
	}

	return $orderby;
}

function pter_next_post_sort ($orderby) {

	global $post;

	if ($post->post_type === 'exercise' && $_GET['tag'] !== 'free-trial') {
		return 'ORDER BY p.ID ASC LIMIT 1';
	}

	return $orderby;
}

add_filter('get_previous_post_where', 'pter_adjacent_post_where');
add_filter('get_next_post_where', 'pter_adjacent_post_where');
add_filter('get_previous_post_sort', 'pter_previous_post_sort');
add_filter('get_next_post_sort', 'pter_next_post_sort');

add_action('login_enqueue_scripts', function () { ?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(<?=get_stylesheet_directory_uri()?>/assets/img/logo-admin.png);
			height:100px;
			width:250px;
			background-size: contain;
			background-repeat: no-repeat;
			padding-bottom: 30px;
		}
		#nav {
			display: none;
		}
	</style>
	<?php
});

add_filter ('sanitize_user', function ($username, $raw_username, $strict) {
	$username = wp_strip_all_tags( $raw_username );
	$username = remove_accents( $username );
	// Kill octets
	$username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
	$username = preg_replace( '/&.+?;/', '', $username ); // Kill entities

	// 网上很多教程都是直接将$strict赋值false，
	// 这样会绕过字符串检查，留下隐患
	if ($strict) {
		$username = preg_replace ('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $username);
	}

	$username = trim( $username );
	// Consolidate contiguous whitespace
	$username = preg_replace( '|\s+|', ' ', $username );

	return $username;
}, 10, 3);

add_action('bingo_caps_clean', 'clean_expired_user_caps');

function clean_expired_user_caps () {
    foreach (array('tips', 'exercises', 'reading', 'writing') as $service) {
		$users = get_users(array('meta_key' => 'service_' . $service . '_valid_before', 'meta_compare' => '<', 'meta_value' => (string)time()));
		foreach ($users as $user) {
			$user->remove_cap('view_' . $service);
		}
    }
}

add_action('bingo_subscription_remind', 'remind_unsubscribed_users');

function remind_unsubscribed_users () {
    $users = get_users(array(
        'date_query' => array (
            'after' => date('Y-m-d H:i:s', time() - 8 * 86400),
            'before' => date('Y-m-d H:i:s', time() - 7 * 86400),
        ))
    );
    foreach ($users as $user) {
        if (!$user->can('view_tips') && !$user->can('view_exercises')) {
            send_template_mail('subscription-reminder-email', $user->user_email, array('user_name' => $user->display_name));
        }
    }
}

add_filter('wpjam_cdn_host', function ($host) {
    if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
        return defined('CDN_CN') ? CDN_CN : site_url() . '/';
    }
    return $host;
}, 11);

add_action('bingo_refresh_apnic_cn_ip_range', 'bingo_refresh_apnic_cn_ip_range');

function bingo_refresh_apnic_cn_ip_range () {
	shell_exec(ABSPATH . '/ispip.sh');
}

// Display User IP in WordPress
function get_the_user_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        //to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

/**
 * send template mail by sendgrid
 *
 * @param $template_slug string slug for the template email post
 * @param $to string a single email address
 * @param array $args key value pairs of arguments
 * @return bool send result
 */
function send_template_mail ($template_slug, $to, $args = array()) {

    $template = get_page_by_path($template_slug, OBJECT, 'post');
    $template_id = get_the_subtitle($template);

    if (!$template || !$template_id) {
        error_log('Email template not found: ' . $template_slug);
        return false;
    }

	$headers = new SendGrid\Email();
    $headers->setTemplateId($template_id);

	foreach ($args as $key => $value) {
		$headers->addSubstitution('[%' . $key . '%]', array($value));
    }

    error_log('[Bingo] Template email "' . $template_slug . '"" sent to ' . $to . ' ' . json_encode($args, JSON_UNESCAPED_UNICODE));
	
    $result =  wp_mail($to, '', '', $headers);

	if (!$result) {
	    error_log('Email sent fail, to: ' . $to . ', header was: ' . json_encode($headers, JSON_UNESCAPED_UNICODE));
    }

	return $result;
}
