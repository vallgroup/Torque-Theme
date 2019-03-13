<?php

require_once( plugin_dir_path(__FILE__) . 'entrata-api-class.php' );

class Torque_Floor_Plans_Entrata {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	public function __construct() {}


  public static $PROPERTY_ID_FILTER_SLUG = 'torque_floor_plans_entrata_property_id';

  public $PROPERTY_ID = false;

  public function init() {
    $this->PROPERTY_ID = apply_filters(self::$PROPERTY_ID_FILTER_SLUG, $this->PROPERTY_ID);

		$this->configure_cpt();

		Entrata_API::get_inst()->init($this->PROPERTY_ID);
	}

	public function configure_cpt() {
		if ( class_exists( 'Torque_Floor_Plan_CPT' ) ) {

			add_action('do_meta_boxes', function() {
				remove_meta_box('postexcerpt', Torque_Floor_Plan_CPT::$floor_plan_labels['post_type_name'], 'normal');
			});

			add_filter( Torque_Floor_Plan_CPT::$METABOXES_FILTER_HOOK, function($metaboxes) {
				unset($metaboxes['downloads']);
				unset($metaboxes['floor_number']);

				$metaboxes['entrata_name'] = array(
					'Entrata',
					Torque_Floor_Plan_CPT::$floor_plan_labels['post_type_name'],
					array(
						array(
							'type'    => 'text',
							'context' => 'post',
							'name'    => 'entrata_name',
							'label'   => 'Name in Entrata',
							'placeholder'	=> 'eg OB'
						),
					),
					'entrata_name'
				);

				$metaboxes['entrata_key_plan'] = array(
					'Additional Images',
					Torque_Floor_Plan_CPT::$floor_plan_labels['post_type_name'],
					array(
						'name_prefix' => 'entrata_additional_images',
						array(
							'context'     => 'post',
							'type'        => 'wp_media',
							'name'        => '[key_plan]',
							'label'       => 'Key Plan Image',
							'preview'			=> true,
						),
					),
					'entrata_additional_images'
				);

				return $metaboxes;
			});

		}
	}

  public function get_shortcode_markup() {
    return '';
  }
}

?>
