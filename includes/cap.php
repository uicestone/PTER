<?php

add_action('after_switch_theme', function () {
	// if ( !function_exists( 'populate_roles' ) ) {
	// 	require_once( ABSPATH . 'wp-admin/includes/schema.php' );
	// }
	// populate_roles();

	$administrator = get_role('administrator');
	$administrator->add_cap('view_tips');
	$administrator->add_cap('view_exercises');
	$administrator->add_cap('view_ccl');

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

	$editor = get_role('editor');
	$editor->add_cap('edit_paper');
	$editor->add_cap('read_paper');
	$editor->add_cap('delete_paper');
	$editor->add_cap('edit_papers');
	$editor->add_cap('edit_others_papers');
	$editor->add_cap('publish_papers');
	$editor->add_cap('read_private_papers');
	$editor->add_cap('edit_papers');

});

function redirect_login ($force = false) {

	if (!$force && is_user_logged_in()) {
		return;
	}

	if (is_google_bot()) {
		return;
	}

	header('Location: ' . pll_home_url() . 'register/?intend=' . urlencode($_SERVER['REQUEST_URI'])); exit;
}

function is_google_bot () {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	return strpos($ua, 'Googlebot') !== false || isset($_GET['googlebot_test']);
}

/**
 * redirect a user to pricing table if no enough capability to current content
 *
 * @param $post
 * @return
 */
function ensure_user_cap_on($post) {

	if (has_tag('free-trial', $post->ID)) {
		return true;
	}

	if (is_google_bot()) {
		return true;
	}

	redirect_login();
	$user = wp_get_current_user();

	if (current_user_can('edit_user')) {
		return true;
	}

	if ((is_limited_free($user->ID) && has_tag('limited-free', $post->ID))) {
		return true;
	}

	$question_types = get_post_question_types_family($post);

	$user_meta = get_user_meta($user->ID);

	$user_cap_products = array();
	foreach ($user_meta as $key => $value) {
		preg_match('/^product_(.+?)_valid_before/', $key, $matches);
		if (!$matches) continue;
		if ($value[0] < time()) continue;
		$user_cap_products[] = $matches[1];
	}

	if (array_intersect($user_cap_products, $question_types)) {
		return true;
	}

	header('Location: ' . pll_home_url() . 'pricing-table/?products=' . implode(',', $question_types) . '&intend=' . rawurlencode($_SERVER['REQUEST_URI'])); exit;

}
