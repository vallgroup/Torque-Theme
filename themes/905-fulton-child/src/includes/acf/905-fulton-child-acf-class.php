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

      /*
        CONTENT SECTIONS
       */
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
              array(
      					'key' => 'field_5b6c6adb7b88d',
      					'label' => 'Align',
      					'name' => 'align',
      					'type' => 'radio',
      					'choices' => array(
      						'left' => 'Left',
      						'right' => 'Right',
      					),
      					'default_value' => 'right',
      				),
              array(
      					'key' => 'field_5b6c7dd4409b3',
      					'label' => 'CTA Text',
      					'name' => 'cta_text',
      					'type' => 'text',
      				),
      				array(
      					'key' => 'field_5b6c7df2409b4',
      					'label' => 'CTA Link',
      					'name' => 'cta_link',
      					'type' => 'url',
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


      /*
        PAGE HERO
       */
      acf_add_local_field_group(array(
      	'key' => 'group_5b6c7e56bb257',
      	'title' => 'Page Hero',
      	'fields' => array(
      		array(
      			'key' => 'field_5b6c7e5e81046',
      			'label' => 'Title',
      			'name' => 'title',
      			'type' => 'text',
      			'required' => 1,
      		),
      		array(
      			'key' => 'field_5b6c7e6c81047',
      			'label' => 'Caption',
      			'name' => 'caption',
      			'type' => 'text',
      		),
      		array(
      			'key' => 'field_5b6c7e7c81048',
      			'label' => 'Content Title',
      			'name' => 'content_title',
      			'type' => 'text',
      		),
      		array(
      			'key' => 'field_5b6c7e9981049',
      			'label' => 'Content',
      			'name' => 'content',
      			'type' => 'textarea',
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
      	'style' => 'default',
      	'label_placement' => 'top',
      	'active' => 1,
      	'description' => '',
      ));

    endif;
  }
}

?>
