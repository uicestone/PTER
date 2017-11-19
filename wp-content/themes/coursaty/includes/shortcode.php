<?php

add_shortcode('blank', function ($attrs) {

	$options = [];

	if (isset($attrs['options'])){
		$options = explode(',', $attrs['options']);
	}

	return '<span class="blank' . ($options ? ' has-options' : '') . '"></span>' . ($options ? ('<select><option></option>' . implode(' ', array_map(function ($option) {
				return '<option>' . $option . '</option>';
			}, $options)) . '</select>') : '');
});

add_shortcode('options', function ($attr) {
	if (empty($attr['options'])) {
		return 'Error: no options were set.';
	}

	$options = explode(',', $attr['options']);

	return '<div class="options"><hr>' . implode(' ', array_map(function ($option) { return '<span class="option">' . $option . '</span>'; }, $options)) . '</div>';
});

add_shortcode('sup', function ($attrs, $content) {
	return '<sup><i class="fa fa-info-circle"></i><span>' . $content . '</span></sup>';
});
