<?php

add_action('after_setup_theme', function () {
  load_theme_textdomain('bingo', get_template_directory() . '/languages');
});

add_action('wp', function() {

  // Localize the script with new data
  $translation_array = array(
    '__' => pll_current_language(),
  );
  wp_localize_script( 'main', 'locale', $translation_array );
});

function language_slug_suffix () {
  if (pll_current_language() === pll_default_language()) {
    return '';
  }
  else {
    return '-' . pll_current_language();
  }
}

if (function_exists('pll_home_url')) {
	function site_url_ml($uri = '') {
		return pll_home_url() . preg_replace('/^\//', '', $uri);
	}
}
