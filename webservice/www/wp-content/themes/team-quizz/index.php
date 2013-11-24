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
    break;
  case 'answer':
    break;
  case 'results':
    break;
  default:
}

 /*

  <div id="primary" class="site-content">
    <div id="content" role="main">
    <?php if ( have_posts() ) : ?>

      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', get_post_format() ); ?>
      <?php endwhile; ?>

      <?php twentytwelve_content_nav( 'nav-below' ); ?>

    <?php else : ?>

      <article id="post-0" class="post no-results not-found">

      <?php if ( current_user_can( 'edit_posts' ) ) :
        // Show a different message to a logged-in user who can add posts.
      ?>
        <header class="entry-header">
          <h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
        </header>

        <div class="entry-content">
          <p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
        </div><!-- .entry-content -->

      <?php else :
        // Show the default message to everyone else.
      ?>
        <header class="entry-header">
          <h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
        </header>

        <div class="entry-content">
          <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
          <?php get_search_form(); ?>
        </div><!-- .entry-content -->
      <?php endif; // end current_user_can() check ?>

      </article><!-- #post-0 -->

    <?php endif; // end have_posts() check ?>

    </div><!-- #content -->
  </div><!-- #primary -->
*/