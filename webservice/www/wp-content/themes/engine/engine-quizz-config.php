<?php

if(!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit;
}

// ---------------- QUIZZ CONFIGURATIONS ----------------

function getset_option($name, $default, $newValue = null) {
  if(!is_null($newValue)) {
    update_option($name, $newValue);
  }
  return get_option($name, $default);
}

function quizz_item_name() {
  return 'Quizz';
}

function quizz_win_points($newValue = null) {
  return (int)getset_option('quizz_win_points', '1', $newValue); // Default 1
}

function quizz_chrome_extension_ajax_time() {
  return 4; // Default 5sec
}

function quizz_interval_time($newValue = null) {
  return (int)getset_option('quizz_interval_time', '30', $newValue); // Default 30min
}

function quizz_participate_time($newValue = null) {
  return (int)getset_option('quizz_participate_time', '60', $newValue); // Default 60sec
}

function quizz_respond_time($newValue = null) {
  return (int)getset_option('quizz_respond_time', '30', $newValue); // Default 30sec
}

function quizz_events_percent($newValue = null) {
  return (int)getset_option('quizz_events_percent', '50', $newValue); // Default 50
}

function quizz_event_theft_points($newValue = null) {
  return (int)getset_option('quizz_event_theft_points', '2', $newValue); // Default 2
}