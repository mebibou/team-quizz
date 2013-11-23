<?php

if(!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit;
}

// ---------------- DEFINE ROLES ----------------

function add_theme_caps() {
  // base roles: administrator, editor, author, contributor, subscriber

  foreach(array('administrator', 'editor') as $roleName) {
    $role = get_role($roleName);
    $role->add_cap('game');
    $role->add_cap('edit_theme_options');
  }
}
add_action('admin_init', 'add_theme_caps');