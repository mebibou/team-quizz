<?php

if (!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit();
}

$message = '';

if (isset($_POST['update_form']) && $_POST['update_form'] == 'yes') {
  $success = true;

  $quizzWinPoints = isset($_POST['quizz_win_points']) && is_numeric($_POST['quizz_win_points']) ? (int) $_POST['quizz_win_points'] : null;
  quizz_interval_time($quizzWinPoints);

  $quizzIntervalTime = isset($_POST['quizz_interval_time']) && is_numeric($_POST['quizz_interval_time']) ? (int) $_POST['quizz_interval_time'] : null;
  quizz_interval_time($quizzIntervalTime);

  $quizzRespondTime = isset($_POST['quizz_participate_time']) && is_numeric($_POST['quizz_participate_time']) ? (int) $_POST['quizz_participate_time'] : null;
  quizz_participate_time($quizzRespondTime);

  $quizzRespondTime = isset($_POST['quizz_respond_time']) && is_numeric($_POST['quizz_respond_time']) ? (int) $_POST['quizz_respond_time'] : null;
  quizz_respond_time($quizzRespondTime);

  $quizzEventsPercent = isset($_POST['quizz_events_percent']) && is_numeric($_POST['quizz_events_percent']) ? (int) $_POST['quizz_events_percent'] : null;
  quizz_events_percent($quizzEventsPercent);

  $quizzEventTheftPoints = isset($_POST['quizz_event_theft_points']) && is_numeric($_POST['quizz_event_theft_points']) ? (int) $_POST['quizz_event_theft_points'] : null;
  quizz_event_theft_points($quizzEventTheftPoints);

  if($succes) {
    $message = '<div id="message" class="updated">Paramètres enregistrés.</div>';
  }
}

$quizzWinPoints = quizz_win_points();
$quizzIntervalTime = quizz_interval_time();
$quizzParticipateTime = quizz_participate_time();
$quizzRespondTime = quizz_respond_time();

$quizzEventsPercent = quizz_events_percent();
$quizzEventTheftPoints = quizz_event_theft_points();

?>

<div class="wrap">
  <?php screen_icon('page'); ?> <h2>Team Quizz - Paramètres du jeu</h2>

  <?php echo $message; ?>

  <form method="POST" action="">
    <input type="hidden" name="update_form" value="yes" />

    <h3 class="title">Paramètres généraux</h3>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="quizz_win_points">Points gagnés par Quizz :</label>
        </th>
        <td>
          <input type="text" name="quizz_win_points" id="quizz_win_points" class="regular-text" value="<?php echo $quizzWinPoints; ?>" />
          <p class="description">Par defaut: 1</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="quizz_interval_time">Temps entre chaque Quizz :</label>
        </th>
        <td>
          <input type="text" name="quizz_interval_time" id="quizz_interval_time" class="regular-text" value="<?php echo $quizzIntervalTime; ?>" />
          <p class="description">Unités exprimées en minutes</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="quizz_participate_time">Temps pour participer à un nouveau quizz :</label>
        </th>
        <td>
          <input type="text" name="quizz_participate_time" id="quizz_participate_time" class="regular-text" value="<?php echo $quizzParticipateTime; ?>" />
          <p class="description">Unités exprimées en secondes</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="quizz_respond_time">Temps maximal pour donner le résultat d'un Quizz :</label>
        </th>
        <td>
          <input type="text" name="quizz_respond_time" id="quizz_respond_time" class="regular-text" value="<?php echo $quizzRespondTime; ?>" />
          <p class="description">Unités exprimées en secondes</p>
        </td>
      </tr>
    </table>

    <h3 class="title">Evenements spéciaux</h3>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="quizz_events_percent">Pourcentage de chance d'avoir un évenement spécial :</label>
        </th>
        <td>
          <input type="text" name="quizz_events_percent" id="quizz_events_percent" class="regular-text" value="<?php echo $quizzEventsPercent; ?>" />
          <p class="description">Par défaut : 50</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="quizz_event_theft_points">Points donnés en cas de vol :</label>
        </th>
        <td>
          <input type="text" name="quizz_event_theft_points" id="quizz_event_theft_points" class="regular-text" value="<?php echo $quizzEventTheftPoints; ?>" />
          <p class="description">Par défaut : 2</p>
        </td>
      </tr>
    </table>

    <p>
      <input type="submit" value="Enregistrer les paramètres" class="button-primary"/>
    </p>
  </form>
</div>