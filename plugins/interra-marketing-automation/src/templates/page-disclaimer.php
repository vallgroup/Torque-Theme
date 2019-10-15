<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php $__path = Interra_Marketing_Automation_PATH; ?>

<main>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<div class="ima-proposal-details ima-section">
			<div class="torque_listing-title" >
			  <div class="listing-title-content" >

			    <h2><?php echo the_title(); ?></h2>
			  </div>

			  <?php if ( has_post_thumbnail() ) : ?>
			    <div class="featured-image-size" >
			      <div class="featured-image" style="background-image: url('<?php echo get_the_post_thumbnail_url( null, 'large'); ?>')" ></div>
			    </div>
			  <?php endif; ?>
			</div>

			<div class="torque-listing-content">
				<div class="torque-listing-content-details" >
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</main>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
