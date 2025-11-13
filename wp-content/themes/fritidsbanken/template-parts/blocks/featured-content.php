<?php
use StickyBeat\Printer;

$title = get_field('title');
$body = get_field('body');
$imageId = get_field('image');
$bgId = get_field('bg_image');
$cta = get_field('cta');
$ctaIcon = get_field('cta_icon');
$colorTheme = get_field('color_theme');
?>

<div class="fb-featured-content-block">
  <?php if ($bgId) {
    Printer::render_image($bgId, null, 'bg-image');
  } ?>
    <div class="overlay-bg"></div>
    <div class="featured-content content-inner">
      <div class="featured-image-container">
        <?php if ($imageId) {
          Printer::render_image($imageId, null, 'featured-image');
        } ?>
      </div>
      <div class="text-container">
        <h2><?php echo $title; ?></h2>
        <p><?php echo $body; ?></p>
      <?php if (is_array($cta)):
        Printer::render_button($cta, $colorTheme, $ctaIcon);
      endif; ?>
      </div>
  </div>
  
</div>