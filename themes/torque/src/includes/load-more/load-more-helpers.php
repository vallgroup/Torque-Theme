<?php

/**
 * These are functions that need to be shared between both the Load_More_Loop class and the Load_More API controller.
 */
class Torque_Load_More_Helpers {

  public static function render_page( $id, $page_number, $query_args, $template ) {
    $page_query = self::create_page_query( $query_args, $page_number );

    ob_start();

    if ( $page_query->have_posts() ) {
      while ( $page_query->have_posts() ) {
        $page_query->the_post();

        include locate_template($template);
      }

      self::render_load_more_button( $id, $page_number, $query_args );
    }

    wp_reset_postdata();

    echo ob_get_clean();
  }

  public static function render_load_more_button( $id, $page_number, $query_args ) {
    $new_page = intval($page_number) + 1;
    $next_page_query = self::create_page_query($query_args, $new_page);

    ob_start();

    if ($next_page_query->have_posts()) {
      ?>
      <div class="torque-load-more-button-wrapper">
        <button
          id="<?php echo $id; ?>"
          data-page-id="<?php echo $new_page; ?>"
        >
          Load More
        </button>
      </div>
      <?php
    }

    echo ob_get_clean();
  }

  public static function create_page_query( $query_args, $page_number ) {
    return new WP_Query( array_merge(
      $query_args,
      array(
        'paged'            => $page_number
      )
    ) );
  }
}

?>
