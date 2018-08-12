<nav>
  <div class="relative-container">

  	<div class="site-logo">
  		<?php get_template_part( 'parts/shared/logo', 'dark'); ?>
  	</div>
  	<a href="#toggle-nav" id="mobile-nav-toggle" class="mobile-nav-toggle">
  		<span></span>
  		<span></span>
  		<span></span>
  	</a>
  	<div class="navigation" id="navigation">
  		<?php get_template_part('parts/shared/header-parts/menu-items/menu-items', 'inline'); ?>
  	</div>

  </div>
</nav>

<script type="text/javascript">
	(($) => {
		// bind toggle nav
		$(document).ready(() => {
			const navToggle = $('#mobile-nav-toggle')
			const nav = $('#navigation')

			navToggle.on('click', e => {
				e.preventDefault()

				if(nav.hasClass('active')) {
					nav.removeClass('active')
				} else {
					nav.addClass('active')
				}
			})
		})

		// lazy load background
		$(window).load(() => {
			const body = $('body')

			body.css('background-image', 'url(/wp-content/uploads/2018/08/shutterstock-219154477-1.jpg)')
		})
	})(jQuery)
</script>