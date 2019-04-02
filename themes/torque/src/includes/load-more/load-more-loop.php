<?php

require_once( 'load-more-helpers.php' );

class Torque_Load_More_Loop {

  public $id;

  private $query_args;

  private $loop_template_path;

  public function __construct( string $id, int $posts_per_page, array $query_args, string $loop_template_path ) {
    $this->id = $id;
    $this->query_args = $query_args;
    $this->query_args['posts_per_page'] = $posts_per_page;
    $this->loop_template_path = $loop_template_path;
  }


  public function get_data_for_js() {
    return array(
      'id'        => $this->id,
      'query'     => $this->query_args,
      'template'  => $this->loop_template_path,
    );
  }

  public function has_first_page() {
    $first_page_query = Torque_Load_More_Helpers::create_page_query($this->query_args, 1);
    return $first_page_query->have_posts();
  }

  public function render_first_page() {
    Torque_Load_More_Helpers::render_page( $this->id, 1, $this->query_args, $this->loop_template_path );
  }
}

?>
