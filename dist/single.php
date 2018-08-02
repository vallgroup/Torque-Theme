<?php
/**
 * The Template for displaying all single posts
 *
 * Please see /external/bootstrap-utilities.php for info on TQ::get_template_parts()
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

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
