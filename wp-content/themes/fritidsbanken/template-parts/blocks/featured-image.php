<div class="featured-image-block">
    <?php
    $imageID = get_post_thumbnail_id();
    $image = wp_get_attachment_image_url($imageID, 'medium');
    $test = false;

    if ($image) {
      $test = true;
    }
    ?>
    <div class="image">
        <?php if ($image) { ?>
            <img src="<?php echo $image; ?>" class="image">
        <?php } ?>
    </div>
</div>