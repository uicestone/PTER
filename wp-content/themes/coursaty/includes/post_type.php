<?php

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
		'has_archive' => true,
		'capability_type' => 'question_type_desc'
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
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes', 'comments'),
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
		'capability_type' => 'member_order'
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
		'capability_type' => 'promotion_code'
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

});
