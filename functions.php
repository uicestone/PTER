<?php

require __DIR__ . '/includes/admin.php';
require __DIR__ . '/includes/cap.php';
require __DIR__ . '/includes/cron.php';
require __DIR__ . '/includes/enqueue.php';
require __DIR__ . '/includes/nav.php';
require __DIR__ . '/includes/order.php';
require __DIR__ . '/includes/post_type.php';
require __DIR__ . '/includes/shortcode.php';

add_action('init', function () {

//	remove_filter('template_redirect','redirect_canonical');

	global $is_cn_ip;
	$is_cn_ip = is_cn_ip();
});

function pter_adjacent_post_where ($where, $in_same_term, $excluded_terms, $taxonomy, $post) {

	global $post, $wpdb;

	$question_types = wp_get_object_terms($post->ID, 'question_type', array('orderby' => 'id'));

	if ($post->post_type === 'exercise' && $_GET['tag'] !== 'free-trial') {
		$where = str_replace('p.post_date', 'p.ID', $where);
		$where = preg_replace('/\'\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}\'/', $post->ID, $where);

		if (count($question_types) > 1 && $question_sub_type = $question_types[count($question_types)-1]) {
			$where .= " AND ID IN (
                        SELECT p.ID FROM {$wpdb->posts} AS p 
                        JOIN {$wpdb->term_relationships} AS tr ON tr.object_id=p.ID 
                        JOIN {$wpdb->term_taxonomy} AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id 
                        JOIN {$wpdb->terms} AS t ON t.term_id = tt.term_id 
                        WHERE t.slug='{$question_sub_type->slug}' )";
		}

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

add_filter('get_previous_post_where', 'pter_adjacent_post_where', 10, 5);
add_filter('get_next_post_where', 'pter_adjacent_post_where', 10, 5);
add_filter('get_previous_post_sort', 'pter_previous_post_sort');
add_filter('get_next_post_sort', 'pter_next_post_sort');

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

add_filter('wpjam_cdn_host', function ($host) {
    global $is_cn_ip;
    if ($is_cn_ip) {
        return defined('CDN_CN') ? CDN_CN : site_url() . '/';
    }
    return $host;
}, 11);

// Remove '私密：' from private post titles
add_filter('the_title', function ($title) {

	// $title = esc_attr($title);

	$findthese = array(
		'#私密：#'
	);

	$replacewith = array(
		'', // What to replace "Protected:" with
		'' // What to replace "Private:" with
	);

	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
});

// Display User IP in WordPress
function get_the_user_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        //to check ip is pass from proxy
		$ip = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function is_cn_ip ($ip = null) {

	$apnic_all_ip_file = wp_get_upload_dir()['basedir'] . '/../cache/ispip/apnic_all_ip';

	if (!file_exists($apnic_all_ip_file)) {
	    return false;
    }

	if (!$ip) {
        $ip = get_the_user_ip();
    }

    if (strpos($ip, '.') === false) {
	    return false;
    }

    $ranges = explode("\n", file_get_contents($apnic_all_ip_file));

    foreach ($ranges as $range) {
        if ($range && cidr_match($ip, $range)) {
            return true;
        }
    }

    return false;
}

function cidr_match($ip, $range)
{
	list ($subnet, $bits) = explode('/', $range);

	if ($bits > 32) {
	    return false;
    }

	$ip = ip2long($ip);
	$subnet = ip2long($subnet);
	$mask = -1 << (32 - $bits);
	$subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
	return ($ip & $mask) == $subnet;
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

    $result =  wp_mail($to, '', '', $headers);

	if ($result) {
		error_log('[Bingo] Template email "' . $template_slug . '" sent to ' . $to . ' ' . json_encode($args));
	} else {
		error_log('Email sent fail, to: ' . $to . ', header was: ' . json_encode($headers, JSON_UNESCAPED_UNICODE));
    }

	return $result;
}

/**
 *
 * Synchronize a set of user meta value.
 * Will only add and remove the difference.
 *
 * @param int $user_id
 * @param string $meta_key
 * @param array $new_values
 * @param array $old_values optional
 */
function sync_user_meta($user_id, $meta_key, array $new_values, $old_values = null){

	if(is_null($old_values)){
		$old_values = get_user_meta($user_id, $meta_key);
	}

	foreach(array_diff($new_values, $old_values) as $value_to_add){
		add_user_meta($user_id, $meta_key, $value_to_add);
	}
	foreach(array_diff($old_values, $new_values) as $value_to_delete){
		delete_user_meta($user_id, $meta_key, $value_to_delete);
	}

}
