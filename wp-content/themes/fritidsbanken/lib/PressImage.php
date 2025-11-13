<?php

namespace StickyBeat;

class PressImage
{
  public function __construct()
  {
    //error_log('Page - init');
    add_action('init', [__CLASS__, 'create_pressimage_post_type']);
    add_action('init', [__CLASS__, 'add_template_to_pressimage']);
  }

  public static function create_pressimage_post_type()
  {
    $args = [
      'public' => true,
      'labels' => [
        'name' => 'Pressbilder',
        'singular' => 'Pressbilder',
      ],
      'supports' => ['title', 'thumbnail', 'editor'],
      'has_archive' => true,
      'publicly_queryable' => true,
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-images-alt',
      'show_in_menu' => true,
      'rewrite' => ['slug' => 'pressbild'],
    ];
    register_post_type('pressimage', $args);
  }

  public static function add_template_to_pressimage()
  {
    $template = [
      ['core/featured-image'],
      [
        'core/paragraph',
        ['align' => 'left', 'placeholder' => 'Bildbeskrivningen'],
      ],
    ];
    $post_type_object = get_post_type_object('pressimage');
    $post_type_object->template = $template;
  }
}
