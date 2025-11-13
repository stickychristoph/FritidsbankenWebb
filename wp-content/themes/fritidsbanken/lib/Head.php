<?php

namespace StickyBeat;

class Head
{
  public static string $stylesVersion = '1.1';
  public static string $scriptVersion = '1.2';

  public function __construct()
  {
    add_action('init', [__CLASS__, 'init']);
    add_filter(
      'pre_get_document_title',
      [__CLASS__, 'custom_document_title'],
      99
    );
  }
  public static function init()
  {
    add_action('enqueue_block_editor_assets', [
      __CLASS__,
      'enqueue_editor_assets',
    ]);
    if (!is_admin()) {
      add_action(
        'wp_enqueue_scripts',
        [__CLASS__, 'theme_frontend_scripts'],
        9999
      );
    }

    add_action('wp_head', [__CLASS__, 'open_graph_image'], 5);
    add_action('wp_head', [__CLASS__, 'meta_tags'], 5);
  }

  public static function theme_frontend_scripts()
  {
    wp_enqueue_style(
      'np-styles',
      get_template_directory_uri() . '/style.css',
      false,
      self::$stylesVersion,
      'all'
    );
    wp_enqueue_script(
      'main',
      get_template_directory_uri() . '/assets/js/main.min.js',
      [],
      self::$scriptVersion,
      true
    );

    wp_localize_script('main', 'settings', [
      'ajaxurl' => admin_url('admin-ajax.php'),
      'basepath' => get_template_directory_uri(),
    ]);
  }
  public static function enqueue_editor_assets()
  {
    wp_enqueue_style(
      'fb-admin-styles',
      get_template_directory_uri() . '/style.css',
      false,
      self::$stylesVersion,
      'all'
    );
    wp_enqueue_style(
      'np-admin-overwrites-styles',
      get_template_directory_uri() . '/admin-overwrites.css',
      false,
      '0.55',
      'all'
    );
  }

  public static function open_graph_image()
  {
    global $post, $wp_query;

    if (
      !$post ||
      !has_post_thumbnail($post->ID) ||
      isset($wp_query->query_vars['fritidsbank'])
    ) {
      $share_image = get_field('share-image', 'option');
      echo '<meta property="og:image" content="' . $share_image . '"/>';
      echo '<meta property="twitter:image" content="' . $share_image . '"/>';
    } else {
      $thumbnail_src = wp_get_attachment_image_src(
        get_post_thumbnail_id($post->ID),
        'full'
      );
      echo '<meta property="og:image" content="' .
        esc_attr($thumbnail_src[0]) .
        '"/>';
      echo '<meta property="twitter:image" content="' .
        esc_attr($thumbnail_src[0]) .
        '"/>';
    }

    echo "
	";
  }

  public static function meta_tags()
  {
    global $post, $wp_query;

    $desc = '';
    $title = '';

    if (is_single()) {
      $desc = get_the_excerpt($post);
      $title = get_the_title() . ' - ' . get_bloginfo('name');
    } elseif (isset($wp_query->query_vars['fritidsbank'])) {
      $cachedBanks = json_decode(get_transient('cached_banks'));

      $requestedSlug = $wp_query->query_vars['fritidsbank'];

      $bank = new \stdClass();
      $bankName = '';
      if (is_array($cachedBanks) || is_object($cachedBanks)) {
        foreach ($cachedBanks as $cachedBank) {
          if ($cachedBank->slug === $requestedSlug) {
            $bank = $cachedBank;
            break;
          }
        }

        $bankName = $bank->name;
      }

      $desc = get_bloginfo('description');
      $title = $bankName . ' - ' . get_bloginfo('name');
    } else {
      $desc = get_bloginfo('description');
      $title = get_bloginfo('name');
    }
    echo '<meta name="description" content="' . $desc . '" />';

    echo '<meta name="og:description" content="' . $desc . '" />';
    echo '<meta name="og:title" content="' . $title . '" />';

    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<meta name="twitter:title" content="' . $title . '">';
    echo '<meta name="twitter:description" content="' . $desc . '" />';
  }

  public static function custom_document_title($title)
  {
    global $wp_query;
    if (isset($wp_query->query_vars['fritidsbank'])) {
      $cachedBanks = json_decode(get_transient('cached_banks'));
      $requestedSlug = $wp_query->query_vars['fritidsbank'];

      $bank = '';
      $bankName = '';
      if (is_array($cachedBanks) || is_object($cachedBanks)) {
        foreach ($cachedBanks as $cachedBank) {
          if ($cachedBank->slug === $requestedSlug) {
            $bank = $cachedBank;
            break;
          }
        }
        $bankName = $bank->name;
      }

      return sprintf('%s - %s', $bankName, get_bloginfo('name'));
    }
    return $title;
  }
}
