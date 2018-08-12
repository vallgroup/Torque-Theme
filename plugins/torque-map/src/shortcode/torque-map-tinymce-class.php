<?php
/**
 * Handle registratioin of tinymce plugin for shortcode
 */
class Torque_Map_TinyMCE {

	public static $instance = NULL;

	function __construct() {}

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	public function init() {
		add_filter( "mce_external_plugins" , array( $this, 'mce_plugin' ) );
    add_filter( "mce_buttons"          , array( $this, 'mce_button' ) );

    add_action( 'admin_footer'         , array( $this, 'insert_editor' ) );

    add_action( 'print_media_templates', array( $this, 'media_templates' ) );
	}

	public function mce_plugin( $plugin_array ) {
		$plugin_array['torque_map'] = Torque_Map_PATH . 'shortcode/torque-map-tinymce-plugin.js';
		return $plugin_array;
	}

	public function mce_button( $buttons ) {
    array_push( $buttons, 'torque_map_button' );
		return $buttons;
	}

	public function insert_editor( $hook ) {
		?>
		<div id="torque-map-builder" style="display:none;">
		</div>
		<?php
	}

	public function media_templates() {
		if ( ! isset( get_current_screen()->id )
			|| get_current_screen()->base != 'post' )
      return;
		include_once Torque_Map_PATH . 'shortcode/editor-torque-map-template.html';
	}
}

?>