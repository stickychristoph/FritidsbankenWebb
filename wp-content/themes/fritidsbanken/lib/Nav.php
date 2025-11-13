<?php

namespace StickyBeat;

class Nav
{
  public function __construct()
  {
    add_action('after_setup_theme', [__CLASS__, 'register_nav_menu']);
    add_action('wp_before_admin_bar_render', [
      __CLASS__,
      'remove_comments_admin_bar',
    ]);
    add_action('admin_menu', [__CLASS__, 'remove_unused_in_admin_menu']);
  }

  public static function register_nav_menu()
  {
    //error_log('Nav - register_nav_menu');
    register_nav_menus([
      'main-menu' => 'Huvudmeny',
      'footer-menu' => 'Footermeny',
    ]);
  }

  public static function remove_comments_admin_bar()
  {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
  }
  public static function remove_unused_in_admin_menu()
  {
    remove_menu_page('edit-comments.php');
    /*   remove_menu_page('edit.php'); */
  }
}
