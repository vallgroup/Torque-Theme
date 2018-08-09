<?php

if( have_rows('content_section') ) {
  while( have_rows('content_section') ) { the_row();
  ?>

    <div class="content-section content-section-align-<?php the_sub_field('align'); ?>" >

      <div class="content-section-image-wrapper" >
        <?php get_template_part( 'parts/acf/content-section', 'image' ); ?>
      </div>

      <div class="content-section-content-wrapper" >
        <?php get_template_part( 'parts/acf/content-section', 'content' ); ?>
      </div>

    </div>

  <?php
  }
}
?>
