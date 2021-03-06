/**
 * Plugin JS
 *
 * @package Premise Tabs
 */
(function ($) {

	// call the plugin automatically on our default class (.ptabs-wrapper)
	// TODO Update to call the new version of the plugin.
	$(document).ready(function(){
		if ( 0 < $('.pwptabs').length ) $('.pwptabs').premiseTabs();
	});

	if ( $.fn.premiseTabs ) {
		return false;
	}

	/**
	 * Add tab functionality to your markup
	 *
	 * @since 1.7.2
	 *
	 * @param  {Object} options an object with all the options. see defaults below
	 * @return {object}         the element in scope
	 */
	$.fn.premiseTabs = function( options ) {

		if ( this.length === 0 ) {
			return this;
		}

		// Parse the default options.
		var opts = $.extend( {}, $.fn.premiseTabs.defaults, options );

		// reference outr variables for efficiency
		var el    = this,
		$el       = $(el),
		tab       = $( opts.tabSelector ),
		toggle    = $( opts.toggleSelector ),
		content   = $( opts.contentSelector )
		activeTab = $( '.'+opts.activeClass ),
		activeContent = null,
		// make sure the layout is either accordion or tabs
		layout    = ( 'accordion' !== opts.layout ) ? 'tabs' : opts.layout;

		// if tabs == opts.layout, make sure openMultiple is false
		opts.openMultiple = ( 'tabs' !== layout ) ? opts.openMultiple : false;

		/*
			Private Methods
		 */

		// run our code
		var init = function() {
			// close all the tabs content first
			content.hide( 1 );

			// add classes to our $el
			var classes = ( 'accordion' == layout ) ? 'pwptabs pwptabs-layout-'+layout+' pwptabs-layout-'+opts.direction : 'pwptabs pwptabs-layout-'+layout;
			$el.addClass( classes );

			// make sure we have our wrapper. needed for our css to kick in
			if ( ! $el.parents( '.'+opts.wrapperClass ).length ) $el.wrap( '<div class="'+opts.wrapperClass+'"></div>' );

			// If no active tabs set the first one as active
			if ( 0 == activeTab.length || 1 < activeTab.length ) {
				tab.removeClass( opts.activeClass );
				activeTab = tab.first();
				activeTab.addClass( opts.activeClass );
			}

			openActive();

			bindTabs();

			$el.trigger( 'premiseTabsReady', [el, opts] );
		},

		// bind the anchor for each tab
		bindTabs = function() {
			( toggle.length ) ? toggle.click( toggleTabs ) : false;
		},

		// toggle tabs when in accordion layout
		toggleTabs = function( e ) {
			e.preventDefault();
			var $this = $( this ),
			href = $this.attr( 'href' );

			activeTab = $this.parents( opts.tabSelector );

			if ( activeTab.is( '.'+opts.activeClass ) ) {
				if ( 'accordion' == opts.layout ) {
					activeTab.removeClass( opts.activeClass );
					closeTabs();
				}
				else {
					return false
				}
			}
			else {
				if ( ! opts.openMultiple ) tab.removeClass( opts.activeClass );
				activeTab.addClass( opts.activeClass );
				openTabs();
				$this.attr( 'href', 'javascript:;' );
				if ( ! href.match( /^((javascript)|(#)$)/g ) ) loadAjajxContent( href );
			}

			return false;
		},

		// open the tabs
		openTabs = function() {
			if ( ! opts.openMultiple ) closeTabs();

			if ( 'function' === typeof opts.onTabOpen ) {
				opts.onTabOpen.call( el );
			}
			else {
				openActive();
			}
		},

		// close the tabs
		closeTabs = function() {
			if ( 'function' === typeof opts.onTabClose ) {
				opts.onTabClose.call( el );
			}
			else {
				if ( 'tabs' == layout ) {
					content.fadeOut( 'fast' );
				}
				else {
					if ( ! opts.openMultiple ) {
						content.hide( 'fast' );
					}
					else {
						activeTab.find( opts.contentSelector ).hide( 'fast' );
					}
				}
			}
		},

		// open the active tab
		openActive = function() {
			var tabIndex = activeTab.find( opts.toggleSelector ).attr( 'data-tab-index' );
			activeContent = getActiveContent( ( tabIndex ) ? tabIndex : '' );

			if ( 'tabs' == layout ) {
				activeContent.fadeIn( 'fast' );
			}
			else {
				activeContent.show( 'fast' );
			}
		};


		function getActiveContent( index ) {
			index = index || '';
			return ( '' !== index ) ? $(opts.contentSelector+'-'+index) : activeTab.find( opts.contentSelector );
		};


		function loadAjajxContent( url ) {
			url = url || '';

			if ( '' !== url ) {
				activeContent.addClass( 'pwptabs-loading-content' );
				activeContent.html( '<i class="fa fa-spin fa-spinner"></i>' );
				$.ajax({
					url: url,
					success: function( resp ) {
						activeContent.html( resp );
					},
					error: function( err ) {
						activeContent.html( err );
					}
				});
				activeContent.addClass( 'pwptabs-ajax-content-loaded' );
			}
		}

		init();
		return this;
	}

	/**
	 * Defaults for our premiseTabs pugin
	 *
	 * @type {Object}
	 */
	$.fn.premiseTabs.defaults = {
		// selectors
		tabSelector:     '.pwptabs-tab',
		toggleSelector:  '.pwptabs-toggle',
		contentSelector: '.pwptabs-content',

		// Special classes
		wrapperClass: 'pwptabs-wrapper',
		activeClass:  'pwptabs-active',

		// Tabs layout options (tabs|accordion)
		layout:    'tabs',

		// accordion layout ONLY
		direction:    'vertical',
		openMultiple: false,

		// callbacks
		onTabOpen:  null,
		onTabClose: null,
	};

})(jQuery);