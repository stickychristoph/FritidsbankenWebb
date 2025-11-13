<?php

namespace StickyBeat;

class Printer
{
  public static function render_image(
    $imageId,
    $sizes = '(max-width: 720px) 100vw, 360px',
    $class = ''
  ) {
    $srcset = wp_get_attachment_image_srcset($imageId);
    $src = wp_get_attachment_image_src($imageId, 'medium')[0];
    //$title = get_the_title($imageId);
    $alt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
    ?>
      <img class="<?php echo $class; ?>" srcse t="<?php echo $srcset; ?>" sizes="<?php echo $sizes; ?>" src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" />
    <?php
  }

  public static function render_news_item($post_item)
  {
    ?>
   <article class="news-list-item fb-card" itemscope itemtype="http://schema.org/Article">

    <a class="card-link" href="<?php echo get_permalink(); ?>" itemprop="url">
      <?php if (has_post_thumbnail($post_item->ID)) {
        $mediaId = get_post_thumbnail_id($post_item->ID);

        self::render_image($mediaId, null, 'card-image');
      } ?> 


        <?php $author =
          get_the_author_meta('first_name') .
          ' ' .
          get_the_author_meta('last_name'); ?>
      <div class="text-container">
          <h6 class="tag"><?php echo get_the_date('j F Y'); ?></h6>
          <h2 itemprop="headline"><?php echo get_the_title($post_item); ?></h2>
          <p itemprop="articleBody"><?php echo get_the_excerpt(
            $post_item
          ); ?></p>
          <div class="card-button"><?php
          $link = [
            'title' => __('Läs vidare', 'fritidsbanken'),
          ];
          Printer::render_button($link, 'magenta', 'arrow_right_white.svg');
          ?>
          </div>
          <meta itemprop="author" content="<?php echo $author; ?>">
          <meta itemprop="datePublished" content="<?php echo $post_item->post_date; ?>">
          <span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
            <meta itemprop="name" content="Fritidsbanken">
            <meta itemprop="url" content="https://www.fritidsbanken.se">
            <span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                <meta itemprop="url" content="<?php echo get_bloginfo(
                  'stylesheet_directory'
                ); ?>/img/logo_270.png">
            </span>
          </span>
        </div>
    </a>

  </article>

<?php
  }

  public static function render_button(
    $link,
    $color = 'white',
    $icon = 'arrow_right_white.svg'
  ) {
    $htmlTag = isset($link['url']) ? 'a' : 'div';
    $classes = [];
    array_push($classes, $color);
    if (isset($link['color'])) {
      array_push($classes, $link['color']);
    }

    if (isset($icon)) {
      $iconHtml =
        '<img class="icon" alt="" src="' .
        get_bloginfo('stylesheet_directory') .
        '/assets/icons/' .
        $icon .
        '" />';
    }
    ?>
    <div class="wp-block-buttons">
        <div class="wp-block-button is-style-fill">
          <<?php echo $htmlTag; ?> class="wp-block-button__link w-icon <?php echo implode(
   ' ',
   $classes
 ); ?>" href="<?php echo isset($link['url']) ? $link['url'] : ''; ?>" <?php if (
  isset($link['id'])
) {
  echo 'id="' . $link['id'] . '"';
} ?>>
<?php if (isset($iconHtml)) {
  echo $iconHtml;
} ?>
<span class=""><?php echo $link['title']; ?></span></<?php echo $htmlTag; ?>>
        </div>
      </div>
    <?php
  }

  public static function render_text_link($link, $color = 'black')
  {
    $url = $link['url'];
    $title = isset($link['title'])
      ? $link['title']
      : __('Läs mer', 'fritidsbanken');
    ?>

   
      <a class="text-link" href="<?php echo $url; ?>"><span><?php echo $title; ?></span></a>
  
    <?php
  }
}
