<?php

use StickyBeat\Printer;

$title = get_field('title');
$body = get_field('body');
$cta = get_field('cta');
$link = get_field('link');
$imageId = get_field('bg_img');
$bgVideo = get_field('bg_video');
?>
<div class="fb-startpage-hero has-background">
  <div class="content-outer ">
  <?php if ($imageId && !$bgVideo) {
    Printer::render_image($imageId, null, 'bg-image');
  } elseif ($imageId && $bgVideo) { ?>
    <video
      class="bg-image"
      id="bgvid"
      playsinline
      autoplay
      muted
      loop
      poster="<?php wp_get_attachment_image_src($imageId, 'medium')[0]; ?>"
    >
      <source src="<?php echo $bgVideo; ?>" type="video/mp4">
    </video>
    <div class="video-gradient"></div>
   
    <?php } ?>

    <div class="overlay-bg"></div>

    <?php if ($imageId && $bgVideo) { ?>
    <div  aria-label="stop video" id="stopVideo" class="stop-video">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/pause.svg" alt="stop video"/>
    </div>
    <?php } ?>


    <div class="text-container">
      <h1><?php echo $title; ?></h1>
      <p><?php echo $body; ?></p>
      <div class="button-container">
        <?php if (is_array($cta)):
          Printer::render_button($cta, 'white', 'map_marker_blue.svg');
        endif; ?>
        <?php if (is_array($link)):
          Printer::render_text_link($link, 'white');
        endif; ?>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    
  const stopButton = document.getElementById("stopVideo");
  const video = document.getElementById("bgvid");
  if(stopButton){
    stopButton.addEventListener('click', () =>{
      console.log("click")
      video.pause();
      stopButton.classList.add("stopped")
    })
  }

</script>
  
</div>


