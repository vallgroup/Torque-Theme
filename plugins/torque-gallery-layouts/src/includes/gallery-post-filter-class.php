<?php

require_once( Torque_Gallery_Layouts_PATH . 'includes/print-media-templates-hook-class.php' );

class Gallery_Post_Filter {

  // we just save this here so we dont have to access the static property each time
  private $data_setting_slug;

  private $gallery_defaults;

  /**
   * Register the filter callback so we can override the gallery output
   */
  public function __construct() {
    $this->data_setting_slug = Print_Media_Templates_Hook::$data_setting_slug;
    $this->gallery_defaults = Print_Media_Templates_Hook::get_gallery_defaults();

    add_filter( 'post_gallery', array( $this, 'post_gallery_filter_callback'), 10, 2 );
  }

  public function post_gallery_filter_callback( $output = '', $atts ) {
    $return = $output;

    // we add our own output
    // if the setting is set and not 0,
    // OR if it's not set but the default setting is not 0.
    if ( (isset($atts[$this->data_setting_slug])
            && $atts[$this->data_setting_slug] !== '0')
        || (! isset($atts[$this->data_setting_slug])
            && $this->gallery_defaults[$this->data_setting_slug] !== '0') ) {

      $return = $this->get_custom_output( $atts );
    }

    return $return;
  }

  private function get_custom_output( $atts ) {
    // set the atts to our own defaults.
    //
    // If the form is unhidden and the user is allowed to edit the wordpress gallery settings,
    // then those will override our defaults.
    //
    $atts = array_merge( $this->gallery_defaults, $atts );

    $ids = explode(',', $atts['ids']);
    $columns = explode('|', $atts['torque_layout']);

    ob_start();
    ?>

    <div class="torque-gallery-layout" >

    <?php

    foreach ($ids as $index => $id) {
      // note we loop through the columns with the mod operator,
      // so if we have more ids than columns it will just repeat the columns
      echo $this->column( $columns[$index % sizeof($columns)], $atts['size'], $id, $atts['link'] );
    }

    ?>

    </div>

    <?php
    return ob_get_clean();
  }

  private function column( $width, $size, $id, $link ) {
    $column = '';

    $column .= '<div class="torque-gallery-column torque-gallery-column-'.$width.'" style="'.$this->get_column_style($width).'" >';
    $column .= wp_get_attachment_image( $id, $size);
    $column .= '</div>';

    return $column;
  }

  private function get_column_style( $width ) {
    $perc_width = $width.'0%';

    return 'width: '.$perc_width.';';
  }
}

?>
