<?php

if(!function_exists('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

// ---------------- I18N THEME FUNCTION ----------------

function _t($text) {
	_e($text, engine_config('textdomain', ''));
}

function __t($text) {
	return __($text, engine_config('textdomain', ''));
}

function _tn($single, $plural, $number) {
	return _n($single, $plural, $number, engine_config('textdomain', ''));
}

function __tx($text, $context) {
	_x($text, $context, engine_config('textdomain', ''));
}

function _tx($text, $context) {
	return _ex($text, $context, engine_config('textdomain', ''));
}

function _tnx($single, $plural, $number, $context) {
	return _nx($single, $plural, $number, $context, engine_config('textdomain', ''));
}