<?php

if(!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit;
}

// ---------------- ADD ADMIN MENU SEPARATOR FUNCTION ----------------

function getset_option($name, $default, $newValue = null) {
  if(!is_null($newValue)) {
    update_option($name, $newValue);
  }
  return get_option($name, $default);
}

function quizz_item_name() {
  return 'Quizz';
}

function quizz_interval_time($newValue = null) {
  return getset_option('quizz_interval_time', '30', $newValue); // Default 30min
}

function quizz_participate_time($newValue = null) {
  return getset_option('quizz_participate_time', '60', $newValue); // Default 30min
}

function quizz_respond_time($newValue = null) {
  return getset_option('quizz_respond_time', '30', $newValue); // Default 30sec
}