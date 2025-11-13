<?php
use StickyBeat\Printer;

$label = get_field('label');
$relPage = get_field('related_page');
?>

<div class="fb-easy-to-read">
  
    <div class="button-wrapper">
      <div aria-role="button" class="easy-to-read-button" id="content-toggle">
      <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 8V19H13.5" stroke="white" stroke-width="2" stroke-linecap="round"/>
        <path d="M9.5 2V13H19" stroke="white" stroke-width="2" stroke-linecap="round"/>
      </svg>
        <span><?php echo $label; ?></span>
      </div>
    </div>
  
    <div class="content easy-to-read hidden" id="fbSecondaryContent">

      <?php echo apply_filters('the_content', $relPage->post_content); ?>

    </div>
</div>

