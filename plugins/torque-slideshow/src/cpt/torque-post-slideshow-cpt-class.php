<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Post_Slideshow_CPT {

	/**
	 * Holds the post_slideshow cpt object
	 *
	 * @var Object
	 */
	protected $post_slideshow = null;

	/**
	 * Holds the labels needed to build the post_slideshow custom post type.
	 *
	 * @var array
	 */
	public static $post_slideshow_labels = array(
			'singular'       => 'Post Slideshow',
			'plural'         => 'Post Slideshows',
			'slug'           => 'torque-post-ss',
			'post_type_name' => 'torque_post_ss',
	);

	/**
	 * Holds options for the post_slideshow custom post type
	 *
	 * @var array
	 */
	protected $post_slideshow_options = array(
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
			new PremiseCPT( self::$post_slideshow_labels, $this->post_slideshow_options );

			$this->register_mb();
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
		<p>To use this slideshow in your site, copy and paste this shortcode: <code>[<?php echo Torque_Slideshow_Shortcode::$SHORTCODE_SLUG; ?> id="<?php echo $post->ID; ?>" type="post"]</code></p>
		<?php
	}

	public function register_mb() {

		add_action('init', function() {
			pwp_add_metabox( array(
				'title' => 'The Shortcode',
				'priority'	=> 'high',
				'callback' => array( $this, 'output_sc_string' ),
			), array( self::$post_slideshow_labels['post_type_name'] ), '', '' );
		});

		if( ! class_exists('acf') ) {
			echo 'This feature requires ACF. Please install ACF to enable metaboxes';
			return;
		}

		add_action('acf/init', function() {

			if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5c913f0380267',
				'title' => 'Post Slideshow Details',
				'fields' => array(
					array(
						'key' => 'field_5c913f0fdb1a1',
						'label' => 'Posts',
						'name' => 'posts',
						'type' => 'relationship',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
						),
						'taxonomy' => array(
						),
						'filters' => array(
							0 => 'search',
							1 => 'post_type',
							2 => 'taxonomy',
						),
						'elements' => array(
							0 => 'featured_image',
						),
						'min' => '',
						'max' => '',
						'return_format' => 'id',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => self::$post_slideshow_labels['post_type_name'],
						),
					),
				),
				'menu_order' => 10,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			endif;
		});
	}
}

?>
