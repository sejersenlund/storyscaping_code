'use strict';

window.onunload = function(){};

window.addEventListener("pageshow", function(evt){
        if(evt.persisted){
        setTimeout(function(){
            window.location.reload();
        },10);
    }
}, false);

(function( $ ) {

	
	$( '.no-touch .btSidebar select, .no-touch select.orderby, .no-touch #btSettingsPanelContent select, .no-touch .wpcf7-form select:not([multiple])' ).fancySelect().on( 'change.fs', function() {
		$( this ).trigger( 'change.$' );
	});

     
	// LOAD
		
	$( window ).load(function() {
	
		// remove preloader
		$( 'body' ).addClass( 'btRemovePreloader' );
		
		// trigger custom load event
		setTimeout( function() { $( window ).trigger( 'btload' ); window.boldthemes_loaded = true; }, 500 );
		
		// gmaps with img overlay, iframes
		$( window ).trigger( 'resize' );
		
	});


	
	// Modernizer
	
	btModernizr.load([
		{
			test: window.matchMedia
		}
	]);
	
	// Browser detect
	
	var doc = document.documentElement;
	doc.setAttribute('data-useragent', navigator.userAgent);

	// IE startsWith/endsWith compatibility 
	
	if ( ! String.prototype.startsWith ) {
		String.prototype.startsWith = function(searchString, position) {
			position = position || 0;
			return this.lastIndexOf(searchString, position) === position;
		};
	}

	if ( ! String.prototype.endsWith ) {
		String.prototype.endsWith = function(searchString, position) {
			var subjectString = this.toString();
			if (position === undefined || position > subjectString.length) {
				position = subjectString.length;
			}
			position -= searchString.length;
			var lastIndex = subjectString.indexOf(searchString, position);
			return lastIndex !== -1 && lastIndex === position;
		};
	}
	
	// delay click to allow on page leave screen

	$( document ).on( 'click', 'a', function() {
		if ( ! $( this ).hasClass( 'lightbox' ) && ! $( this ).hasClass( 'add_to_cart_button' ) ) {
			var href = $( this ).attr( 'href' );
			if ( href !== undefined ) {
				if ( location.href == href || ( location.href.split( '#' )[0] != href.split( '#' )[0] && ! href.startsWith( '#' ) && ! href.startsWith( 'mailto' ) && ! href.startsWith( 'callto' ) ) ) {
					if ( $( this ).attr( 'target' ) != '_blank' && ! href.endsWith( '#respond' ) ) {
						if ( $( '#btPreloader' ).length ) {
							$( 'body' ).removeClass( 'btRemovePreloader' );
							setTimeout( function() { window.location = href }, 750 );
							return false;
						}
					}
				} else if ( href != "#" && ! href.startsWith( 'mailto' ) ) {
					if ( $( this ).parent().parent().attr('class') != 'tabsHeader' ) scrollPageToId( href );
					return false;
				}
			}
		}
	});

	/* Footer widgets count and column set */

	$( '#boldSiteFooterWidgetsRow' ).children().attr( 'data-width', 12 / $( '#boldSiteFooterWidgetsRow' ).children().length ).addClass('bt_bb_column');

})( jQuery );

function bt_refresh_cart() {
	jQuery( '.btCartWidgetIcon' ).unbind('click').on( 'click', function ( e ) { 
		jQuery(this).parent().parent().toggleClass( 'on' ); 
		jQuery('body').toggleClass( 'btCartDropdownOn' ); 
	});
	jQuery('.verticalMenuCartToggler').unbind('click').on( 'click', function(){
		jQuery(this).closest('.widget_shopping_cart_content').removeClass('on');
		jQuery('body').removeClass('.btCartDropdownOn');
	});
}

jQuery( document ).ready(function() {
	jQuery( '.cart-contents' ).each(function() {
		bt_refresh_cart();
	});
});