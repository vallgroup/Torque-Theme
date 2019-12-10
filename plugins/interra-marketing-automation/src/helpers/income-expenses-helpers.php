<?php
/**
 * Helpers for the income and expenses classes, as well financial summary classes.
 */

// outputs the income table
function output_income_table( $table_data ) {
  output_table( 'Income Summary', $table_data );
}
// outputs the expenses table
function output_expenses_table( $table_data ) {
  output_table( 'Expense Summary', $table_data );
}
// outputs the investment table
function output_investment_table( $rows = array() ) {
  output_table( 'Investment Summary', ['rows' => $rows] );
}
// outputs the operating table
function output_operating_table( $rows = array() ) {
  output_table( 'Operating Summary', ['rows' => $rows] );
}
// outputs the financing table
function output_financing_table( $rows = array() ) {
  output_table( 'Financing Summary', ['rows' => $rows] );
}
// output a table
function output_table( $title = '', $table = array() ) {
  ?><table class="ima-financing-table ima-table">
    <thead>
      <tr class="ima-table-row">
        <th><?php echo strip_tags( $title ); ?></th>

        <?php if ( isset( $table['header'] ) ) :
          foreach( (array) $table['header'] as $column ) : ?>
            <th><?php echo strip_tags( $column ); ?></th>
        <?php endforeach;
        endif; ?>
      </tr>
    </thead>
    <?php
      // output rows if any exist
      if ( isset( $table['rows'] )
        && is_array( $table['rows'] ) ) {
        output_table_rows( $table['rows'] );
      }
      // output footer if exists
      if ( isset( $table['footer'] )
        && is_array( $table['footer'] ) ) {
        output_table_footer( $table['footer'] );
      }
  ?></table><?php
}
// output table rows
function output_table_rows( $rows = array() ) {
  ?><tbody><?php
    foreach ( (array) $rows as $label => $columns ) {
      ?><tr class="ima-table-row">
        <td class="align-left">
          <?php echo strip_tags( $label ); ?>
        </td><?php
        // build the columns
        foreach ( (array) $columns as $key => $col ) {
          ?><td class="align-right">
            <?php echo strip_tags( $col ); ?>
          </td><?php
        }
      ?></tr><?php
    }
  ?></tbody><?php
}
// output table footer
function output_table_footer( $rows = array() ) {
  ?><tfoot><?php
    foreach ( (array) $rows as $label => $columns ) {
      ?><tr class="ima-table-row">
        <th class="align-left">
          <?php echo strip_tags( $label ); ?>
        </th><?php
        // build the columns
        foreach ( (array) $columns as $key => $col ) {
          ?><th class="align-right">
            <?php echo strip_tags( $col ); ?>
          </th><?php
        }
      ?></tr><?php
    }
  ?></tfoot><?php
}
?>
