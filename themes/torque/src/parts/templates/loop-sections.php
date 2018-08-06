<?php
/**
 * Loop to display the page sections content for a default page
 *
 * @package Wordpress
 */
// check if the flexible content field has rows of data
if ( have_rows( 'sections' ) ):
  // loop through the rows of data
  while ( have_rows( 'sections' ) ) : the_row();
    // switch ( get_row_layout() ) {
    //   case 'homepage_header' :
    //     $image = get_sub_field( 'background_image' );
    //     $headline = get_sub_field( 'page_headline' );
    //     $bg_overlay = get_sub_field('bg_overlay');
    //     include locate_template('/template-parts/template-homepage_header.php');
    //     break;
    //   case 'header' :
    //     $image = get_sub_field('background_image');
    //     $tab_color = get_sub_field('tab_color');
    //     include locate_template('/template-parts/template-header.php');
    //     break;
    // }
  endwhile;
else :
?>

  <div class="container">
    <?php the_content(); ?>
  </div>

<?php
endif;
?>
