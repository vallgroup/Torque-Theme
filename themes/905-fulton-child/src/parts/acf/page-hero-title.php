<?php

$title = get_field('title');
$caption = get_field('caption');

?>

<h1 class="page-hero-title"><?php echo $title; ?></h1>

<?php if ( $caption ) { ?>
  <h2 class="page-hero-caption" ><?php echo $caption; ?></h2>
<?php } ?>
