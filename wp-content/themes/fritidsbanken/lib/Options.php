<?php

namespace StickyBeat;

class Options
{
  public function __construct()
  {
    add_action('init', [__CLASS__, 'init']);
  }

  public static function init()
  {
    if (function_exists('acf_add_options_page')) {
      acf_add_options_page([
        'page_title' => 'Tema-inställningar',
        'menu_title' => 'Tema-inställningar',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
      ]);

      acf_add_options_sub_page([
        'page_title' => 'Lagersaldo Inställningar',
        'menu_title' => 'Lagersaldo',
        'parent_slug' => 'theme-general-settings',
      ]);
      acf_add_options_sub_page([
        'page_title' => 'Tema Footer Inställningar',
        'menu_title' => 'Footer',
        'parent_slug' => 'theme-general-settings',
      ]);
    }
  }
}
