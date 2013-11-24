<?php
/*
 * = API RESTful =========================================================
 *
 * UserObject:
 *   {username: <string>, avatar: <string>, points: <int>}
 *
 * QuizzObject:
 *   {id: <int>, participateTime: <int>, respondTime: <int>, question: <string>, answers: {'A': <string>, 'B': <string>, 'C': <string>, 'D': <string>, ...}}
 *
 * QuizzResultObject:
 *   {date: <string>, winner: <UserObject>, members: [<UserObject>, ...], message: <string>}
 *
 *
 * /
 *   return: HTML with help
 *
 * /avatars
 *   return: {avatars: [<string>, <string>, ...]}
 *
 * /register?channel=<string>&username=<string>&avatar=<string>
 *   return: {success: <bool> [, error=<string]}
 *
 * /play?channel=<string>&username=<string>
 *   return: {quizz: <QuizzObject or null>, quizzResult: <QuizzResultObject or null>, points: <int>}
 *
 * /answer?channel=<string>&username=<string>&quizzId=<int>&quizzAnswer=<string>
 *   return: {success: <bool> [, error=<string]}
 *
 * /results?channel=<string>&count=<int>
 *   return: {results: [<QuizzResultObject>, ...]}
 *
 * /scores?channel=<string>
 *   return: {scores: [<UserObject>, ...]}
 *
 *
 *
 * = Chrome extension actions order =========================================================
 *
 * First start:
 *   1) Get avatars list -> show register form (INPUTS: username + channel + avatar)
 *   2) Register user access with /register
 *   3) Keep in hard memory these informations (Local storage ?) 
 *
 * Second start:
 *   1) Get user informations from hard memory
 *
 * Playing:
 *   1) Each 5 sec, call /play
 *   2) IN CASE quizz IS NOT NULL -> Notify user -> On click on the extension icon before time elapsed, show Quizz form 
 *   3) IN CASE result IS NOT NULL -> Notify user -> On click on the extension icon (if no quizz is working), show 5 lasts results
 *   4) Update user points
 *
 */

if(!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit;
}

// ---------------- CREATE URL REDIRECTIONS ----------------

function tq_rewrites_url() {
  add_rewrite_rule('avatars/?$', 'index.php?action=avatars', 'top');
  add_rewrite_rule('canplay/([0-9a-zA-Z-_]+)/?$', 'index.php?action=canplay&channel=$matches[1]', 'top');
  add_rewrite_rule('play/([0-9a-zA-Z-_]+)/?$', 'index.php?action=play&channel=$matches[1]', 'top');
  add_rewrite_rule('answer/([0-9a-zA-Z-_]+)/?$', 'index.php?action=answer&channel=$matches[1]', 'top');
  add_rewrite_rule('results/([0-9a-zA-Z-_]+)/?$', 'index.php?action=results&channel=$matches[1]', 'top');
}
add_action('init', 'tq_rewrites_url');

function tq_query_vars($query_vars) {
    $query_vars[] = 'action';
    $query_vars[] = 'channel';
    return $query_vars;
}
add_filter('query_vars', 'tq_query_vars');

// ---------------- CHANNELS ----------------

function get_channel() {
  return strtolower(get_query_var('channel'));
}

// ---------------- AVATARS ----------------

define('AVATARSPATH', ABSPATH.'/userpictures');
define('AVATARSURI', home_url().'/userpictures');

function get_avatars() {
  return array_filter(scandir(AVATARSPATH), function($value) {
    return pathinfo($value, PATHINFO_EXTENSION) == 'png';
  });
}

// ---------------- TABLES ----------------

function table_users() {
  global $wpdb;
  return $wpdb->prefix . 'quizzusers';
}

function table_channels() {
  global $wpdb;
  return $wpdb->prefix . 'quizzchannels';
}

function table_results() {
  global $wpdb;
  return $wpdb->prefix . 'quizzresults';
}

function tq_create_tables() {
  global $wpdb;

  $tableUsers = table_users();
  $tableChannels = table_channels();
  $tableResults = table_results();

  if($wpdb->get_var('SHOW TABLES LIKE "' . $tableUsers . '"') != $tableUsers) {
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta('CREATE TABLE ' . $tableUsers . '(
      id int(11) NOT NULL AUTO_INCREMENT,
      channel varchar(255) DEFAULT NULL,
      name varchar(255) DEFAULT NULL,
      avatar varchar(255) DEFAULT NULL,
      points int(11) DEFAULT 0,
      UNIQUE KEY id (id)
    )');

    dbDelta('CREATE TABLE ' . $tableChannels . '(
      id int(11) NOT NULL AUTO_INCREMENT,
      channel varchar(255) DEFAULT NULL,
      playDate int(11) DEFAULT 0,
      quizz int(11) DEFAULT 0,
      members TEXT,
      results TEXT,
      UNIQUE KEY id (id)
    )');

    dbDelta('CREATE TABLE ' . $tableResults . '(
      id int(11) NOT NULL AUTO_INCREMENT,
      channel varchar(255) DEFAULT NULL,
      date int(11) DEFAULT 0,
      winner int(11) DEFAULT 0,
      members TEXT,
      message TEXT,
      UNIQUE KEY id (id)
    )');
  }

  //$row = $wpdb->get_row($wpdb->prepare('SELECT COUNT(*) FROM '.$tableUsers));
  //var_dump($row);
}
add_action('init', 'tq_create_tables');