<?php defined( 'ABSPATH' ) || die( 'Direct file access is prohibited.' ); ?>
<!DOCTYPE html>
<html class="nojs" lang="en_US">
<head>

<script>document.documentElement.className = "js"; </script>

<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#B75C1D">
<meta name="msapplication-TileColor" content="#303C42">
<meta name="theme-color" content="#B75C1D">

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KLP8G4M');</script>
<!-- End Google Tag Manager -->

<?php wp_head(); ?>

</head>
<body <?php print body_class(); ?> id="body">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KLP8G4M"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<a href="#!/site-main" id="skip-to-content" class="screen-reader-text">Skip to main content</a>
<header class="header" id="site-header">
  <div class="header__wrap content-wrap">
    <a class="header__branding" href="<?php echo get_home_url(); ?>">
      <img class="header__logo--white" src="<?php echo wp_get_attachment_image_url(get_field('site_logo', 'options')); ?>"/>
    </a>
    <nav class="nav nav__main" aria-label="Main Navigation">
      <button class="button nav__button button--nav" id="toggle-main-nav" aria-expanded="false">
        <div class="nav__icon-wrap">
          <span class="nav__icon"></span>
        </div>
      </button>
      <div class="nav__main-wrap">
        <?php
          wp_nav_menu(array(
            'menu'  => 'primary',
          ));
        ?>
        <?php //print apply_filters( 'the_content', get_post( 115 )->post_content ); ?>
      </div>

    </nav>
  </div>

</header>


