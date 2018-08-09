<?php
/**
 * Template Name: Front Page
 *
 * @package torque
 */
?>
<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<main>

		<div class="hero-wrapper" >
		<?php get_template_part( 'parts/acf/page-hero' ); ?>
		</div>

		<?php get_template_part( 'parts/acf/content-section', 'loop' ); ?>

</main>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
