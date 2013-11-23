<?php

if(!function_exists('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

define('ENGINEPATH', dirname(__FILE__));
define('ENGINEURI', get_theme_root_uri().'/engine');

require_once ENGINEPATH.'/engine-i18n.php';

require_once ENGINEPATH.'/engine-roles.php';

require_once ENGINEPATH.'/engine-quizz-config.php';

require_once ENGINEPATH.'/engine-admin-ui.php';

require_once ENGINEPATH.'/engine-quizz.php';
require_once ENGINEPATH.'/engine-quizz-acf.php';

// ---------------- ENGINE ----------------

function engine_theme_setup($config) {
	global $engineConfig;

	$engineConfig = array_merge(array(
		'textdomain' => ''
	), $config);

	if($config['textdomain'] !== '') {
		add_action('after_setup_theme', 'engine_after_setup_theme');
	}
}

function engine_config($key = false, $default = '') {
	global $engineConfig;

	if(!$key) {
		return $engineConfig;
	}

	if(isset($engineConfig[$key])) {
		return $engineConfig[$key];
	}

	return $default;
}

function update_engine_config($key, $value) {
	global $engineConfig;

	$engineConfig[$key] = $value;

	return true;
}

function engine_after_setup_theme() {
	$textdomain = engine_config('textdomain', '');
	load_theme_textdomain($textdomain, get_template_directory() . '/languages');
}