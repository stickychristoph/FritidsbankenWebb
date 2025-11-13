<?php

namespace StickyBeat;

class PressRelease
{
  public function __construct()
  {
    //error_log('Page - init');
    add_action('init', [__CLASS__, 'create_pressimage_post_type']);
  }

  public static function create_pressimage_post_type()
  {
    $args = [
      'public' => true,
      'labels' => [
        'name' => 'Pressmeddelanden',
        'singular' => 'Pressmeddelande',
      ],
      'supports' => ['title', 'thumbnail', 'editor'],
      'has_archive' => true,
      'publicly_queryable' => true,
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-media-text',
      'show_in_menu' => true,
      'rewrite' => ['slug' => 'pressmeddelande'],
    ];
    register_post_type('pressrelease', $args);
  }
}
