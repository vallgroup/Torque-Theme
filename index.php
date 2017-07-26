<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/torque-utilities.php for info on TQ::get_template_parts()
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

<?php else: ?>
	<h1>
		<?php echo __('Nothing to show yet.', 'wp_torque')?>
	</h1>
<?php endif; ?>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
