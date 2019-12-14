<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Image_Grid_CPT {

  public static $POST_TYPE = 'torque_image_grid';

	/**
	 * Holds the example cpt object
	 *
	 * @var Object
	 */
	protected $cpt = null;

	/**
	 * Holds the labels needed to build the example custom post type.
	 *
	 * @var array
	 */
	public static $cpt_labels = array(
			'singular'       => 'Image Grid',
			'plural'         => 'Image Grids',
			'slug'           => 'torque-image-grid',
			'post_type_name' => 'torque_image_grid',
	);

	/**
	 * Holds options for the example custom post type
	 *
	 * @var array
	 */
	protected $cpt_options = array(
		'supports' => array(
			'title',
			'editor'
		),
		'menu_icon'           => 'dashicons-grid-view',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			// Register CPT
			new PremiseCPT( self::$cpt_labels, $this->cpt_options );
			
			// add metaboxes needed from ACF
			add_action( 'acf/init', array( $this, 'add_cpt_metaboxes' ) );
		}
	}

	/**
	 * output the shortcode string
	 *
	 * @return string the shortcode string
	 */
	public function output_sc_string() {
		global $post;
		?>
		<p>To use this map anywhere on your site, copy and paste this shortcode: <code>[torque_image_grid slug="<?php echo $post->post_name; ?>"]</code></p>
		<?php
	}
	
	/**
	 * output the metaboxes for the CPT
	 */
  public function add_cpt_metaboxes() {

		// shortcode metabox definition
		pwp_add_metabox( array(
			'title' => 'The Shortcode',
			'callback' => array( $this, 'output_sc_string' ),
		), array( 'torque_image_grid' ), '', '' );

		// ACF definitions
    if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5de811bde5b0e',
				'title' => 'Torque Image Grids',
				'fields' => array(
					array(
						'key' => 'field_5de811ffc3491',
						'label' => 'Images Per Row',
						'name' => 'images_per_row',
						'type' => 'range',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 3,
						'min' => 1,
						'max' => 6,
						'step' => 1,
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_5de811c4e13b4',
						'label' => 'Images',
						'name' => 'images',
						'type' => 'gallery',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'min' => 1,
						'max' => '',
						'insert' => 'append',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_image_grid',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5df3e3c1d9a69',
				'title' => 'Attachment URL',
				'fields' => array(
					array(
						'key' => 'field_5df3e3e91d71f',
						'label' => 'Media Link',
						'name' => 'media_link',
						'type' => 'link',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'array',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'attachment',
							'operator' => '==',
							'value' => 'all',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));
			
			endif;
	}
}

?>
