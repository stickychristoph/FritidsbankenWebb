<?php
use StickyBeat\Printer;
global $post;

$imageId = get_field('bg_image');
$link = get_field('link');
?>

<div class="news-recent-block">
<?php if ($imageId) {
  Printer::render_image($imageId, null, 'bg-image');
} ?>
    <div class="overlay-bg"></div>
    <div id="news-items" class="news-items content-outer">

    <?php
    $args = [
      'post_type' => 'post',
      'posts_per_page' => 3,
    ];

    $post_query = new WP_Query($args);
    if ($post_query->have_posts()) {
      while ($post_query->have_posts()) {
        $post_query->the_post();
        if (isset($post)) {
          Printer::render_news_item($post);
        }
      }
      wp_reset_postdata();
    }
    ?>
    <div class="news-list-item filler"></div>
    <div class="news-list-item filler"></div>
	</div>
  <div class="show-all">
  <?php if (is_array($link)):
    Printer::render_text_link($link, 'black');
  endif; ?>
  </div>
 
</div>