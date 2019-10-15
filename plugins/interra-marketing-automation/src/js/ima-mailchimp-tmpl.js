(function($) {

	var __mailchimpMB = $('#mailchimp.postbox')
	var __fields = __mailchimpMB.find('[name^="ima_mailchimp_tmpl"]')
	var __generateCodeBtn = $('#ima-mailchimp-generate-html')
	var __htmlCodeContainer = $('#ima-mailchimp-html-preview').find('pre')
	var __copyHTMLBtn = $('#ima-copy-mailchimp-code')
	var __emptyTextareaForHTML = '<div id="__ima_html_email_container"><textarea id="__ima_html_email" value="" /></div>'
	var __ima_html_email = null
	var __postID = $('#post_ID').val()

	var updateTmplImg = ( name, value ) => {
		var _img = $('.'+name+'-img')
		var _src = _img.attr('src')
		var _srcArr = _src.split('/')
		_srcArr.pop() && _srcArr.push(name+'-'+value+'.png')
		_img.attr('src', _srcArr.join('/'))
	}

	var getHTMLCode = () => {
		var __api = '/wp-json/ima/v1/mailchimp/email-template?'
		var __params = ['postID='+__postID]

		$.each(__fields, (idx, _field) => {
			var tmpl = $(_field).attr('id').split('-')[1];
			var style = $(_field).val()
			__params.push(tmpl+'='+style)
		})

		return fetch( __api + __params.join('&') )
		.then( r => (r.json().then( j => (j))))
	}

	var generateHTMLCode = async (e) => {
		e.preventDefault();

		__htmlCodeContainer.html('Loading code...')

		try {
			var htmlCode = await getHTMLCode()

			__htmlCodeContainer
			.html(htmlCode.tmpl)

			setTimeout(() => {
				__htmlCodeContainer.select()
			}, 2000)

		} catch(err) {
			console.error(err)
			__htmlCodeContainer.html('Sorry, there was an error. Try again.')
		}

	}

	var copyToClipboard = (e) => {
		e.preventDefault();
		var __this = $(e.target)
		var htmlCode = __htmlCodeContainer.text()

		if ('' === htmlCode) {
			alert('There is no HTML code to copy. Click the Generate HTML button first.')
			return;
		}

		if (__ima_html_email) {
			__ima_html_email.val(htmlCode)
			__ima_html_email[0].select()
			document.execCommand("copy")
		}
		__this.text('HTML Copied!').prop('disabled', true)

		setTimeout(() => {
			__this.text('Copy HTML').prop('disabled', false)
		}, 3000)
	}

	$(document).ready( function() {
		$.each(__fields, updateTmplImages )

		__fields.change( updateTmplImages )

		__generateCodeBtn.click( generateHTMLCode )

		__copyHTMLBtn.click( copyToClipboard )

		__mailchimpMB.append( __emptyTextareaForHTML )
		__ima_html_email = $('#__ima_html_email')
	})

	function updateTmplImages() {
		var _this = $(this)
		var _which = _this.attr('id').split('-')[1];
		var _val = _this.val()

		updateTmplImg( _which, _val)
	}

}(jQuery))