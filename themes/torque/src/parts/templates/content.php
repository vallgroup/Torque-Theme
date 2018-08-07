<?php
/**
 * Template part for displaying posts
 *
 * @package Torque
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="content post-content">
		<?php
			the_content();
		?>
	</div>

</article>
