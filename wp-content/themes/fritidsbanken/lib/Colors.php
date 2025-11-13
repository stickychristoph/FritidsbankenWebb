<?php

namespace StickyBeat;

class Colors
{
  public function __construct()
  {
    add_action('after_setup_theme', [__CLASS__, 'color_palette']);
  }

  public static function color_palette()
  {
    add_theme_support('editor-color-palette', [
      [
        'name' => 'Vit',
        'slug' => 'white',
        'color' => '#FFFFFF',
      ],
      [
        'name' => 'Svart',
        'slug' => 'black',
        'color' => '#000000',
      ],
      [
        'name' => 'Grön',
        'slug' => 'green-500',
        'color' => '#4D9D34',
      ],
      [
        'name' => 'Ljusgrå',
        'slug' => 'gray-100',
        'color' => '#eeeeee',
      ],
      [
        'name' => 'Orange',
        'slug' => 'orange-500',
        'color' => '#E67400',
      ],
      [
        'name' => 'Blå',
        'slug' => 'blue-500',
        'color' => '#3796DC',
      ],
    ]);
  }
}
