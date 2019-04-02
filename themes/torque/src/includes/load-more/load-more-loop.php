<?php

require_once( 'load-more-helpers.php' );

/**
 * One of these classes will need to be created for each individual 'load more' loop we want to create.
 *
 * It holds setup data for the loop, and functions to be used in the templates where the loop will be included.
 */

class Torque_Load_More_Loop {

  public $id;

  private $query_args;

  private $loop_template_path;

  /**
   * @param string $id                 A unique identifer for our loop eg author-blog-posts
   * @param int    $posts_per_page
   * @param array  $query_args         The query args for your posts query.
   *                                   The exact array you would pass directly into the WP_Query constructor
   *                                   Pagination happens automatically, so no need to pass a 'paged' parameter
   * @param string $loop_template_path Path to the template that will be included for each post in the loop
   *                                   Is passed to 'locate_template'
   */
  public function __construct( string $id, int $posts_per_page, array $query_args, string $loop_template_path ) {
    $this->id = $id;
    $this->query_args = $query_args;
    $this->query_args['posts_per_page'] = $posts_per_page;
    $this->loop_template_path = $loop_template_path;
  }

  /**
   * Once you've created your loop, this is an easy check to see if it actually has any posts
   *
   * @return boolean
   */
  public function has_first_page() {
    $first_page_query = Torque_Load_More_Helpers::create_page_query($this->query_args, 1);
    return $first_page_query->have_posts();
  }

  /**
   * Use this function in a template to start the loop by rendering the first page.
   *
   * If a next page exists, the 'load more' button will be added automatically.
   *
   * echos the output.
   */
  public function the_first_page() {
    Torque_Load_More_Helpers::render_page( $this->id, 1, $this->query_args, $this->loop_template_path );
  }

  /**
   * Used by the Load_More class to register this loop with the js
   * 
   * @return array
   */
  public function get_data_for_js() {
    return array(
      'id'        => $this->id,
      'query'     => $this->query_args,
      'template'  => $this->loop_template_path,
    );
  }
}

?>
