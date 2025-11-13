<?php namespace StickyBeat;

class Blocks
{
  public function __construct()
  {
    //add_action('init', [__CLASS__, 'init']);
    self::init();
  }

  public function init()
  {
    add_filter('allowed_block_types', [__CLASS__, 'allowed_block_types']);
    add_filter(
      'block_categories',
      [__CLASS__, 'fritidsbanken_category'],
      10,
      2
    );
    add_action('acf/init', [__CLASS__, 'init_acf_block_types']);

    add_action('enqueue_block_editor_assets', [
      __CLASS__,
      'featured_image_backend_enqueue',
    ]);
  }

  public static function fritidsbanken_category($categories, $post)
  {
    return array_merge($categories, [
      [
        'slug' => 'fritidsbanken-blocks',
        'title' => 'Fritidsbanken Blocks',
      ],
    ]);
  }
  public static function allowed_block_types($allowed_blocks)
  {
    return [
      'core/buttons',
      'core/embed',
      'core/featured-image',
      'core/heading',
      'core/image',
      'core/list',
      'core/paragraph',
      'core/quote',
      'core/group',
      'core/shortcode',
      'acf/anchor-menu',
      'acf/bank-inventory',
      'acf/contacts',
      'acf/easy-to-read',
      'acf/find-bank',
      'acf/featured-content',
      'acf/news-list',
      'acf/news-recent',
      'acf/start-hero',
      'acf/press',
      'tw/wds',
    ];
  }

  public static function init_acf_block_types()
  {
    if (function_exists('acf_register_block_type')) {
      acf_register_block_type([
        'name' => 'anchor-menu',
        'title' => 'Ankarlänkar-meny',
        'description' => '',
        'render_template' => 'template-parts/blocks/anchor-menu.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'editor-ul',
        'mode' => 'auto',
      ]);
      acf_register_block_type([
        'name' => 'find-bank',
        'title' => 'Hitta Fritidsbank',
        'description' => '',
        'render_template' => 'template-parts/blocks/find-bank.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'search',
        'mode' => 'auto',
        'enqueue_assets' => [__CLASS__, 'find_bank_backend_enqueue'],
      ]);
      acf_register_block_type([
        'name' => 'contacts',
        'title' => 'Kontaktpersoner',
        'description' => '',
        'render_template' => 'template-parts/blocks/contacts.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'id',
        'mode' => 'auto',
      ]);
      acf_register_block_type([
        'name' => 'bank-inventory',
        'title' => 'Lagersaldo',
        'description' => '',
        'render_template' => 'template-parts/blocks/bank-inventory.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'cart',
        'mode' => 'preview',
        'enqueue_assets' => [__CLASS__, 'bank_inventory_backend_enqueue'],
      ]);
      acf_register_block_type([
        'name' => 'easy-to-read',
        'title' => 'Lättläst växlare',
        'description' => '',
        'render_template' => 'template-parts/blocks/easy-to-read.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'translation',
        'mode' => 'auto',
      ]);
      acf_register_block_type([
        'name' => 'news-list',
        'title' => 'Nyhetslista',
        'description' => '',
        'render_template' => 'template-parts/blocks/news-list.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'grid-view',
        'mode' => 'auto',
      ]);

      acf_register_block_type([
        'name' => 'press',
        'title' => 'Press',
        'description' => '',
        'render_template' => 'template-parts/blocks/press.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'visibility',
        'mode' => 'auto',
      ]);
      acf_register_block_type([
        'name' => 'news-recent',
        'title' => 'Senaste Nyheter',
        'description' => '',
        'render_template' => 'template-parts/blocks/news-recent.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'bell',
        'mode' => 'auto',
      ]);
      acf_register_block_type([
        'name' => 'start-hero',
        'title' => 'Starsida-hero',
        'description' => '',
        'render_template' => 'template-parts/blocks/start-hero.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'superhero-alt',
        'mode' => 'auto',
      ]);

      acf_register_block_type([
        'name' => 'featured-content',
        'title' => 'Utvald innehåll',
        'description' => '',
        'render_template' => 'template-parts/blocks/featured-content.php',
        'category' => 'fritidsbanken-blocks',
        'icon' => 'block-default',
        'mode' => 'auto',
      ]);
    }
  }

  public static function featured_image_backend_enqueue()
  {
    wp_enqueue_script(
      'featured-image-backend-script', // Unique handle.
      get_template_directory_uri() . '/assets/js/block.build.js', // block.js: We register the block here.
      ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'] // Dependencies, defined above.
    );
  }
  public static function find_bank_backend_enqueue()
  {
    /*  wp_enqueue_script(
      'featured-image-backend-script', // Unique handle.
      'https://maps.googleapis.com/maps/api/js?key=' .
        MAPS_API_KEY .
        '&callback=initMap',
      ['main']
    ); */
  }
  public static function bank_inventory_backend_enqueue()
  {
    $dir = get_template_directory() . '/assets/lagersaldo';

    foreach (glob($dir . '/index.*.css') as $filename) {
      $withoutDirectory = array_pop(explode('/', $filename));
      wp_enqueue_style(
        'bank-inventory-css',
        get_template_directory_uri() . '/assets/lagersaldo/' . $withoutDirectory
      );
    }
  }
}
