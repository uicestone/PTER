<?php

add_action('init', function () {

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

add_filter( 'user_contactmethods', function ( $contactmethods ) {
	$contactmethods['mobile'] = '手机号';
	return $contactmethods;
}, 10, 1 );

add_filter( 'manage_users_columns', function ( $column ) {
	$column['posts'] = '发布内容';
	$column = array_slice($column, 0, 4, true) +
		['mobile' => '手机号'] +
		array_slice($column, 4, null, true);

	return $column;
} );

add_filter( 'manage_users_custom_column', function ( $val, $column_name, $user_id ) {
	switch ($column_name) {
		case 'mobile' :
			return get_the_author_meta( 'mobile', $user_id );
			break;
		default:
	}
	return $val;
}, 10, 3 );
