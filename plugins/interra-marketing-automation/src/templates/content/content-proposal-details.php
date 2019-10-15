<?php

$project_name     = get_field( 'project_name' );
$date_of_proposal = get_field( 'date_of_proposal' );
$client_names     = get_field( 'client_names' );
$company_name     = get_field( 'company_name' );
$broker           = get_field( 'broker' );

?>

<div class="ima-proposal-details ima-section">
	<div class="torque_listing-title" >
	  <div class="listing-title-content" >

	    <div class="the-terms">
	      <div class="availability">
	        <?php echo sprintf( 'Created %s', $date_of_proposal ); ?>
	      </div>
	    </div>

	    <h2><?php echo $project_name; ?></h2>
	  </div>

	  <?php if ( has_post_thumbnail() ) : ?>
	    <div class="featured-image-size" >
	      <div class="featured-image" style="background-image: url('<?php echo get_the_post_thumbnail_url( null, 'large'); ?>')" ></div>
	    </div>
	  <?php endif; ?>
	</div>

	<?php if ( is_array( $client_names )
		&& ! empty( $client_names ) ) : ?>
		<div class="torque-listing-content">
			<div class="torque-listing-content-details" >
				<h4>Prepared For</h4>
				<div class="key-details-wrapper">
				  <?php foreach ( $client_names as $key => $client ) : ?>
				  	<div class="key-detail" >
					    <div class="key-detail-name">
					      <?php echo 'Client Name'; ?>
					    </div>
					    <div class="key-detail-value">
					      <?php echo $client['name']; ?>
					    </div>
					  </div>
				  <?php endforeach; ?>
				  <?php if ( ! empty( $company_name ) ) : ?>
				  	<div class="key-detail" >
					    <div class="key-detail-name">
					      <?php echo 'Company'; ?>
					    </div>
					    <div class="key-detail-value">
					      <?php echo $company_name; ?>
					    </div>
					  </div>
				  <?php endif; ?>
				</div>
			</div>
			<?php if ( $broker && $broker->ID ) :
				$title = $broker->data->display_name;
	      $permalink = get_author_posts_url( $broker->ID );
	      $thumbnail = get_field( 'featured_image', 'user_'.$broker->ID );
	      if (!$thumbnail) $thumbnail = get_avatar_url( $broker->ID, array( 'size' => 400 ) );
	      $tel = get_field( 'telephone', 'user_'.$broker->ID );
	      $email = $broker->user_email; ?>
				<div class="torque-listing-content-brokers">
		    	<div class="brokers-wrapper">
		        <h4 class="brokers-section-title">Prepared By</h4>
		    	    <div class="broker">
		            <a class="broker-image-container" href="<?php echo $permalink; ?>">
		              <img class="broker-image" src="<?php echo $thumbnail; ?>" />
		            </a>

		            <div class="broker-content" >
		              <a href="<?php echo $permalink; ?>">
		      	    	  <h4><?php echo $title; ?></h4>
		              </a>


		              <div class="meet-broker" >
		                <a href="<?php echo $permalink; ?>">
		                  Meet <?php echo $broker->first_name; ?>
		                </a>
		              </div>


		              <?php if ($email) { ?>
		                <a href="mailto:<?php echo $email; ?>" >
		                  <div class="broker-icon envelope"></div>
		                </a>
		              <?php } ?>

		              <?php if ($tel) { ?>
		                <a href="tel:<?php echo $tel; ?>" >
		                  <div class="broker-icon phone"></div>
		                </a>
		              <?php } ?>
		            </div>
		    	    </div>
		      </div>
			  </div>
		  <?php endif; ?>
		</div>
	<?php endif; ?>
</div>