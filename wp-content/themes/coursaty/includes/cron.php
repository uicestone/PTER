<?php

add_action('after_switch_theme', function () {

	if (!wp_next_scheduled('bingo_caps_clean')) {
		wp_schedule_event(strtotime('+1 hour') - time() % 3600, 'hourly', 'bingo_caps_clean');
	}

	if (!wp_next_scheduled('bingo_subscription_remind')) {
		wp_schedule_event(strtotime('today 20:00') - get_option('gmt_offset') * HOUR_IN_SECONDS, 'daily', 'bingo_subscription_remind');
	}

	if (!wp_next_scheduled('bingo_member_scoop')) {
		wp_schedule_event(strtotime('today 20:00') - get_option('gmt_offset') * HOUR_IN_SECONDS, 'daily', 'bingo_member_scoop');
	}

	if (!wp_next_scheduled('bingo_expiring_remind')) {
		wp_schedule_event(strtotime('today 20:30') - get_option('gmt_offset') * HOUR_IN_SECONDS, 'daily', 'bingo_expiring_remind');
	}

	if (!wp_next_scheduled('bingo_refresh_apnic_cn_ip_range')) {
		wp_schedule_event(time(), 'daily', 'bingo_refresh_apnic_cn_ip_range');
	}

});

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

	// 只在周二发送
	if (date('w', time() + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS) !== 2) {
		return;
	}

	$users = get_users();

	foreach ($users as $user) {

		// 有权限的不发送
		if ($user->can('view_tips') || $user->can('view_exercises')) {
			return;
		}

		send_template_mail('subscription-reminder-email', $user->user_email, array('user_name' => $user->display_name));
	}
}

add_action('bingo_member_scoop', 'send_member_scoop');

function send_member_scoop () {

	// 只在周一发送
	if (date('w', time() + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS) !== 1) {
		return;
	}

	$users = get_users(array(
		'meta_query' => array (
			'relation' => 'OR',
			array('key' => 'service_tips_valid_before', 'value' => time(), 'compare' => '>='),
			array('key' => 'service_exercises_valid_before', 'value' => time(), 'compare' => '>=')
		))
	);

	foreach ($users as $user) {
		// 注册后每三周发送
		if ((time() - strtotime($user->user_registered)) / (86400 * 7) % 3 === 0) {
			send_template_mail('member-scoop-email', $user->user_email, array('user_name' => $user->display_name));
		}
	}
}

add_action('bingo_expiring_remind', 'remind_expiring_users');

function remind_expiring_users () {
	foreach (array('exercises', 'tips') as $section) {
		$meta_key = 'service_' . $section . '_valid_before';

		$users = get_users(array(
			'meta_key' => $meta_key,
			'meta_value' => time() + 86400 * 7,
			'meta_compare' => '<='
		));

		foreach ($users as $user) {
			send_template_mail('expiring-reminder-email', $user->user_email, array('user_name' => $user->display_name));
		}
	}

}

add_action('bingo_refresh_apnic_cn_ip_range', 'bingo_refresh_apnic_cn_ip_range');

function bingo_refresh_apnic_cn_ip_range () {
	shell_exec(ABSPATH . '/ispip.sh');
}
