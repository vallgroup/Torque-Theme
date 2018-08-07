<?php

require_once( get_template_directory() . '/includes/customizer/torque-customizer-class.php' );

$logo_src = get_theme_mod( Torque_Customizer::$logo_setting_slug )

if ( $logo_src ) {
?>

  <img class="torque-logo torque-header-logo" src="<?php echo $logo_src; ?>" />

<?php
}
?>
