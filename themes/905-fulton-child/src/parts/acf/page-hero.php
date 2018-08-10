<div class="page-hero" >

  <img src="<?php echo get_the_post_thumbnail_url( null, $size = 'original' ); ?>" class="page-hero-image" />

  <div class="page-hero-title-wrapper" >
    <?php get_template_part( 'parts/acf/page-hero', 'title' ); ?>
  </div>

  <div class="page-hero-mobile-helper">
    <div class="page-hero-content-wrapper" >
      <?php get_template_part( 'parts/acf/page-hero', 'content' ); ?>
    </div>
  </div>

</div>
