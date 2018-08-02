<?php
/**
 * The template for displaying the front page.
 *
 * This is the template that displays the front page by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/bootsrap-utilities.php for info on TQ::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Bootstrap 4.0.0
 * @autor 		Babobski
 */
?>
<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="content">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php
			get_template_part( 'parts/templates/content', 'homepage' );
		?>

		<?php echo 'Hello World Test Now!'; ?>

	<?php endwhile; ?>
</div>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
