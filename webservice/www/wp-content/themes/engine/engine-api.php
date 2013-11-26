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
 * /register/<channel>?username=<string>&avatar=<string>
 *   return: {success: <bool> [, error=<string]}
 *
 * /play/<channel>?username=<string>
 *   return: {quizz: <QuizzObject or null>, quizzResult: <QuizzResultObject or null>, points: <int>}
 *
 * /answer/<channel>?username=<string>&quizzId=<int>&quizzAnswer=<string>
 *   return: {success: <bool> [, error=<string]}
 *
 * /results/<channel>?count=<int>
 *   return: {results: [<QuizzResultObject>, ...]}
 *
 * /scores/<channel>
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
  add_rewrite_rule('register/([0-9a-zA-Z-_]+)/?$', 'index.php?action=register&channel=$matches[1]', 'top');
  add_rewrite_rule('play/([0-9a-zA-Z-_]+)/?$', 'index.php?action=play&channel=$matches[1]', 'top');
  add_rewrite_rule('answer/([0-9a-zA-Z-_]+)/?$', 'index.php?action=answer&channel=$matches[1]', 'top');
  add_rewrite_rule('results/([0-9a-zA-Z-_]+)/?$', 'index.php?action=results&channel=$matches[1]', 'top');
  add_rewrite_rule('scores/([0-9a-zA-Z-_]+)/?$', 'index.php?action=scores&channel=$matches[1]', 'top');
}
add_action('init', 'tq_rewrites_url');

function tq_query_vars($query_vars) {
    $query_vars[] = 'action';
    $query_vars[] = 'channel';
    return $query_vars;
}
add_filter('query_vars', 'tq_query_vars');

// ---------------- API ----------------

function api_result($result) {
  echo json_encode($result);
  exit;
}

// ---------------- QUIZZ ----------------

function get_random_quizz() {
  $posts = get_posts(array(
    'numberposts' => 1,
    'orderby' => 'ran'
  ));
  return $posts[0]->ID;
}

function get_quizz($quizzId, $withResult = false) {
  $alphaTable = array('A', 'B', 'C', 'D');
  $post = get_post((int)$quizzId);

  get_field('video_picture', $postId);

  $quizz = array(
    'id' => $post->ID,
    'question' => $post->post_title,
    'participateTime' => quizz_participate_time(),
    'respondTime' => quizz_respond_time(),
    'answers' => array(
      'A' => get_field('reponse_a', $quizzId),
      'B' => get_field('reponse_b', $quizzId),
      'C' => get_field('reponse_c', $quizzId),
      'D' => get_field('reponse_d', $quizzId)
    )
  );

  if($withResult) {
    $quizz['result'] = get_field('resultat', $quizzId);
  }

  return $quizz;
}

// ---------------- CHANNELS ----------------

function get_channel() {
  return strtolower(get_query_var('channel'));
}

function register_channel($channel) {
  global $wpdb;
  $row = $wpdb->get_row($wpdb->prepare('SELECT id FROM ' . table_channels() . ' AS channelCount WHERE channel=%s', $channel));
  if(is_null($row)) {
    $wpdb->insert(
      table_channels(),
      array(
        'channel' => $channel,
        'playDate' => date('U')
      ),
      array('%s', '%d')
    );
    return $wpdb->insert_id;
  }
  return false;
}

function update_channel($channelInfos) {
  global $wpdb;
  $wpdb->update(
    table_channels(),
    array(
      'resultId' => (int) $channelInfos['resultId'],
      'playDate' => (int) $channelInfos['playDate'],
      'quizz' => (int) $channelInfos['quizz'],
      'members' => implode(',', $channelInfos['members']),
      'returnResults' => implode(',', $channelInfos['returnResults']),
      'results' => $channelInfos['results'],
      'isPlaying' => $channelInfos['isPlaying'] ? 1 : 0
    ),
    array('channel' => $channelInfos['channel']),
    array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%d'),
    array('%s')
  );
}

function get_channel_infos($channel) {
  global $wpdb;
  $row = $wpdb->get_row($wpdb->prepare('SELECT id, channel, resultId, playDate, quizz, members, returnResults, results, isPlaying FROM ' . table_channels() . ' AS channelCount WHERE channel=%s', $channel));
  if(!is_null($row)) {
    $members = is_null($row->members) || !$row->members ? array() : $row->members;
    $members = is_array($members) ? $members : explode(',', $members);
    $returnResults = is_null($row->returnResults) || !$row->returnResults ? array() : $row->returnResults;
    $returnResults = is_array($returnResults) ? $returnResults : explode(',', $returnResults);
    return array(
      'id' => (int) $row->id,
      'channel' => $row->channel,
      'resultId' => (int) $row->resultId,
      'playDate' => (int) $row->playDate,
      'quizz' => (int) $row->quizz,
      'members' => $members,
      'returnResults' => $returnResults,
      'results' => $row->results,
      'isPlaying' => (int) $row->isPlaying == 1 ? true : false
    );
  }
  return false;
}

