<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Interra_Marketing_Automation_CPT {

	/**
	 * Holds the marketer cpt object
	 *
	 * @var Object
	 */
	protected $marketer = null;

	/**
	 * Holds the labels needed to build the marketer custom post type.
	 *
	 * @var array
	 */
	public static $marketer_labels = array(
			'singular'       => 'Doc',
			'plural'         => 'Marketing Docs',
			'slug'           => 'property-marketer',
			'post_type_name' => 'property_marketer',
	);

	/**
	 * Holds options for the marketer custom post type
	 *
	 * @var array
	 */
	protected $marketer_options = array(
		'supports' => array(
			'title',
			// 'editor',
			'thumbnail',
		),
		'menu_icon' => 'dashicons-chart-area',
	);

	public static $disclaimer_labels = array(
			'singular'       => 'Disclaimer',
			'plural'         => 'Disclaimers',
			'slug'           => 'disclaimer',
			'post_type_name' => 'interra_disclaimer',
	);

	protected $disclaimer_options = array(
		'supports' => array(
			'title',
			'editor',
		),
		'menu_icon' => 'dashicons-text-page',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$marketer_labels, $this->marketer_options );

			new PremiseCPT( self::$disclaimer_labels, $this->disclaimer_options );
		}

		pwp_add_metabox(
			$title = 'Mailchimp',
			$post_type = 'property_marketer',
			$fields = array(
				'name_prefix' => 'ima_mailchimp_tmpl',
				array(
					'type' => 'select',
					'name' => '[header]',
					'label' => 'Header',
					'context' => 'post',
					'options' => array(
						'Style 1' => 'style-1',
						'Style 2' => 'style-2',
					),
					// add HTML for template preview
					'wrapper_class' => 'span5',
					'before_wrapper' => '<div class="span6 pwp-float-right">
						<img src="'.Interra_Marketing_Automation_URL.'images/header-style-1.png" class="pwp-responsive header-img" />
					</div>',
					'after_wrapper' => '<div class="pwp-clear-float"></div>',
				),
				array(
					'type' => 'select',
					'name' => '[body]',
					'label' => 'Body',
					'context' => 'post',
					'options' => array(
						'Style 1' => 'style-1',
						'Style 2' => 'style-2',
					),
					// add HTML for template preview
					'wrapper_class' => 'span5',
					'before_wrapper' => '<div class="span6 pwp-float-right">
						<img src="'.Interra_Marketing_Automation_URL.'images/body-style-1.png" class="pwp-responsive body-img" />
					</div>',
					'after_wrapper' => '<div class="pwp-clear-float"></div>',
				),
				array(
					'type' => 'select',
					'name' => '[footer]',
					'label' => 'Footer',
					'context' => 'post',
					'options' => array(
						'Style 1' => 'style-1',
						'Style 2' => 'style-2',
					),
					// add HTML for template preview
					'wrapper_class' => 'span5',
					'before_wrapper' => '<div class="span6 pwp-float-right">
						<img src="'.Interra_Marketing_Automation_URL.'images/footer-style-1.png" class="pwp-responsive footer-img" />
					</div>',
					'after_wrapper' => '<div class="pwp-clear-float"></div>',
				),
				array(
					'type' => 'button',
					'id' => 'ima-mailchimp-generate-html',
					'value' => 'Generate HTML',
					'class' => '',
					// add HTML for template preview
					'wrapper_class' => 'pwp-align-center',
					'before_wrapper' => '<div style="padding-top: 5%;"></div>',
					'after_wrapper' => '<div id="ima-mailchimp-html-preview">
						<div class="pwp-clear-float"><button class="button pwp-float-right" id="ima-copy-mailchimp-code">Copy HTML</button></div>
						<pre class="code-to-copy-paste"></pre>
					</div>',
				),
			),
			$option_names = 'ima_mailchimp_tmpl'
		);

		pwp_add_metabox(
			$title = '360 Photos URLs',
			$post_type = 'property_marketer',
			$fields = array(
				array(
					'type' => 'hidden',
					'after_field' => '<p>When you add 360 photos from the <b>360 Pictures</b> section, the links for those 360 renders will be listed here. When you remove a 360 photo you will notice the url for that render disappear from this list.
						<br>Use this list to keep track of the 360 renders that are successfully attached to this Doc.',
					'name' => 'boxapp_panos',
					'context' => 'post'
				),
			),
			$option_names = 'boxapp_panos'
		);
	}

}

?>
