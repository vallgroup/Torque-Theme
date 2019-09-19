<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Torque
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="content page-content">
		<?php
			the_content();
		?>
	</div>

</article>
