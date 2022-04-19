<?php defined( 'ABSPATH' ) || die( 'Direct file access is prohibited.' ); ?>

<footer class="footer" id="colophon">
  <?php print apply_filters( 'the_content', get_post( 22 )->post_content ); ?>
</footer>

<?php wp_footer(); ?>

</body>

</html>