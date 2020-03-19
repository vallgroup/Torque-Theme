<?php

/**
 * Takes an amount and outputs said amount in US dollars, formatted into
 * thousands if required, and to two decimal places.
 */
function output_in_dollars( $amount ) {
  echo '$', (number_format( floatval( $amount ), 2, '.', ',' ));
}

/**
 * Takes a value and outputs said value formatted into
 * thousands if required, with 'SF' appended.
 */
function output_in_sq_ft( $value ) {
  echo (number_format( $value, 0, '.', ',' )), ' SF';
}

/**
 * Takes a pre-calculated ratio value, multiplies by 100 and outputs said
 * value to two decimal places, formatted with '%' appended.
 */
function output_in_percentage( $value ) {
  echo (number_format( ( $value * 100 ), 2, '.', ',' )), '%';
}

function output_in_ratio( $value ) {
  echo (number_format( ( $value ), 2, '.', ',' ));
}

/**
 * Takes an amount and outputs said amount in US dollars, formatted into
 * thousands if required, and to two decimal places.
 */
function get_in_dollars( $amount ) {
  return '$' . (number_format( floatval( $amount ), 2, '.', ',' ));
}

/**
 * Takes a value and outputs said value formatted into
 * thousands if required, with 'SF' appended.
 */
function get_in_sq_ft( $value ) {
  return (number_format( $value, 0, '.', ',' )) . ' SF';
}

/**
 * Takes a pre-calculated ratio value, multiplies by 100 and outputs said
 * value to two decimal places, formatted with '%' appended.
 */
function get_in_percentage( $value ) {
  return (number_format( ( $value * 100 ), 2, '.', ',' )) . '%';
}

function get_in_ratio( $value ) {
  return (number_format( ( $value ), 2, '.', ',' ));
}

?>
