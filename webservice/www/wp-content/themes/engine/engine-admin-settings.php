<?php

if (!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit();
}

$message = '';

if (isset($_POST['update_form']) && $_POST['update_form'] == 'yes') {
  $success = true;

  $quizzIntervalTime = isset($_POST['quizz_interval_time']) && is_numeric($_POST['quizz_interval_time']) ? (int) $_POST['quizz_interval_time'] : null;
  quizz_interval_time($quizzIntervalTime);

  $quizzRespondTime = isset($_POST['quizz_respond_time']) && is_numeric($_POST['quizz_respond_time']) ? (int) $_POST['quizz_respond_time'] : null;
  quizz_respond_time($quizzRespondTime);

  if($succes) {
    $message = '<div id="message" class="updated">Paramètres enregistrés.</div>';
  }
}

$quizzIntervalTime = quizz_interval_time();
$quizzRespondTime = quizz_respond_time();

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
          <label for="quizz_interval_time">Temps entre chaque Quizz :</label>
        </th>
        <td>
          <input type="text" name="quizz_interval_time" id="quizz_interval_time" class="regular-text" value="<?php echo $quizzIntervalTime; ?>" />
          <p class="description">Unités exprimées en minutes</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="quizz_respond_time">Temps maximal pour répondre à un Quizz :</label>
        </th>
        <td>
          <input type="text" name="quizz_respond_time" id="quizz_respond_time" class="regular-text" value="<?php echo $quizzRespondTime; ?>" />
          <p class="description">Unités exprimées en secondes</p>
        </td>
      </tr>
    </table>

    <p>
      <input type="submit" value="Enregistrer les paramètres" class="button-primary"/>
    </p>
  </form>
</div>