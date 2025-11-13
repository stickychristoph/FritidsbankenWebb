<?php
use StickyBeat\Printer;

$title = get_field('title');
?>

<div class="news-list-block content-outer">
    <h1 class="block-title"><?php echo $title; ?></h1>
    <div id="news-items" class="news-items">

    <?php
    $offset = 0;

    $args = [
      'post_type' => 'post',
      'offset' => $offset,
      'posts_per_page' => 6,
    ];

    $post_query = new WP_Query($args);

    // loop through the posts
    if ($post_query->have_posts()) {
      while ($post_query->have_posts()) {
        $post_query->the_post();
        global $post;
        Printer::render_news_item($post);
      }
    }
    ?>
    <div id="insert-news-before" class="news-list-item filler"></div>
    <div class="news-list-item filler"></div>
	</div>
  <div class="more-articles-container">
			<a href="#" id="load-more-news" class="text-link more-news">
        <span class="load-more-label"><?php echo __(
          'Ladda fler nyheter',
          'fritidsbanken'
        ); ?></span>
        <div class="spinner spin-wrapper"><span class="icon-spin6"></span></div>
      </a>
		</div>
</div>