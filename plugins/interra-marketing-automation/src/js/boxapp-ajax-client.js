(function($) {

	acf = acf || {}

	var __panoURLsContainerHTML = '<div id="360-photo-urls"></div>'
	var __modal = '<div id="_pano_modal" style="display: none; position: fixed; bottom: 2em; right: 2em; background: rgba(0, 0, 0, 0.8); border-radius: 1em;">'
		+ '<div style="padding: 1em; max-width: 20em; color: #fff;">'
		+ '<p>We are creating your 360 photo, this may take a minute. You may continue to work on this Doc, but must wait until we are done to save.</p>'
		+ '</div>'
		+ '</div>';

	var panoIdsField = $('#boxapp_panos');
	var panoURLsMetaBox = panoIdsField.parents('.inside');
	var panoURLsContainer = panoURLsMetaBox.find('#360-photo-urls')

	var postUpdateBtn = $('#publish');
	var postUpdatePage = $('#wpcontent');

	if ( 0 === panoURLsContainer.length ) {
		panoURLsMetaBox.append(__panoURLsContainerHTML)
		panoURLsContainer = $('#360-photo-urls')
	}

	var disableUpdateButton = () => {
		postUpdateBtn.prop('disabled', true)
	}

	var enableUpdateButton = () => {
		postUpdateBtn.prop('disabled', false)
	}

	var activityIndicator = (onOff) => {
		if ('On' === onOff) {
			disableUpdateButton();
			$('#_pano_modal').fadeIn('fast')
		} else
		if ('Off' === onOff) {
			$('#_pano_modal').fadeOut('fast')
			enableUpdateButton()
		}
	}

	var displayBoxAppUrls = () => {
		panoURLsContainer.html('')
		var panoIds = panoIdsField.val()
		if ( 0 < panoIds.length) {
			var panoIdsArr = panoIds.split(',')
			for (var i = 0; i < panoIdsArr.length; i++) {
				if ('00:00' !== panoIdsArr[i]) {
					var url = 'https://vr.boxapp.io/?org=interra&worldID='+panoIdsArr[i].split(':')[1]
					var urlHTML = '<p><a href="'+url+'" target="_blank" rel="noopener">'+url+'</a></p>'
					panoURLsContainer.append(urlHTML)
				}
			}
		}
	}

	var removePanoId = (imageId) => {
		// console.log(imageId)
		var imgPanosArr = panoIdsField.val().split(',')
		var newImgPanosArr = []
		for (var i = 0; i < imgPanosArr.length; i++) {
			var keyPano = imgPanosArr[i].split(':')
			if (+imageId !== +keyPano[0]) {
				newImgPanosArr.push(keyPano.join(':'))
			}
		}
		var newIds = newImgPanosArr.join(',')
		panoIdsField.val( (0 < newIds.length) ? newIds : '00:00' )
		displayBoxAppUrls()
	}

	var isACFPanoField = ($el) => {
		return $el.hasClass('acf-field-5d681831ad7b4')
	}

	var checkForPano = ( $el ) => {
		isACFPanoField($el) && $el.change( createBoxAppPano )
	}

	var removePano = ( $el ) => {
		// console.log($el)
		if (isACFPanoField($el)) {
			var imageId = $el.find('.acf-image-uploader > input').val();
			removePanoId(imageId)
		}
	}

	var init = () => {

		postUpdatePage.append(__modal)

		displayBoxAppUrls()
		// bind action when a new 360 photo is added
		acf.add_action('append_field/type=image', checkForPano)
		// bind action when a 360 photo is removed
		acf.add_action('remove_field/type=image', removePano)

		// panoIdsField.change( displayBoxAppUrls )
	}

	async function createBoxAppPano() {
		activityIndicator('On')

		var imageId = $(this).find('.acf-image-uploader > input').val();
		var image = $(this).find('img[data-name="image"]');
		var url = image.attr('src');
		var name = url.split('/').reverse()[0];
		var type = 'image/'+name.split('.').reverse()[0];

		try {
			var imageBlob = await __getImageBlob(url, name, type)
			// console.log(imageBlob)
			var savePano = await __savePano( name, imageBlob)
			// console.log(savePano)
			if (savePano.success
				&& savePano.worldId) {
				var __panos = panoIdsField.val()
				var __newPanos = (0 < __panos.length && '00:00' !== __panos)
					? __panos + ','+ imageId + ':' + savePano.worldId
					: imageId + ':' + savePano.worldId
				// save new pano ids
				panoIdsField.val(__newPanos)
				// panoIdsField.trigger('change')
				displayBoxAppUrls()
			}
		} catch(err) {
			console.error(err)
		}

		activityIndicator('Off')
	}

	function __getImageBlob(url, name, type) {
		return fetch(url)
		.then( r => {
			return r.blob()
			.then( b => {
				return new File([b], name, {type: type})
			})
		})
	}

	function __savePano( name, image ) {
		var __url = 'https://api.boxapp.io/interra/wp-json/boxapp/v1/worlds/0?status=publish&name='+name
		var formData = new FormData();
		formData.append('pano_media', image)
		var fetchOptions = {
			method: 'POST',
			body: formData,
			headers: {
				Authorization: "Basic bWFyaW86cHcudHJ1ZT8xOjA7"
			}
		}
		return fetch(__url, fetchOptions)
		.then(r => {
			return r.json()
			.then(j => {
				return j
			})
		})
	}

	$(document).ready( init )

}(jQuery))