<?php

if (!function_exists('add_action')) {
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit();
}

// ---------------- CUSTOM FIELDS ----------------

if(function_exists("register_field_group")) {
  register_field_group(array (
    'id' => 'acf_quizz',
    'title' => 'Quizz',
    'fields' => array (
      array (
        'key' => 'field_52912ecb5f42c',
        'label' => 'Réponse A',
        'name' => 'reponse_a',
        'type' => 'text',
        'required' => 1,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_52912f0d5f42d',
        'label' => 'Réponse B',
        'name' => 'reponse_b',
        'type' => 'text',
        'required' => 1,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_52912f1b5f42e',
        'label' => 'Réponse C',
        'name' => 'reponse_c',
        'type' => 'text',
        'required' => 1,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_52912f235f42f',
        'label' => 'Réponse D',
        'name' => 'reponse_d',
        'type' => 'text',
        'required' => 1,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_52912f3d5f430',
        'label' => 'Résultat',
        'name' => 'resultat',
        'type' => 'radio',
        'required' => 1,
        'choices' => array (
          'Réponse A' => 'Réponse A',
          'Réponse B' => 'Réponse B',
          'Réponse C' => 'Réponse C',
          'Réponse D' => 'Réponse D',
        ),
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => '',
        'layout' => 'horizontal',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'no_box',
      'hide_on_screen' => array (
        0 => 'the_content',
      ),
    ),
    'menu_order' => 0,
  ));
}
