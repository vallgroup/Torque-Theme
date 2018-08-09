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
      get_template_part('parts/acf/content-section', 'loop');
			the_content();
		?>
	</div>

</article>
