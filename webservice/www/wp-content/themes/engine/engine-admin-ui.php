<?php

if(!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit;
}

// ---------------- ADD ADMIN MENU SEPARATOR FUNCTION ----------------

function add_admin_menu_separator($position) {
  global $menu;
  $index = 0;

  foreach($menu as $offset => $section) {
    if (substr($section[2], 0, 9) == 'separator') {
        $index++;
    }
    if ($offset >= $position) {
      $menu[$position] = array('', 'read', "separator{$index}", '', 'wp-menu-separator');
      break;
    }
  }

  ksort($menu);
}

// ---------------- REMOVE WORDPRESS WELCOME SCREEN ----------------

function hide_welcome_screen_for_multisite() {
  $user_id = get_current_user_id();

  if (get_user_meta($user_id, 'show_welcome_panel', true) > 0) {
    update_user_meta($user_id, 'show_welcome_panel', 0);
  }
}
add_action('load-index.php', 'hide_welcome_screen_for_multisite');

// ---------------- DASHBOARD WIDGETS ----------------

function tq_wp_dashboard_setup() {
  global $wp_meta_boxes;

  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
}
add_action('wp_dashboard_setup', 'tq_wp_dashboard_setup');

// ---------------- CUSTOMIZE ADMIN BAR ----------------

function tq_before_admin_bar_render() {
  global $wp_admin_bar;

  $removeMenus = array('wp-logo', 'wporg', 'documentation', 'support-forums', 'feedback');
  foreach($removeMenus as $menuId) {
    $wp_admin_bar->remove_menu($menuId);
  }
}
add_action('wp_before_admin_bar_render', 'tq_before_admin_bar_render');

// ---------------- REMOVE WORDPRESS HELPS AND SCREEN OPTIONS ----------------

function tq_contextual_help($old_help, $screen_id, $screen) {
  $screen->remove_help_tabs();
  return $old_help;
}
add_filter('contextual_help', 'tq_contextual_help', 999, 3);

add_filter('screen_options_show_screen', '__return_false');

// ---------------- REMOVE WORDPRESS VERSIONS ----------------

function change_footer_version() {
  return '&nbsp;';
}
add_filter('update_footer', 'change_footer_version', 9999);

// ---------------- GAME SETTINGS ----------------

function setup_theme_admin_menu() {
  add_menu_page(
    'Paramètres du jeu',
    'Team Quizz',
    'game',
    'game_theme_settings',
    'theme_settings_page',
    ENGINEURI.'/images/wrench-screwdriver.png',
    '3.1'
  );

  add_admin_menu_separator(3);
}
add_action('admin_menu', 'setup_theme_admin_menu');

function theme_settings_page() {
  include(ENGINEPATH.'/engine-admin-settings.php');
}

// ---------------- REMOVE MENUS ----------------

function remove_menus () {
  global $menu;

  //$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
  $restricted = array(__('Media'), __('Links'), __('Pages'), __('Comments'));
  
  global $current_user;
  get_currentuserinfo();

  end ($menu);
  while (prev($menu)) {
    $value = explode(' ',$menu[key($menu)][0]);
    $value = $value[0] != NULL ? $value[0] : '';

    if(in_array($value, $restricted)) {
      unset($menu[key($menu)]);
    }
  }

  remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
  remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
}
add_action('admin_menu', 'remove_menus');

// ---------------- ADMIN STYLE ----------------

function admin_css() {
?>
  <link rel="stylesheet" type="text/css" href="<?php echo ENGINEURI; ?>/css/admin.css" />
<?php
}
add_action('admin_head', 'admin_css');