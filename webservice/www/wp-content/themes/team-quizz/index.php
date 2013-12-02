<?php

switch(get_query_var('action')) {
  case 'avatars':
    // TEST http://teamquizz.xavierboubert.fr/avatars

    $result = array('avatars' => array());

    foreach(get_avatars() as $avatar) {
      $result['avatars'] []= AVATARSURI . '/' . $avatar;
    }

    api_result($result);

    break;
  case 'register':
    // TEST: http://teamquizz.xavierboubert.fr/register/Larousse?username=Xavier&avatar=http%3A%2F%2Fteamquizz.xavierboubert.fr%2Fuserpictures%2FWerewolf-icon.png

    $result = array('success' => false);

    $channel = get_channel();

    if(!$channel) {
      $result['error'] = __('You need to define a channel name.', 'teamquizz');
      api_result($result);
    }
    else if(!isset($_POST['username'])) {
      $result['error'] = __('You need to set a username.', 'teamquizz');
      api_result($result);
    }
    else if(!isset($_POST['avatar'])) {
      $result['error'] = __('You need to set a user avatar.', 'teamquizz');
      api_result($result);
    }

    $username = $_POST['username'];
    $avatar = $_POST['avatar'];

    register_channel($channel);

    register_user($channel, $username, $avatar);

    $result['success'] = true;

    api_result($result);

    break;
  case 'play':
    // TEST: http://teamquizz.xavierboubert.fr/play/Larousse?username=Xavier

    $date = (int) date('U');

    $result = array('success' => false);

    $channel = get_channel();
    $channelInfos = get_channel_infos($channel);

    if(!$channel) {
      $result['error'] = __('You need to define a channel name.', 'teamquizz');
      api_result($result);
    }
    else if(!$channelInfos) {
      $result['error'] = __('This channel does\'nt exists.', 'teamquizz');
      api_result($result);
    }
    else if(!isset($_GET['username'])) {
      $result['error'] = __('You need to set a username.', 'teamquizz');
      api_result($result);
    }

    $username = $_GET['username'];
    $userInfos = get_user_infos($channel, $username);

    if(!$userInfos) {
      $result['error'] = __('This username does\'nt exists.', 'teamquizz');
      api_result($result);
    }

    $intervalTime = quizz_interval_time() * 60;
    $askersTime = quizz_chrome_extension_ajax_time() + 1;
    $respondTime = $askersTime + quizz_participate_time() + quizz_respond_time();

    // START PLAYING QUIZZ
    if(!$channelInfos['isPlaying'] && $channelInfos['playDate'] < $date - $intervalTime) {
      $channelInfos['isPlaying'] = true;
      $channelInfos['quizz'] = get_random_quizz();
      $channelInfos['playDate'] = $date;
      $channelInfos['members'] = array();
      $channelInfos['returnResults'] = array();
      $channelInfos['results'] = '{"results": []}';
      update_channel($channelInfos);
    }

    // GET QUIZZ
    if($channelInfos['isPlaying'] && $channelInfos['playDate'] > $date - $askersTime && !in_array($userInfos['id'], $channelInfos['members'])) {
      $channelInfos['members'] []= $userInfos['id'];
      update_channel($channelInfos);

      $result['quizz'] = get_quizz($channelInfos['quizz']);
    }

    // STOP PLAYING ACTUAL QUIZZ
    if($channelInfos['isPlaying'] && $channelInfos['playDate'] < $date - $respondTime) {
      $channelInfos['isPlaying'] = false;

      $members = $channelInfos['members'];

      if(count($members) > 0) {

        $results = json_decode($channelInfos['results'], true); // {results: [[{user: <int>, answer: <string>, time: <int>}, ...]}
        $results = $results['results'];
        $quizz = get_quizz($channelInfos['quizz'], true);

        $winnerId = 0;
        $winnerTime = 0;
        foreach ($members as $member) {
          foreach($results as $resultData) {
            if((int) $resultData['user'] == (int) $member) {
              if($resultData['answer'] == $quizz['result'] && ($winnerId === 0 || $winnerTime > (int) $resultData['time'])) {
                $winnerId = (int) $member;
                $winnerTime = (int) $resultData['time'];
              }
              break;
            }
          }
        }

        $message = sprintf(__('The anwser was the letter %s!', 'teamquizz'), $quizz['result']) . '<br />';
        if(count($members) === 1) {
          $aloneGuy = get_user_infos($channel, (int) $members[0]);
          $message .= sprintf('<img src="%s" /> ' + __('%s is the only one member of this quizz. He can\'t win points.', 'teamquizz'), $aloneGuy['avatar'], $aloneGuy['name']);
        }
        else if($winnerId === 0)  {
          $message .= sprintf(__('None of the %d members don\'t gave the right answer!', 'teamquizz'));
        }
        else {
          $winner = get_user_infos($channel, $winnerId);
          $winner['points'] += quizz_win_points();
          update_user_points($winner['id'], $winner['points']);

          $message .= sprintf('<img src="%s" /> ' + __('%s is the winner of the quiz with a response in %s seconds! He won %s points.', 'teamquizz'), $winner['avatar'], $winnerTime / 100, $winner['name'], quizz_win_points());
        }

        $resultId = register_result($channel, $winnerId, $members, $message);

        $channelInfos['resultId'] = $resultId;
        $channelInfos['playDate'] = $date;
      }

      update_channel($channelInfos);
    }

    // GET QUIZZ RESULT
    if(!$channelInfos['isPlaying'] && in_array($userInfos['id'], $channelInfos['members']) && !in_array($userInfos['id'], $channelInfos['returnResults'])) {

      $channelInfos['returnResults'] []= $userInfos['id'];
      update_channel($channelInfos);

      $userInfos = get_user_infos($channel, $username);

      $result['quizzResult'] = get_last_result($channel);
    }

    $result['success'] = true;
    $result['points'] = $userInfos['points'];

    api_result($result);

    break;
  case 'answer':
    // TEST: http://teamquizz.xavierboubert.fr/answer/Larousse?username=Xavier&answer=C&time=1500

    $result = array('success' => false);

    $channel = get_channel();
    $channelInfos = get_channel_infos($channel);

    if(!$channel) {
      $result['error'] = __('You need to define a channel name.', 'teamquizz');
      api_result($result);
    }
    else if(!$channelInfos) {
      $result['error'] = __('This channel does\'nt exists.', 'teamquizz');
      api_result($result);
    }
    else if(!isset($_POST['username'])) {
      $result['error'] = __('You need to set a username.', 'teamquizz');
      api_result($result);
    }

    $username = $_POST['username'];
    $userInfos = get_user_infos($channel, $username);

    if(!$userInfos) {
      $result['error'] = __('This username does\'nt exists.', 'teamquizz');
      api_result($result);
    }

    if(!isset($_POST['answer'])) {
      $result['error'] = __('You need to set an anwser.', 'teamquizz');
      api_result($result);
    }

    $answer = $_POST['answer'];

    if(!isset($_POST['time']) || !is_numeric($_POST['time'])) {
      $result['error'] = __('You need to set a response time.', 'teamquizz');
      api_result($result);
    }

    $time = (int) $_POST['time'];

    if(!$channelInfos['isPlaying']) {
      $result['error'] = __('No quizz in progress for this channel.', 'teamquizz');
      api_result($result);
    }

    $results = json_decode($channelInfos['results'], true); // {results: [[{user: <int>, answer: <string>, time: <int>}, ...]}
    $results = $results['results'];

    foreach($results as $resultData) {
      if((int) $resultData['user'] == (int) $userInfos['id']) {
        $result['error'] = __('This user has already answered for the quizz in progress.', 'teamquizz');
        api_result($result);
      }
    }

    $results []= array(
      'user' => (int) $userInfos['id'],
      'answer' => $answer,
      'time' => $time
    );

    $channelInfos['results'] = json_encode(array('results' => $results));
    update_channel($channelInfos);

    $result['success'] = true;

    api_result($result);

    break;
  case 'results':
    // TEST: http://teamquizz.xavierboubert.fr/results/Larousse?count=5

    $result = array('success' => false);

    $channel = get_channel();
    $channelInfos = get_channel_infos($channel);

    if(!$channel) {
      $result['error'] = __('You need to define a channel name.', 'teamquizz');
      api_result($result);
    }
    else if(!$channelInfos) {
      $result['error'] = __('This channel does\'nt exists.', 'teamquizz');
      api_result($result);
    }

    $count = isset($_GET['count']) && is_numeric($_GET['count']) ? (int) $_GET['count'] : 5;

    $result = array(
      'success' => true,
      'results' => get_results($channel, $count)
    );

    api_result($result);

    break;
  case 'scores':
    // TEST: http://teamquizz.xavierboubert.fr/scores/Larousse

    $result = array('success' => false);

    $channel = get_channel();
    $channelInfos = get_channel_infos($channel);

    if(!$channel) {
      $result['error'] = __('You need to define a channel name.', 'teamquizz');
      api_result($result);
    }
    else if(!$channelInfos) {
      $result['error'] = __('This channel does\'nt exists.', 'teamquizz');
      api_result($result);
    }

    $result = array(
      'success' => true,
      'users' => get_all_users($channel)
    );

    api_result($result);

    break;
  default:
    require 'api-doc.php';
}