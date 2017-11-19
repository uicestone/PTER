<?php

add_action('after_switch_theme', function () {
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
