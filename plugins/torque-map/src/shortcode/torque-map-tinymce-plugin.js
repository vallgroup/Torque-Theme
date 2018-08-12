(function($){
	$(document).ready(function(){
		// holds our row shortcode name
		var shortcode_string   = 'torque_map';

		wp.media = wp.media || {};
		wp.mce   = wp.mce   || {};

		// our torque_map template
		wp.mce.torque_map = {

			// holds data from our shortcode
			shortcode_data: {},

			// set our template
			// @see view/editor-bcorp-page-template.html
			template: wp.media.template( 'editor-torque-map-template' ),

			// gets called everytime the shortcode is
			// loaded in the Visual tab of the WYSISWYG
			getContent: function() {
				// build options
				var options     = {...this.shortcode.attrs.named};
				// insert template into editor
				return this.template(options);
			},

			// get called when clicking on the edit
			// button on the shortcode's UI in the
			// Visual tab of the WYSIWYG editor
			edit: function( data ) {
				// build options
				var shortcode_data = wp.shortcode.next(shortcode_string, data);
				var values         = shortcode_data.shortcode.attrs.named;

				// open the dialog
				// new BcorpPageBuilderRow(
				// 	tinyMCE.get('content'),
				// 	{row, columns}
				// );
			}
		}; // torque_map

		// register the tinymce view template
		wp.mce.views.register(
			shortcode_string,
			wp.mce.torque_map
		);
	});
}(jQuery));