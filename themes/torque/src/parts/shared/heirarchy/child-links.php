<?php

if ( ! isset($post_type) || ! $post_type ) {
  $post_type = $post->post_type;
}

if ( ! isset($post_status) ) {
  $post_status = 'publish';
}

if ( ! isset($numberposts) ) {
  $numberposts = -1;
}

if ( ! isset($parent) ) {
  $parent = $post->ID;
}

if ($parent) {

  $args = array(
  	'post_parent' => $parent,
  	'post_type'   => $post_type,
  	'numberposts' => $numberposts,
  	'post_status' => $post_status
  );
  $children = get_children( $args );

  foreach ($children as $child_id => $child) {

    ?>


    <div class="torque-child-link-wrapper">
      <a href="<?php echo get_the_permalink( $child_id ); ?>" >
        <?php echo $child->post_title; ?>
      </a>
    </div>

    <?
  }
}

?>
