<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once 'autoload.php';

$loader = new Autoloader();
$loader
  ->setNamespacePrefix('StickyBeat')
  ->setBaseDir(TEMPLATEPATH . '/lib')
  ->register();

new \StickyBeat\Ajax();
new \StickyBeat\API();
new \StickyBeat\Blocks();
new \StickyBeat\Colors();
new \StickyBeat\Contact();
new \StickyBeat\Fritidsbank();
new \StickyBeat\Head();
new \StickyBeat\Nav();
new \StickyBeat\Options();
new \StickyBeat\Post();
new \StickyBeat\Printer();
new \StickyBeat\PressImage();
new \StickyBeat\PressRelease();
new \StickyBeat\ThemeSettings();
new \StickyBeat\Utils();

add_theme_support('title-tag');
add_theme_support('automatic-feed-links');
add_theme_support('responsive-embeds');
add_theme_support('wp-block-styles');
add_theme_support('post-thumbnails', [
  'contact',
  'post',
  'pressimage',
  'pressrelease',
]);

if (!defined('MAPS_API_KEY')) {
  define('MAPS_API_KEY', 'AIzaSyAPEwGfnYiGVsaM4WazUWRwdgRdpm6Q5Pk');
}
