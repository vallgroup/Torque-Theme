<?php
/**
 * The Template for displaying all single posts
 *
 * @package 		torque
 * @author 			Torque
 */
?>
<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="content">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
	?>

		<?php get_template_part( 'parts/templates/titles/title', get_post_format() ); ?>

		<?php get_template_part( 'parts/templates/content', get_post_format() ); ?>

	<?php
		}
	}
	else {  ?>

		<h1>
			<?php echo 'Nothing to show yet.'; ?>
		</h1>

	<?php } ?>
</div>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
