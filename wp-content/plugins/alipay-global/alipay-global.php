<?php
/*
Plugin Name: Alipay Global
Plugin URI: https://global.alipay.com/service/website/4
Description: Alipay SDK for cross-border online payment.
Author: Alipay
Version: 3.3.0
Author URI: https://www.alipay.com/
*/

require __DIR__ . '/lib/alipay_refund.class.php';

add_action('activate_' . plugin_basename(__FILE__), function () {
	add_rewrite_rule('payment/alipay/notify/?$', 'index.php?alipay-global=notify', 'top');
	add_rewrite_rule('payment/alipay/return/?$', 'index.php?alipay-global=return', 'top');
	add_rewrite_rule('payment/alipay/?$', 'index.php?alipay-global=submit', 'top');
});

add_filter('query_vars', function ($vars) {
	$vars[] = 'alipay-global';
	return $vars;
});

/* Template Include */
add_filter('template_include', function ($template) {

	global $wp_query; //Load $wp_query object

	$page_value = $wp_query->query_vars['alipay-global']; //Check for query var "blah"

	if ($page_value && $page_value === 'submit') { //Verify "alipay-global" exists and value is "submit".
		return plugin_dir_path(__FILE__) . 'submit.php'; //Load your template or file
	}
	else if ($page_value && $page_value === 'notify') { //Verify "alipay-global" exists and value is "notify".
		return plugin_dir_path(__FILE__) . 'notify.php'; //Load your template or file
	}
	else if ($page_value && $page_value === 'return') { //Verify "alipay-global" exists and value is "return".
		return plugin_dir_path(__FILE__) . 'return.php'; //Load your template or file
	}

	return $template; //Load normal template when $page_value != "true" as a fallback

}, 1, 1);

function get_alipay_config () {
	return array(
		'partner' => get_option('alipay_partner'),
		'key' => get_option('alipay_key'),
		'cacert' => getcwd().'\\cacert.pem',
		'notify_url' => get_option('alipay_notify_url'),
		'return_url' => get_option('alipay_return_url'),
		'sign_type' => strtoupper('MD5'),
		'input_charset' => strtolower('utf-8'),
		'transport' => 'http',
		'service' => 'create_forex_trade'
	);
}