// ---------------- USERS ----------------

function register_user($channel, $username, $avatar) {
  global $wpdb;
  $row = $wpdb->get_row($wpdb->prepare('SELECT id FROM ' . table_users() . ' WHERE channel=%s AND name=%s', $channel, $username));
  if($row) {
    $wpdb->update(
      table_users(),
      array(
        'avatar' => $avatar
      ),
      array('id' => $row->id),
      array('%s'),
      array('%d')
    );
    return $row->id;
  }
  else {
    $wpdb->insert(
      table_users(),
      array(
        'channel' => $channel,
        'name' => $username,
        'avatar' => $avatar
      ),
      array('%s', '%s', '%s')
    );
    return $wpdb->insert_id;
  }
}

function get_user_infos($channel, $userNameOrId) {
  global $wpdb;
  $row = $wpdb->get_row($wpdb->prepare('SELECT id, channel, name, avatar, points FROM ' . table_users() . ' WHERE channel=%s AND '.(is_numeric($userNameOrId) ? 'id=%d' : 'name=%s'), $channel, $userNameOrId));
  if($row) {
    return array(
      'id' => $row->id,
      'channel' => $row->channel,
      'name' => $row->name,
      'avatar' => $row->avatar,
      'points' => (int) $row->points
    );
  }
  return false;
}

function update_user_points($userId, $points) {
  global $wpdb;
  $wpdb->update(
    table_users(),
    array(
      'points' => $points
    ),
    array('id' => $userId),
    array('%d'),
    array('%d')
  );
}

// ---------------- AVATARS ----------------

define('AVATARSPATH', ABSPATH.'/userpictures');
define('AVATARSURI', home_url().'/userpictures');

function get_avatars() {
  return array_filter(scandir(AVATARSPATH), function($value) {
    return pathinfo($value, PATHINFO_EXTENSION) == 'png';
  });
}

// ---------------- RESULTS ----------------

function get_last_result($channel) {
  global $wpdb;
  $row = $wpdb->get_row($wpdb->prepare('SELECT id, date, winner, members, message FROM ' . table_results() . ' WHERE channel=%s ORDER BY date DESC LIMIT 1', $channel));
  if($row) {
    $result = array(
      'id' => $row->id,
      'date' => (int) $row->date,
      'winner' => $row->winner,
      'members' => array(),
      'message' => $row->message
    );

    $result['winner'] = get_user_infos($channel, $result['winner']);

    $members = is_null($row->members) || !$row->members ? array() : $row->members;
    $members = is_array($members) ? $members : explode(',', $members);
    foreach($members as $member) {
      $result['members'] []= get_user_infos($channel, (int) $member);
    }

    return $result;
  }
  return false;
}

function register_result($channel, $winnerId, $members, $message) {
  global $wpdb;
  $wpdb->insert(
    table_results(),
    array(
      'channel' => $channel,
      'date' => date('U'),
      'winner' => $winnerId,
      'members' => implode(',', $members),
      'message' => $message,
    ),
    array('%s', '%d')
  );
  return $wpdb->insert_id;
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
    ) CHARACTER SET utf8 COLLATE utf8_general_ci');

    dbDelta('CREATE TABLE ' . $tableChannels . '(
      id int(11) NOT NULL AUTO_INCREMENT,
      resultId int(11) DEFAULT 0,
      channel varchar(255) DEFAULT NULL,
      playDate int(11) DEFAULT 0,
      quizz int(11) DEFAULT 0,
      members TEXT DEFAULT NULL,
      returnResults TEXT DEFAULT NULL,
      results TEXT DEFAULT NULL,
      isPlaying int(1) DEFAULT 0,
      UNIQUE KEY id (id)
    ) CHARACTER SET utf8 COLLATE utf8_general_ci');

    dbDelta('CREATE TABLE ' . $tableResults . '(
      id int(11) NOT NULL AUTO_INCREMENT,
      channel varchar(255) DEFAULT NULL,
      date int(11) DEFAULT 0,
      winner int(11) DEFAULT 0,
      members TEXT,
      message TEXT,
      UNIQUE KEY id (id)
    ) CHARACTER SET utf8 COLLATE utf8_general_ci');
  }
}
add_action('init', 'tq_create_tables');