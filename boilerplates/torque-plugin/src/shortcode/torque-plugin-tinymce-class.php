<?php
/**
 * Handle registratioin of tinymce plugin for shortcode
 */
class <torque_plugin_class_name>_TinyMCE {

	public static $instance = NULL;

	/**
	 * Filter whether to display the tinymce plugin button or not.
	 *
	 * @var string
	 */
	public static $TINYMCE_PLUGIN_BUTTON_FILTER = '<torque_plugin_shortcode>_tinymce_plugin_button';

	function __construct() {}

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	public function init() {
		add_filter( "mce_external_plugins" , array( $this, 'mce_plugin' ) );
    add_action( 'admin_footer'         , array( $this, 'insert_editor' ) );
    add_action( 'print_media_templates', array( $this, 'media_templates' ) );

		if ( apply_filters( self::$TINYMCE_PLUGIN_BUTTON_FILTER, true ) )
    	add_filter( "mce_buttons"          , array( $this, 'mce_button' ) );
	}

	public function mce_plugin( $plugin_array ) {
		$plugin_array['<torque_plugin_shortcode>'] = '/wp-content/plugins/<torque_plugin_slug>/shortcode/<torque_plugin_slug>-tinymce-plugin.js';
		return $plugin_array;
	}

	public function mce_button( $buttons ) {
    array_push( $buttons, '<torque_plugin_shortcode>_button' );
		return $buttons;
	}

	public function insert_editor( $hook ) {
		?>
		<div id="<torque_plugin_slug>-builder" style="display:none;">
		</div>
		<?php
	}

	public function media_templates() {
		if ( ! isset( get_current_screen()->id )
			|| get_current_screen()->base != 'post' )
      return;
		include_once '<torque_plugin_slug>-tinymce-editor.html';
	}
}

?>
