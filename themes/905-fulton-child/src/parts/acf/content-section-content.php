<?php

$title = get_sub_field('title');
$content = get_sub_field('content');

$cta_text = get_sub_field('cta_text');
$cta_link = get_sub_field('cta_link');

if ($title && $title !== '') { ?>
  <h3><?php echo $title; ?></h3>
<?php } ?>

<div class="content-section-content"><?php echo $content; ?></div>

<?php if ( $cta_text && $cta_text !== '' && $cta_link && $cta_link !== '' ) { ?>
  <a href="<?php echo $cta_link; ?>">
    <button><?php echo $cta_text; ?></button>
  </a>
<?php } ?>
