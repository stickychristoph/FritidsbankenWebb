<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#4D9D34">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/icons/favicon.ico" rel="icon">
        <link rel="profile" href="<https://gmpg.org/xfn/11>">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,500i,600,700,700i" rel="stylesheet" />
        <script> var ajaxurl="<?php echo admin_url(
          'admin-ajax.php'
        ); ?>";</script>
        <?php wp_head(); ?>
    </head>
  <body <?php body_class('fb-ff'); ?>>
  <header class="site-header">
    <div class="top-bar content-outer">
      <a class="home-link" href="<?php echo esc_url(home_url('/')); ?>">
          <img class="logo" alt="Fritidsbanken" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/fritidsbanken_green.svg">
      </a>
      
      <nav class="main-menu-wrapper no-transitions">
          <button aria-label="Huvudmeny" tabindex="0" class="toggle">
            <div class="menu-label"><?php echo __(
              'Meny',
              'fritidsbanken'
            ); ?></div> 
            <!-- <div class="toggle-inner">
              <span></span>
              <span></span>
              <span></span>
            </div> -->
          </button>
          <div class="menu-curtain"></div>
          <?php wp_nav_menu([
            'container' => 'div',
            'container_class' => 'main-menu-container',
            'menu_class' => 'main-menu',
            'theme_location' => 'main-menu',
          ]); ?>
      </nav>
    </div>
    
        
  </header><!-- .site-header -->