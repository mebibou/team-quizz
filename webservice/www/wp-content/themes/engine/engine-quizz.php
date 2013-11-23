<?php

if (!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit();
}

// ---------------- RENAME POSTS ----------------

function change_post_object_label() {
  global $wp_post_types;

  $quizzName = quizz_item_name();

  $labels = &$wp_post_types['post']->labels;
  $labels->name = $quizzName;
  $labels->singular_name = $quizzName;
  $labels->add_new = 'Ajout d\'un '.$quizzName;
  $labels->add_new_item = 'Ajouter un '.$quizzName;
  $labels->edit_item = 'Editer un '.$quizzName;
  $labels->new_item = 'Ajouter un '.$quizzName;
  $labels->view_item = 'Voir le '.$quizzName;
  $labels->search_items = 'Rechercher un '.$quizzName;
  $labels->not_found = 'Vide';
  $labels->not_found_in_trash = 'Vide';
  $labels->all_items = 'Tous les '.$quizzName.'s';
  $labels->menu_name = $quizzName;
  $labels->name_admin_bar = $quizzName;
}
add_action('init', 'change_post_object_label');

function change_post_menu_label() {
  global $menu;
  global $submenu;

  $quizzName = quizz_item_name();

  $menu[5][0] = $quizzName;
  $submenu['edit.php'][5][0] = $quizzName;
  $submenu['edit.php'][10][0] = 'Ajout d\'un '.$quizzName;
  $submenu['edit.php'][16][0] = 'Mots clés';
}
add_action('admin_menu', 'change_post_menu_label');

// ---------------- REMOVE ELEMENTS FROM POSTS ----------------

function remove_useless_meta_boxes() {
  remove_meta_box('categorydiv', 'post', 'side');
  remove_meta_box('postexcerpt', 'post', 'normal');
  remove_meta_box('trackbacksdiv', 'post', 'normal');
  remove_meta_box('postcustom', 'post', 'normal');
  remove_meta_box('sqpt-meta-tags', 'post', 'normal');
  remove_meta_box('tagsdiv-post_tag', 'post', 'normal');
  remove_meta_box('pageparentdiv', 'post', 'side');
}
add_action('admin_menu', 'remove_useless_meta_boxes');

// ---------------- EDIT/VIEW COLUMNS ----------------

function edit_livre_item_columns($columns) {
  $newColumns = array();
  foreach($columns as $columnName => $columnValue) {
    if($columnName != 'tags' && $columnName != 'categories' && $columnName != 'comments') {
      $newColumns[$columnName] = $columnValue;
    }
    if($columnName == 'title') {
      $newColumns['title'] = 'Question';
    }
  }

  return $newColumns;
}
add_filter('manage_edit-post_columns', 'edit_livre_item_columns');