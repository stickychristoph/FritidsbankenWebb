<?php
/* 
Template Name: Archives
*/
get_header(); ?>

 
<div  class="fb-archive content">
<?php while (have_posts()):

  the_post();
  $date = get_field('date');
  $link = get_permalink();
  ?>

  <a href="<?php echo get_permalink($post->ID); ?>" class="press-release">
    <h6 class="press-release-date"><?php echo get_the_date('j F Y'); ?></h6>
    <h2><?php echo the_title(); ?></h2>
    <p><?php echo get_the_excerpt($post); ?></p>
  </a>
  <?php
endwhile;
// end of the loop.
?>
 

</div><!-- #primary -->

<?php get_footer();
?>
