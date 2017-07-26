<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/bootsrap-utilities.php for info on TQ::get_template_parts()
 *
 * @package 		WordPress
 * @subpackage 	Torque Theme
 * @author 			Torque
 */
?>
<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
	<div class="content">

		<?php the_content(); ?>
		
	</div>
	
	<?php endwhile; ?>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
