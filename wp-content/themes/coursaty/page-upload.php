<?php

if ( ! function_exists( 'wp_handle_upload' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

$file = wp_handle_upload($_FILES['file'], array('test_form' => false));

if ( $file && ! isset( $movefile['error'] ) ) {
	echo $file['url'];
} else {
	/**
	 * Error generated by _wp_handle_upload()
	 * @see _wp_handle_upload() in wp-admin/includes/file.php
	 */
	echo $file['error'];
}