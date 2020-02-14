<?php

class Dynamic_Email_Table_Class {

  /**
   * Accepted tags that can be dynamically output 
   * using build_table_element().
   */
  private static $allowable_tags = array(
    'table',
    'tbody',
    'thead',
    'tfoot',
    'th',
    'tr',
    'td',
  );

  public static $colors = array(
    'white'         => '#FFF',
    'black'         => '#000',
    'medium_green'  => '#95CA53',
    'dark_green'    => '#64A557',
    'medium_gray'   => '#696A6D',
  );

  public function __construct() {}

  /**
   * Builds a dynamic table HTML tags based on params it is fed
   * 
   * @param string $tag         a valid HTML table tag
   * @param array  $data        an array of strings, containing the data to be insert in the HTML table tag
   * @param array  $attributes  HTML table tag-specific attributes, such as border, padding, align, etc...
   * @param array  $styles      inline styles for the HTML table tag
   */
  public static function build_table_element( 
    $tag = 'table', 
    $data = array(), 
    $attributes = array(), 
    $styles = array() 
  ) {
    if ( 
      in_array( $tag, self::$allowable_tags )
      && !empty( $data )
    ) {
      // format tag
      $tag = str_replace( array( '<', '>' ), '', $tag );
      // start/open
      $html = '<' . $tag . ' ';
      // attributes
      foreach ( $attributes as $key => $value ) {
        $html .= $key . '="' . $value . '" ';
      }
      // styles
      $html .= 'style="';
      foreach ( $styles as $key => $value ) {
        $html .= $key . ': ' . $value . '; ';
      }
      $html .= '"';
      // close
      $html .= '>';
      // data
      $html .= implode( ' ', $data );
      // end
      $html .= '</' . $tag . '>';
    } else {
      // set warning mesage
      $html = 'Either no data found for this section, or a valid HTML table tag was not received.';
    }

    return $html;
  }

  public static function start_table() {
    ob_start();
  }

  public static function end_table( $attributes = array(), $styles = array() ) {
    $html = Dynamic_Email_Table_Class::build_table_element( 'tr', array( ob_get_contents() ) );
    $html = Dynamic_Email_Table_Class::build_table_element( 'tbody', array( $html ) );
    $html = Dynamic_Email_Table_Class::build_table_element( 'table', array( $html ), $attributes, $styles );

    ob_end_clean();

    return $html;
  }

}

?>