<?php

namespace StickyBeat;

class Contact
{
  public function __construct()
  {
    //error_log('Page - init');
    add_action('init', [__CLASS__, 'create_news_post_type']);
  }

  public static function create_news_post_type()
  {
    $args = [
      'public' => true,
      'labels' => [
        'name' => 'Kontaktpersoner',
        'singular' => 'Kontaktperson',
      ],
      'supports' => ['title', 'thumbnail'],
      'has_archive' => true,
      'publicly_queryable' => true,
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-id',
      'show_in_menu' => true,
      'rewrite' => ['slug' => 'kontaktperson'],
    ];
    register_post_type('contact', $args);
  }
}
