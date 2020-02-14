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
   * 
   */
  public static function build_table_element( 
    $tag, 
    $data, 
    $attributes = array(), 
    $styles = array() 
  ) {
    
    if ( 
      in_array( $tag, self::$allowable_tags )
      && !empty( $data )
    ) {
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
      $html = 'No data found for this table/part.';
    }

    return $html;

  }

}

?>