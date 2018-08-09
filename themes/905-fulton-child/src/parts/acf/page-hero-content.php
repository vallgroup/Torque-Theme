<?php

$content_title = get_field('content_title');
$content = get_field('content');

if ( $content_title || $content ) {

  if ( $content_title ) { ?>
  <h2 class="page-hero-content-title" ><?php echo $content_title; ?></h2>
  <?php }

  if ( $content ) { ?>
  <div class="page-hero-content-content" ><?php echo $content; ?></div>
  <?php }

}
?>
