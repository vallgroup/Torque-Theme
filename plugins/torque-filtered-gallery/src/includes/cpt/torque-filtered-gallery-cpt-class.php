<?php
/**
 * Torque filtered gallery CPT
 */
class Torque_Filtered_Gallery_CPT {

  public static $FILTERED_GALLERY_ACF_KEY = 'field_5e4d68f62a688';
  public static $FILTERED_GALLERY_CAT_NAME = 'filtered_gallery_categories';
  public static $FILTERED_GALLERY_CAT_KEY = 'field_5e4d72664009e';
  public static $FILTERED_GALLERY_CAT_SUB_FIELD_NAME = 'category';

	/**
	 * Holds the labels needed to build the careers custom post type.
	 *
	 * @var array
	 */
	public static $cpt_labels = array(
    'singular'       => 'Filtered Gallery',
    'plural'         => 'Filtered Galleries',
    'slug'           => 'tq-filtered-gallery',
    'post_type_name' => 'tq_filtered_gallery',
);

  protected $args = array(
    'supports' => array( 'title', ),
    'menu_icon'           => 'dashicons-images-alt',
    'show_in_rest'        => true,
    // more args here
  );

  private $cpt = null;

  function __construct() {
    if ( class_exists( 'PremiseCPT' ) ) {
      // register CPT
      $this->cpt = new PremiseCPT( self::$cpt_labels, $this->args );
      
      // add metaboxes needed from ACF
      add_action( 'acf/init', array( $this, 'add_acf_metaboxes' ) );
      
      add_filter( 'acf/load_field/key=' . self::$FILTERED_GALLERY_ACF_KEY, array( $this, 'acf_load_category_field_choices' ), 10, 3 );
    }
  }

  function acf_load_category_field_choices( $field ) {

    // reset choices
    $field['choices'] = array();

    $filtered_galleries_args = array(
      'post_type' => self::$cpt_labels['post_type_name'],
      'nopaging' => true,
    );
  
    $filtered_galleries = get_posts( $filtered_galleries_args );
  
    if ( count( $filtered_galleries ) > 0 ) :
      foreach ( $filtered_galleries as $filtered_gallery ) :
        // if has rows
        if ( have_rows( self::$FILTERED_GALLERY_CAT_NAME, $filtered_gallery->ID ) ) :
          // while has rows
          while ( have_rows( self::$FILTERED_GALLERY_CAT_NAME, $filtered_gallery->ID ) ) : the_row();
            
            // vars
            $label = get_sub_field( self::$FILTERED_GALLERY_CAT_SUB_FIELD_NAME );
            $value = $label
              ? strtolower( str_replace( array( ' ', ',', '.', '_' ), '-', $label ) )
              : null;

            // append to choices
            if ( $label ) {
              $field['choices'][$value] = $label;
            }

          endwhile;
        endif;
      endforeach;
    endif;

    // return the field
    return $field;
  }

	/**
	 * output the shortcode string
	 *
	 * @return string the shortcode string
	 */
	public function output_sc_string() {
    global $post;
    var_dump( 'testing....' );
		?>
		<p>To use this filtered gallery anywhere on your site, copy and paste this shortcode: <code>[torque_filtered_gallery gallery_id="<?php echo $post->ID; ?>"]</code></p>
		<?php
  }

  public function add_acf_metaboxes() {

    // add shortcode metabox
		pwp_add_metabox( array(
			'title' => 'The Shortcode',
			'callback' => array( $this, 'output_sc_string' ),
    ), array( 'torque_filtered_gallery' ), '', '' );
    
    // ACF DEFS - START

    // UPDATED: 20210115
    
    if( function_exists('acf_add_local_field_group') ):

      // options for the plugin

      acf_add_local_field_group(array(
        'key' => 'group_60011a86068ce',
        'title' => 'Filtered Galleries Options',
        'fields' => array(
          array(
            'key' => 'field_60011cacdf58f',
            'label' => 'Instructions',
            'name' => '',
            'type' => 'message',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => 'This iFrame will be included in the Filtered Gallery only if the gallery utilizes Filtered Gallery Categories. A button will be appended to the filters, and when clicked will hide the gallery and load the iFrame in its place.',
            'new_lines' => 'wpautop',
            'esc_html' => 0,
          ),
          array(
            'key' => 'field_60011a8b0db9d',
            'label' => 'iFrame Button Title',
            'name' => 'iframe_button_title',
            'type' => 'text',
            'instructions' => 'Text to appear on the button appended to the gallery filters.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '50',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'readonly' => 0,
            'disabled' => 0,
          ),
          array(
            'key' => 'field_60011bd90db9f',
            'label' => 'iFrame Title',
            'name' => 'iframe_title',
            'type' => 'text',
            'instructions' => 'Text to appear above the iframe .',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '50',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'readonly' => 0,
            'disabled' => 0,
          ),
          array(
            'key' => 'field_60011c570dba0',
            'label' => 'iFrame URL',
            'name' => 'iframe_url',
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '100',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'options_page',
              'operator' => '==',
              'value' => 'acf-options',
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

      // Categories, for the attachment page
      acf_add_local_field_group(array(
        'key' => 'group_5e4d68efbd8c4',
        'title' => 'Filtered Gallery Categories',
        'fields' => array(
          array(
            'key' => self::$FILTERED_GALLERY_ACF_KEY,
            'label' => 'Filtered Gallery Categories',
            'name' => 'filtered_gallery_categories',
            'type' => 'checkbox',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'choices' => array(
            ),
            'allow_custom' => 0,
            'default_value' => array(
            ),
            'layout' => 'vertical',
            'toggle' => 0,
            'return_format' => 'value',
            'save_custom' => 0,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'attachment',
              'operator' => '==',
              'value' => 'image',
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
      
      // options, for the Filtered Gallery CPT page
      acf_add_local_field_group(array(
        'key' => 'group_5e4d722984191',
        'title' => 'Filtered Gallery Options',
        'fields' => array(
          array(
            'key' => 'field_5e5478ca0b359',
            'label' => 'Use Lightbox?',
            'name' => 'filtered_gallery_use_lightbox',
            'type' => 'true_false',
            'instructions' => 'Open images in a lightbox, when clicked.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
          array(
            'key' => 'field_5e54792b89ed7',
            'label' => 'Hide Filters?',
            'name' => 'filtered_gallery_hide_filters',
            'type' => 'true_false',
            'instructions' => 'Hide the filters, even when categories are added to gallery/images.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
          array(
            'key' => 'field_5fa0ee32855df',
            'label' => 'Hide Background Graphic?',
            'name' => 'filtered_gallery_hide_background_graphic',
            'type' => 'true_false',
            'instructions' => 'Hide the background graphic.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
          array(
            'key' => self::$FILTERED_GALLERY_CAT_KEY,
            'label' => 'Filtered Gallery Categories',
            'name' => self::$FILTERED_GALLERY_CAT_NAME,
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
              array(
                array(
                  'field' => 'field_5e54792b89ed7',
                  'operator' => '!=',
                  'value' => '1',
                ),
              ),
            ),
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
              array(
                'key' => 'field_5e4d727c4009f',
                'label' => 'Category',
                'name' => self::$FILTERED_GALLERY_CAT_SUB_FIELD_NAME,
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
              ),
            ),
          ),
          array(
            'key' => 'field_5e4d72343e40c',
            'label' => 'Filtered Gallery Images',
            'name' => 'filtered_gallery_images',
            'type' => 'gallery',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'min' => '',
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
              'value' => 'tq_filtered_gallery',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
      ));
      
      endif;

    // ACF DEFS - END

  }
}


?>
