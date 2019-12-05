;(function($) {
  $(document).ready(function() {
    // holds our row shortcode name
    var shortcode_string = 'torque_image_grid'

    wp.media = wp.media || {}
    wp.mce = wp.mce || {}

    // our torque_image_grid template
    wp.mce.torque_image_grid = {
      // holds data from our shortcode
      shortcode_data: {},

      // set our template
      // @see editor-torque-image-grid-template.html
      template: wp.media.template('editor-torque-image-grid-template'),

      // gets called everytime the shortcode is
      // loaded in the Visual tab of the WYSISWYG
      getContent: function() {
        // build options
        var options = { ...this.shortcode.attrs.named }
        // insert template into editor
        return this.template(options)
      },

      // get called when clicking on the edit
      // button on the shortcode's UI in the
      // Visual tab of the WYSIWYG editor
      edit: function(data) {
        // build options
        var shortcode_data = wp.shortcode.next(shortcode_string, data)
        var values = shortcode_data.shortcode.attrs.named
        wp.mce.torque_image_grid.popupwindow(tinyMCE.activeEditor, values)
      },

      popupwindow: function(editor, values, onsubmit_callback) {
        values = values || []
        if (typeof onsubmit_callback !== 'function') {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {}

            /*
            if (e.data.id) {
              _attr.id = e.data.id
            }
            if (e.data.title) {
              _attr.title = e.data.title
            }
            */

            var args = {
              tag: shortcode_string,
              type: 'closed',
              content: '',
              attrs: _attr,
            }
            editor.insertContent(wp.shortcode.string(args))
          }
        }
        var formBody = [
          /*
          {
            type: 'textbox',
            name: 'map_id',
            label: 'Map ID',
            value: values.map_id,
          },
          {
            type: 'textbox',
            name: 'title',
            label: 'Title',
            value: values.title,
          },
          */
        ]

        editor.windowManager.open({
          title: 'Torque Image Grid',
          body: formBody,
          onsubmit: onsubmit_callback,
        })
      },
    } // torque_image_grid

    // register the tinymce view template
    wp.mce.views.register(shortcode_string, wp.mce.torque_image_grid)
  })

  tinymce.PluginManager.add('torque_image_grid', function(editor) {
    editor.addButton('torque_image_grid_button', {
      text: 'Torque Image Grid',
      icon: false,
      onclick: function() {
        wp.mce.torque_image_grid.popupwindow(editor)
      },
    })
  })
})(jQuery)
