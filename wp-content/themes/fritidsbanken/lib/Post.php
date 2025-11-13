<?php

namespace StickyBeat;

class Post
{
  public function __construct()
  {
    //error_log('Page - init');
    add_action('init', [__CLASS__, 'add_template_to_post']);
  }

  public static function add_template_to_post()
  {
    $template = [
      ['core/featured-image'],
      ['core/paragraph', ['align' => 'left', 'placeholder' => 'Brödtext']],
    ];
    $post_type_object = get_post_type_object('post');
    $post_type_object->template = $template;
  }
}
