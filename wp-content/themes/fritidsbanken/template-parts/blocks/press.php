<?php
use StickyBeat\Printer;

$pressInformationTitle = get_field('pressinformation_title');
$pressInformationBody = get_field('pressinformation_body');
$pressContactTitle = get_field('presscontact_title');
$pressReleasesTitle = get_field('pressreleases_title');
$pressImagesTitle = get_field('pressimages_title');

$pressContactId = get_field('presscontact');
$contactName = get_field('name', $pressContactId);
$contactRole = get_field('role', $pressContactId);
$contactPhone = get_field('phone', $pressContactId);
$contactEmail = get_field('email', $pressContactId);

$args = [
  'post_type' => 'pressrelease',
  'posts_per_page' => 3,
];
$pressReleases = new WP_Query($args);

$args = [
  'post_type' => 'pressimage',
  'posts_per_page' => -1,
];
$pressImages = new WP_Query($args);
?>
<div class="press-block">
  <nav>
    <ul class="press-nav">
      <li><a href="#pressinformation"><?php echo $pressInformationTitle; ?></a></li>
      <li><a href="#pressreleases"><?php echo $pressReleasesTitle; ?></a></li>
      <li><a href="#pressimages"><?php echo $pressImagesTitle; ?></a></li>
    </ul>
  </nav>
  <section>
      <span class="offsetted-anchor" id="pressinformation"></span>
      <h1><?php echo $pressInformationTitle; ?></h1>
      <h3><?php echo $pressContactTitle; ?></h3>
      <p>
        <?php echo $contactName; ?></br>
        <?php echo $contactRole; ?></br>
        <a href="tel:<?php echo $contactPhone; ?>"><?php echo $contactPhone; ?></a></br>
        <a href="mailto:<?php echo $contactEmail; ?>"><?php echo $contactEmail; ?></a></br>

      </p>
      <?php echo $pressContact->title; ?>
      <div class="press-information-body"><?php echo $pressInformationBody; ?></div>
  </section>
  <section>
    <span class="offsetted-anchor" id="pressreleases"></span>
      <h1><?php echo $pressReleasesTitle; ?></h1>
      <?php if ($pressReleases->have_posts()) {
        while ($pressReleases->have_posts()) {
          $pressReleases->the_post(); ?>
          <a href="<?php echo get_permalink(
            $post->ID
          ); ?>" class="press-release">
            <h6 class="press-release-date"><?php echo get_the_date(
              'j F Y'
            ); ?></h6>
            <h2><?php echo the_title(); ?></h2>
            <p><?php echo get_the_excerpt($post); ?></p>
          </a>
        
        <?php
        }
      } ?>
      <p>
      <a class="" href="<?php echo get_post_type_archive_link(
        'pressrelease'
      ); ?>"><?php echo __('Visa alla', 'fritidsbanken'); ?></a></p>
  </section>
  <section>
      <span class="offsetted-anchor" id="pressimages"></span>
      <h1><?php echo $pressImagesTitle; ?></h1>
      <div class="press-images">
      <?php if ($pressImages->have_posts()) {
        while ($pressImages->have_posts()) { ?>
          <div class="press-image">
            <?php
            $pressImages->the_post();
            if (has_post_thumbnail($post->ID)) {
              $mediaId = get_post_thumbnail_id($post->ID); ?>
            <a class="press-thumbnail-wrapper" href="<?php echo wp_get_attachment_image_src(
              $mediaId,
              'full'
            )[0]; ?>" target="_blank">
            
              <?php Printer::render_image($mediaId, null, 'press-thumbnail'); ?>
            </a>
            <?php
            }
            ?> 


            <h4><?php echo the_title(); ?></h4>
            <?php echo the_content(); ?>
            <a class="download-link" href="<?php echo wp_get_attachment_image_src(
              $mediaId,
              'full'
            )[0]; ?>" target="_blank"><?php echo __(
  'Ladda ned bild',
  'fritidsbanken'
); ?></a>
          </div>
        
        <?php }
      } ?>
        <div class="press-image filler"></div>
        <div class="press-image filler"></div>
      </div> <!-- press-images -->

  </section>


</div>