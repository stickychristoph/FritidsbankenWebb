<?php

namespace StickyBeat;

class ThemeSettings
{
  public function __construct()
  {
    add_action('after_setup_theme', [__CLASS__, 'after_setup']);
  }

  public static function after_setup()
  {
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('editor-font-sizes', [
      [
        'name' => 'Medium',
        'size' => 18,
        'slug' => 'p-lg',
      ],
    ]);
  }
}
