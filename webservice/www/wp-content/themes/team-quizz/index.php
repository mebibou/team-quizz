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
    if(!isset($_GET['username'])) {
      $result['error'] = 'Vous devez renseigner un username';
      api_result($result);
    }
    else if(!isset($_GET['avatar'])) {
      $result['error'] = 'Vous devez renseigner un avatar';
      api_result($result);
    }

    $username = $_GET['username'];
    $avatar = $_GET['avatar'];

    register_channel($channel);

    register_user($channel, $username, $avatar);

    $result['success'] = true;

    api_result($result);

    break;
  case 'play':
    // TEST: http://teamquizz.xavierboubert.fr/play/Larousse?username=Xavier

    $result = array('success' => false);

    $channel = get_channel();
    $channelInfos = get_channel_infos($channel);

    if(!$channelInfos) {
      $result['error'] = 'Ce channel n\'existe pas';
      api_result($result);
    }

    if(!isset($_GET['username'])) {
      $result['error'] = 'Vous devez renseigner un username';
      api_result($result);
    }

    $username = $_GET['username'];
    $userInfos = get_user_infos($channel, $username);

    if(!$userInfos) {
      $result['error'] = 'Cet utilisateur n\'existe pas';
      api_result($result);
    }

    $quizz = null;
    $quizzResult = null;

    $intervalTime = quizz_interval_time() * 60;
    $respondTime = quizz_participate_time() + quizz_respond_time() + quizz_chrome_extension_ajax_time();

    // START PLAYING QUIZZ
    if(!$channelInfos['isPlaying'] && $channelInfos['playDate'] < date('U') - $intervalTime) {
      $channelInfos['isPlaying'] = true;
      $channelInfos['quizz'] = get_random_quizz();
      $channelInfos['playDate'] = date('U');
      $channelInfos['askers'] = '';
      $channelInfos['members'] = '';
      $channelInfos['returnResult'] = '';
      $channelInfos['results'] = '';
      update_channel($channelInfos);
    }

    // GET QUIZZ
    if($channelInfos['isPlaying'] && !in_array($userInfos['id'], $channelInfos['askers'])) {
      $channelInfos['askers'] []= $userInfos['id'];
      update_channel($channelInfos);

      $result['quizz'] = get_quizz($channelInfos['quizz']);
    }

    // STOP PLAYING ACTUAL QUIZZ
    if($channelInfos['isPlaying'] && $channelInfos['playDate'] < date('U') - $respondTime) {

    }

    // GET QUIZZ RESPOND
    if(!$channelInfos['isPlaying'] && in_array($userInfos['id'], $channelInfos['members']) && !in_array($userInfos['id'], $channelInfos['returnResult'])) {

      $channelInfos['returnResult'] []= $userInfos['id'];
      update_channel($channelInfos);

      $userInfos = get_user_infos($channel, $username);

      $result['quizzResult'] = array();
    }

    $result['success'] = true;
    $result['quizz'] = $quizz;
    $result['quizzResult'] = $quizzResult;
    $result['points'] = $userInfos['points'];

    api_result($result);

    break;
  case 'answer':
    break;
  case 'results':
    break;
  default:
}