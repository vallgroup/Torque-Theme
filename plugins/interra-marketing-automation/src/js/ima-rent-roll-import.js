
(function($) {

	acf = acf || {}

	var alertMessage = 'Are you sure that you want to upload a new Rent Roll import? Doing so, will refresh this page and any unsaved changes may be lost. If you have unsaved changes please exit out of the next window and save your changes before running this import.';

	var showAlert = e => {
		alert(alertMessage)
	}

	var refreshOnImport = e => {
		var newFile = e.target.value;
		if ('' !== newFile) {
			window.location.reload();
		}
	}

	var bindImportField = (field) => {
		field.$el.on('change', 'input', refreshOnImport)
		field.$el.on('click', 'a', showAlert)
	}

	var init = () => {
		acf.addAction('load_field/name=units_spreadsheet', bindImportField)
	}

	$(document).ready( init )

}(jQuery))