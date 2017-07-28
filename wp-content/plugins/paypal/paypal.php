<?php
/*
Plugin Name: Paypal
Plugin URI: https://github.com/paypal/PayPal-PHP-SDK
Description: Paypal SDK for online payment.
Author: Uice Lu, Paypal
Version: 1.12.0
Author URI: https://developer.paypal.com
*/

require_once __DIR__ . '/refund.php';

add_action('init', function () {
	add_rewrite_rule('payment/paypal/?$', 'index.php?paypal=submit', 'top');
	add_rewrite_rule('payment/paypal/execute/?$', 'index.php?paypal=execute', 'top');
});

add_filter('query_vars', function ($vars) {
	$vars[] = 'paypal';
	return $vars;
});

/* Template Include */
add_filter('template_include', function ($template) {

	global $wp_query; //Load $wp_query object

	$page_value = $wp_query->query_vars['paypal']; //Check for query var "blah"

	if ($page_value && $page_value === 'submit') { //Verify "paypal" exists and value is "submit".
		return plugin_dir_path(__FILE__) . 'submit.php'; //Load your template or file
	}
	else if ($page_value && $page_value === 'execute') { //Verify "paypal" exists and value is "execute".
		return plugin_dir_path(__FILE__) . 'execute.php'; //Load your template or file
	}

	return $template; //Load normal template when $page_value != "true" as a fallback

}, 1, 1);

function paypal_get_api_context () {
	$apiContext = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
			PAYPAL_CLIENT_ID,     // ClientID
			PAYPAL_CLIENT_SECRET      // ClientSecret
		)
	);
	$apiContext->setConfig(array('mode' => 'live'));
	return $apiContext;
}