<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Slideshow_CPT {

	/**
	 * Holds the slideshow cpt object
	 *
	 * @var Object
	 */
	protected $slideshow = null;

	/**
	 * Holds the labels needed to build the slideshow custom post type.
	 *
	 * @var array
	 */
	public static $slideshow_labels = array(
			'singular'       => 'Slideshow',
			'plural'         => 'Slideshows',
			'slug'           => 'torque-slideshow',
			'post_type_name' => 'torque_slideshow',
	);

	/**
	 * Holds options for the slideshow custom post type
	 *
	 * @var array
	 */
	protected $slideshow_options = array(
		'supports' => array(
			'title',
		),
		'menu_icon'           => 'dashicons-slides',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$slideshow_labels, $this->slideshow_options );

			add_action( 'init', array( $this, 'register_mb' ) );
		}
	}



	/**
	 * output the shortcode string
	 *
	 * @return string the shortcode string
	 */
	public function output_sc_string() {
		require_once( Torque_Slideshow_PATH . 'shortcode/torque-slideshow-shortcode-class.php' );

		global $post;

		?>
		<p>To use this slideshow anywhere on your site, copy and paste this shortcode: <code>[<?php echo Torque_Slideshow_Shortcode::$SHORTCODE_SLUG; ?> id="<?php echo $post->ID; ?>"]</code></p>
		<?php
	}

	public function register_mb() {

		pwp_add_metabox( array(
			'title' => 'The Shortcode',
			'callback' => array( $this, 'output_sc_string' ),
		), array( 'torque_slideshow' ), '', '' );

		pwp_add_metabox( 'Slideshow Details', array( 'torque_slideshow' ), array(
			'name_prefix' => 'torque_slideshow',
			array(
				'context'     => 'post',
				'type'        => 'wp_media',
				'name'        => '[images]',
				'label'       => 'Images',
				'placeholder' => 'Select slideshow images',
				'multiple'			=> true
			),
		), 'torque_slideshow');
	}
}

?>
