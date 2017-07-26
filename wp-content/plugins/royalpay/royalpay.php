<?php
/*
Plugin Name: RoyalPay
Plugin URI: https://mpay.royalpay.com.au/static/phpdemo.zip
Description: RoyalPay Wechat Payment SDK for PHP.
Author: qiniu
Version: 1.0
Author URI: https://www.royalpay.com.au/
*/

require_once 'lib/RoyalPay.Api.php';

add_action('activate_' . plugin_basename(__FILE__), function () {
	add_rewrite_rule('payment/wechatpay/notify/?$', 'index.php?royalpay=notify', 'top');
	add_rewrite_rule('payment/wechatpay/?$', 'index.php?royalpay=submit', 'top');
	flush_rewrite_rules();
});

add_filter('query_vars', function ($vars) {
	$vars[] = 'royalpay';
	return $vars;
});

/* Template Include */
add_filter('template_include', function ($template) {

	global $wp_query; //Load $wp_query object

	$page_value = $wp_query->query_vars['royalpay']; //Check for query var "blah"

	if ($page_value && $page_value === 'submit') { //Verify "royalpay" exists and value is "submit".
		return plugin_dir_path(__FILE__) . 'submit.php'; //Load your template or file
	}
	else if ($page_value && $page_value === 'notify') { //Verify "royalpay" exists and value is "notify".
		return plugin_dir_path(__FILE__) . 'notify.php'; //Load your template or file
	}

	return $template; //Load normal template when $page_value != "true" as a fallback

}, 1, 1);
