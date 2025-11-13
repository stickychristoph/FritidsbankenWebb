<?php
use StickyBeat\Printer;

$hideFeaturedImage = get_field('hide_featured_image', $post->ID);
$author =
  get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');

get_header();
?>

<div class="fb-single content">
  <h6 class="date"><?php echo get_the_date('j F Y'); ?></h6>
  <h1><?php the_title(); ?></h1>
  <?php
  if (has_post_thumbnail($post->ID) && !$hideFeaturedImage) {
    $mediaId = get_post_thumbnail_id($post->ID);

    Printer::render_image($mediaId, null, 'featured-image');
  }

  the_content();
  ?>

  <meta itemprop="author" content="<?php echo $author; ?>">
    <meta itemprop="datePublished" content="<?php echo $post->post_date; ?>">
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
<?php get_footer();
?>
