<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Please see /external/bootstrap-utilities.php for info on TQ::get_template_parts()
 *
 * @package 		WordPress
 * @subpackage 	Torque Theme
 * @author 			Torque
 */
?>
<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<h2 class="h2">
	<?php echo __('Page not found', 'wp_torque'); ?>
</h2>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
