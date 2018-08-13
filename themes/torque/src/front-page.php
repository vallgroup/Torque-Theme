<?php
/**
 * The template for displaying the front page.
 *
 * This is the template that displays the front page by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package torque
 */
?>
<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<main>

	<h1>
		<?php echo get_bloginfo( 'name' ); ?>
	</h1>

</main>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
