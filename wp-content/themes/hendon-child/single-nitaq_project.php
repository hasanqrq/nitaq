<?php
/**
 * Single template for nitaq_project CPT.
 * Uses nitaq_project_render() from inc/nitaq-projects.php.
 */

if ( ! function_exists( 'nitaq_project_render' ) ) {
	get_template_part( 'index' );
	return;
}

get_header();
?>
<?php while ( have_posts() ) : the_post(); ?>
<?php echo nitaq_project_render( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php endwhile; ?>
<?php get_footer(); ?>
