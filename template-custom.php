<?php
/**
 * Template Name: Custome Homepage
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'app-body'); ?>
<?php endwhile; ?>
