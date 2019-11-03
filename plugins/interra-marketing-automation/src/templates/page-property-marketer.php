<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php $__path = Interra_Marketing_Automation_PATH; ?>

<main>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php load_template( $__path . 'templates/content/content-proposal-details.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-property-info.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-rent-roll.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-pictures-video.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-maps.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-comps.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-taxes.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-income-expenses.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-financial-summary.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-loan-amortization.php' ); ?>

	<?php load_template( $__path . 'templates/content/content-disclaimers.php' ); ?>

	<?php endwhile; ?>
</main>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
