<?php

$title = get_sub_field('title');
$content = get_sub_field('content');

if ($title && $title !== '') { ?>
  <h3><?php echo $title; ?></h3>
<?php } ?>

<div class="content-section-content"><?php echo $content; ?></div>
