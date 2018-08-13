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
				console.log( this.shortcode )
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
				wp.mce.torque_map.popupwindow(tinyMCE.activeEditor, values)
			},

			popupwindow: function(editor, values, onsubmit_callback){
				values = values || [];
				if(typeof onsubmit_callback !== 'function'){
					onsubmit_callback = function( e ) {
						// Insert content when the window form is submitted (this also replaces during edit, handy!)
						var args = {
								tag     : shortcode_string,
								type    : 'closed',
								content : '',
								attrs : {
									map_id: e.data.map_id,
									center: e.data.center,
								}
							};
						editor.insertContent( wp.shortcode.string( args ) );
					};
				}
				editor.windowManager.open( {
					title: 'Torque Map',
					body: [
						{
							type: 'textbox',
							name: 'map_id',
							label: 'Map ID',
							// values: [{
							// 	text: 'Hello',
							// 	value: 'There',
							// }],
							value: values.map_id
						},
						{
							type: 'textbox',
							name: 'center',
							label: 'Center',
							// values: [{
							// 	text: 'Hello',
							// 	value: 'There',
							// }],
							value: values.center
						},
					],
					onsubmit: onsubmit_callback
				} );
			}
		}; // torque_map

		// register the tinymce view template
		wp.mce.views.register(
			shortcode_string,
			wp.mce.torque_map
		);
	});


	tinymce.PluginManager.add( 'torque_map', function( editor ) {
		editor.addButton( 'torque_map_button', {
			text: 'Torque Map',
			icon: false,
			onclick: function() {
				wp.mce.torque_map.popupwindow(editor);
			}
		});
	});
}(jQuery));


/* global tinymce */
// ( function() {
// })();