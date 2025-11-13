<?php

$url = get_the_permalink();
$link_en = apply_filters('wpml_permalink', $url, 'en');
$link_sv = apply_filters('wpml_permalink', $url, 'sv');

// if no translation for english
// deprecated: $en_PostId = icl_object_id($post->ID, 'page', false, 'en');
$en_PostId = apply_filters('wpml_object_id', $post->ID, 'page', false, 'en');

if (!is_int($en_PostId)) {
  $link_en = apply_filters('wpml_permalink', get_home_url(), 'en');
}

$SoMe = get_field('social_media', 'option');
$langSelector = get_field('lang_selector', 'option');
?>
    
    
    <footer class="footer">
      <div class="content-inner">        
        <a class="home-link" href="<?php echo esc_url(home_url('/')); ?>">
          <img class="logo" alt="Fritidsbanken" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/fritidsbanken_white.svg">
        </a>
        <?php wp_nav_menu([
          'container' => false,
          'menu_class' => 'footer-menu',
          'theme_location' => 'footer-menu',
        ]); ?>

<?php if ($langSelector === true): ?>
        <div class="languages">
          <ul class="lang-menu">
            <?php if (ICL_LANGUAGE_CODE != 'sv'): ?>
              <li><a href="<?php echo $link_sv; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/sv.png" width="18" style="display:inline-block;margin-right:7px;vertical-align: baseline;"/>På svenska</a></li>
            <?php endif; ?>
            <?php if (ICL_LANGUAGE_CODE != 'en'): ?>
              <li><a href="<?php echo $link_en; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/en.png" width="18" style="display:inline-block;margin-right:7px;vertical-align: baseline;"/>In english</a></li>
              <?php endif; ?>
            </ul>
        </div>
<?php endif; ?>
        <div class="social-media">
          <a href="<?php echo $SoMe[
            'facebook'
          ]; ?>" target="_blank"><img class="logo" alt="facebook" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/facebook.svg">
          </a>
          <a href="<?php echo $SoMe[
            'twitter'
          ]; ?>" target="_blank"><img class="logo" alt="twitter" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/twitter.svg">
          </a>
          <a href="<?php echo $SoMe[
            'instagram'
          ]; ?>" target="_blank"><img class="logo" alt="instagram" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/instagram.svg">
          </a>
          <a href="<?php echo $SoMe[
            'linkedin'
          ]; ?>" target="_blank"><img class="logo" alt="linkedin" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/linkedin.svg">
          </a>
        </div>
        <?php wp_footer(); ?>
        <!-- <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-86366207-1', 'auto');
          ga('send', 'pageview');

        </script> -->
      </div>
    </footer>
    </body>
</html>