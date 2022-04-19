<?php defined( 'ABSPATH' ) || die( 'Direct file access is prohibited.' ); ?>

<?php get_header(); 

if ( have_posts() ) {
  while ( have_posts() ) {

      the_post(); 
?>
<main id="site-main" class="site-main">

</main>
<?php 
  }
}
?>
<?php get_footer(); ?>

