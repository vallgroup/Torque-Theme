(($) => {
	// bind toggle nav
	$(document).ready(() => {
		const navToggle = $('.torque-burger-menu')
		const nav = $('.torque-navigation-toggle')

		navToggle.on('click', e => {
			e.preventDefault()
			nav.toggleClass('active')
		})
	})
})(jQuery)
