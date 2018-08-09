<?php

class Fulton_ACF {

  public function __construct() {
    add_action('admin_init', array( $this, 'acf_admin_init'), 99);
    add_action('acf/init', array( $this, 'acf_init' ) );

    // hide acf in admin - client doesnt need to see this
    add_filter('acf/settings/show_admin', '__return_false');
  }


  public function acf_admin_init() {
     remove_menu_page('acf-options');
  }

  public function acf_init() {
    $this->add_content_sections_field_group();
  }

  private function add_content_sections_field_group() {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
      	'key' => 'group_5b6c5758c023d',
      	'title' => 'Content Sections',
      	'fields' => array(
      		array(
      			'key' => 'field_5b6c576076df1',
      			'label' => 'Content Section',
      			'name' => 'content_section',
      			'type' => 'repeater',
      			'collapsed' => 'field_5b6c57a376df2',
      			'button_label' => 'Add Content Section',
      			'sub_fields' => array(
      				array(
      					'key' => 'field_5b6c57a376df2',
      					'label' => 'Image',
      					'name' => 'image',
      					'type' => 'image',
      					'required' => 1,
      					'return_format' => 'url',
      					'preview_size' => 'medium',
      					'library' => 'all',
      				),
      				array(
      					'key' => 'field_5b6c57cb76df3',
      					'label' => 'Title',
      					'name' => 'title',
      					'type' => 'text',
      				),
      				array(
      					'key' => 'field_5b6c57db76df4',
      					'label' => 'Content',
      					'name' => 'content',
      					'type' => 'textarea',
      					'rows' => 4,
      				),
      			),
      		),
      	),
      	'location' => array(
      		array(
      			array(
      				'param' => 'post_type',
      				'operator' => '==',
      				'value' => 'page',
      			),
      		),
      	),
      	'menu_order' => 0,
      	'position' => 'normal',
      	'style' => 'default',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      ));

    endif;
  }
}

?>
