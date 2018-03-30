<?php

add_action('after_switch_theme', function () {
	// if ( !function_exists( 'populate_roles' ) ) {
	// 	require_once( ABSPATH . 'wp-admin/includes/schema.php' );
	// }
	// populate_roles();

	$administrator = get_role('administrator');
	$administrator->add_cap('view_tips');
	$administrator->add_cap('view_exercises');

	$administrator->add_cap('edit_question_type_desc');
	$administrator->add_cap('read_question_type_desc');
	$administrator->add_cap('delete_question_type_desc');
	$administrator->add_cap('edit_question_type_descs');
	$administrator->add_cap('edit_others_question_type_descs');
	$administrator->add_cap('publish_question_type_descs');
	$administrator->add_cap('read_private_question_type_descs');
	$administrator->add_cap('edit_question_type_descs');
	$administrator->add_cap('edit_member_order');
	$administrator->add_cap('read_member_order');
	$administrator->add_cap('delete_member_order');
	$administrator->add_cap('edit_member_orders');
	$administrator->add_cap('edit_others_member_orders');
	$administrator->add_cap('publish_member_orders');
	$administrator->add_cap('read_private_member_orders');
	$administrator->add_cap('edit_member_orders');
	$administrator->add_cap('edit_paper');
	$administrator->add_cap('read_paper');
	$administrator->add_cap('delete_paper');
	$administrator->add_cap('edit_papers');
	$administrator->add_cap('edit_others_papers');
	$administrator->add_cap('publish_papers');
	$administrator->add_cap('read_private_papers');
	$administrator->add_cap('edit_papers');
	$administrator->add_cap('edit_promotion_code');
	$administrator->add_cap('read_promotion_code');
	$administrator->add_cap('delete_promotion_code');
	$administrator->add_cap('edit_promotion_codes');
	$administrator->add_cap('edit_others_promotion_codes');
	$administrator->add_cap('publish_promotion_codes');
	$administrator->add_cap('read_private_promotion_codes');
	$administrator->add_cap('edit_promotion_codes');
});

function redirect_login ($force = false) {

	if (!$force && is_user_logged_in()) {
		return;
	}

	if (is_google_bot()) {
		return;
	}

	header('Location: ' . site_url() . '/register/?intend=' . ($_SERVER['REQUEST_URI'])); exit;
}

function redirect_pricing_table ($cap) {

	global $post_require_payment;
	$post_require_payment = true;

	redirect_login();

	if (is_google_bot()) {
		return;
	}

	if (current_user_can($cap)) {
		return;
	}
	else {
		header('Location: ' . site_url() . '/pricing-table/?intend=' . ($_SERVER['REQUEST_URI'])); exit;
	}
}

function is_google_bot () {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	return $ua === 'Googlebot' || isset($_GET['googlebot_test']);
}
