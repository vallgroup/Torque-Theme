<?php

/**
 *
 */
function output_income_table( $table_data ) {
  ?><table class="ima-income-table ima-table">
    <thead>
      <tr class="ima-table-row">

        <th>Income Summary</th>

        <th><?php echo $table_data['columns']['current']; ?></th>

        <th><?php echo $table_data['columns']['market']; ?></th>

        <th>Per Unit</th>

      </tr>
    </thead>

    <?php
      output_income_table_rows( $table_data['rows'], $table_data['data'] );
      output_income_table_footer( $table_data['footer'], $table_data['data'] );
    ?>

  </table><?php
}

function output_income_table_rows( $rows, $data ) {

  ?><tbody><?php
    foreach ( (array) $rows as $label => $value ) {
      if ( empty( $value ) )
        continue;
      ?>
      <tr class="ima-table-row">
        <td class="align-left">
          <?php echo strip_tags( $label ); ?>
        </td>

        <td class="align-right">
          <?php
            if ( 'Vacancy' === $label ) {
              output_in_percentage( ($value['current'] / 100) );
            }else {
              output_in_dollars( $value['current'] );
            } ?>
        </td>

        <td class="align-right">
          <?php if ( 'Vacancy' === $label ) {
            output_in_percentage( ($value['market'] / 100) );
          } else {
            output_in_dollars( $value['market'] );
          } ?>
        </td>

        <td class="align-right">
          <?php if ( 'Vacancy' === $label ) {
              output_in_percentage( (($value['current'] / $data['units_rented']) / 100) );
            } else {
              output_in_dollars( $value['current'] / $data['units_rented'] );
            } ?>
        </td>
      </tr>
      <?php
    }
  ?></tbody><?php
}

function output_income_table_footer( $footer, $data ) {

  ?><tfoot><?php
    foreach ( (array) $footer as $label => $value ) {
      if ( empty( $value ) )
        continue;
      ?>
      <tr class="ima-table-row">
        <th class="align-center">
          <?php echo strip_tags( $label ); ?>
        </th>
        <th class="align-center">
          <?php output_in_dollars( $value['current'] ); ?>
        </th>

        <th class="align-right">
          <?php output_in_dollars( $value['market'] ); ?>
        </th>

        <th class="align-center">
          <?php output_in_dollars( $value['current'] / $data['units_rented'] ); ?>
        </th>
      </tr>
      <?php
    }
  ?></tfoot><?php
}


function output_expenses_table( $table_data ) {
  ?><table class="ima-income-table ima-table">
    <thead>
      <tr class="ima-table-row">

        <th>Expense Summary</th>

        <th><?php echo $table_data['columns']['current']; ?></th>

        <th><?php echo $table_data['columns']['market']; ?></th>

        <th>% of Gross Income</th>

        <th>Per Unit</th>

      </tr>
    </thead>

    <?php
      output_expenses_table_rows( $table_data['rows'], $table_data['data'] );
      output_expenses_table_footer( $table_data['footer'], $table_data['data'] );
    ?>

  </table><?php
}

function output_expenses_table_rows( $rows, $data ) {

  ?><tbody><?php
    foreach ( (array) $rows as $label => $row ) {
      if ( empty( $row ) )
        continue;

      ?>
      <tr class="ima-table-row">
        <td class="align-left">
          <?php echo strip_tags( $label ); ?>
        </td>
        <td class="align-right">
          <?php output_in_dollars( $row['current'] ); ?>
        </td>

        <td class="align-right">
          <?php output_in_dollars( $row[ 'market' ] ); ?>
        </td>

        <td class="align-right">
          <?php output_in_percentage( $row['current'] / $data['income_total']['current'] ); ?>
        </td>

        <td class="align-right">
          <?php output_in_dollars( $row['current'] / $data['units_rented'] ); ?>
        </td>
      </tr>
      <?php
    }
  ?></tbody><?php
}

function output_expenses_table_footer( $footer, $data ) {

  ?><tfoot><?php
    foreach ( (array) $footer as $label => $row ) {
      if ( empty( $row ) )
        continue;
      ?>
      <tr class="ima-table-row">
        <th class="align-center">
          <?php echo strip_tags( $label ); ?>
        </th>
        <th class="align-center">
          <?php output_in_dollars( $row['current'] ); ?>
        </th>

        <th class="align-right">
          <?php output_in_dollars( $row['market'] ); ?>
        </th>

        <th class="align-center">
          <?php output_in_percentage( $row['current'] / $data['income_total']['current'] ); ?>
        </th>

        <th class="align-center">
          <?php output_in_dollars( $row['current'] / $data['units_rented'] ); ?>
        </th>
      </tr>
      <?php
    }
  ?></tfoot><?php
}

?>
