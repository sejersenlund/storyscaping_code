(function( $ ) {
	
	'use strict';
	
	var hasCentralMenu = $( 'body' ).hasClass( 'btMenuCenterEnabled' );
	var verticalMenuEnabled = $( 'body' ).hasClass( 'btMenuVerticalLeftEnabled' ) || $( 'body' ).hasClass( 'btMenuVerticalRightEnabled' );
	
	var belowMenu = $( 'body' ).hasClass( 'btBelowMenu' );
	var btStickyEnabled = $( 'body' ).hasClass( 'btStickyEnabled' );
	
	if ( typeof window.btStickyOffset == 'undefined' ) window.btStickyOffset = 250;
	if ( typeof window.responsiveResolution == 'undefined' ) window.responsiveResolution = '1200';

	function divide_menu() {

		if ( $( '.btTextLogo' ).length ) {
			var logoWidth = $( '.mainHeader .logo' ).width();
		} else  {
			var logoWidth = $( '.mainHeader .logo' ).height() * $( '.mainHeader .logo .btMainLogo' ).data( 'hw' );
		}

		$( '.menuPort nav' ).addClass( 'leftNav' );
		$( '.menuPort' ).append( '<nav class="rightNav"><ul></ul></nav>' );
		var halfItems = Math.ceil( $( '.menuPort nav.leftNav ul>li:not(li li)' ).length * .5 );
		$( '.menuPort nav.rightNav > ul' ).append( $( '.menuPort nav.leftNav > ul > li' ).slice ( halfItems ) );
		$( '.menuPort nav.leftNav > ul > li' ).slice( halfItems ).remove();
		
		$( '.mainHeader .logo' ).css( 'transform', 'translateX(' + Math.round(-logoWidth * .5) + 'px)' );
		$( '.mainHeader .logo' ).css( 'width', logoWidth + 'px' );
		$( '.menuPort nav.leftNav' ).css( 'margin-right', Math.round(logoWidth * .5) + 'px' );
		$( '.menuPort nav.rightNav' ).css( 'margin-left', Math.round(logoWidth * .5) + 'px' );
	}
	
	/* Activate sticky function and call */
	
	function boldthemes_activate_sticky() {
		var fromTop = $( window ).scrollTop();
		if ( fromTop > window.btStickyOffset ) {
			if ( $('body').hasClass('btStickyHeaderActive') ) return false;
			$( 'body' ).addClass( 'btStickyHeaderActive' );
			setTimeout( function() { $( 'body' ).addClass( 'btStickyHeaderOpen' ) }, 500 );
		} else {
			if ( !$('body').hasClass('btStickyHeaderActive') ) return false;
			$( 'body' ).addClass( 'btStickyHeaderClosed' );
			setTimeout( function() { $( 'body' ).removeClass( 'btStickyHeaderActive btStickyHeaderOpen btStickyHeaderClosed' ) }, 250 );
		}
	}
	
	/* Vertical menu setup */

	function init_menu() {
		
		if ( verticalMenuEnabled ) {
			if ( $( 'body' ).hasClass( 'btMenuVerticalLeftEnabled' )) $( 'body' ).addClass( 'btMenuVerticalLeft btMenuVertical' );
			if ( $( 'body' ).hasClass( 'btMenuVerticalRightEnabled' )) $( 'body' ).addClass( 'btMenuVerticalRight btMenuVertical' );
		} else {
			if ( $( 'body' ).hasClass( 'btMenuRightEnabled' )) $( 'body' ).addClass( 'btMenuRight btMenuHorizontal' );
			if ( $( 'body' ).hasClass( 'btMenuLeftEnabled' )) $( 'body' ).addClass( 'btMenuLeft btMenuHorizontal' );
			if ( $( 'body' ).hasClass( 'btMenuCenterBelowEnabled' )) $( 'body' ).addClass( 'btMenuCenterBelow btMenuHorizontal' );
			if ( $( 'body' ).hasClass( 'btMenuCenterEnabled' )) $( 'body' ).addClass( 'btMenuCenter btMenuHorizontal' );
			/* Switch to vertical */
			if( window.innerWidth < window.responsiveResolution ) {
				$( 'body' ).addClass( 'btMenuVerticalLeft btMenuVertical' ).removeClass( 'btMenuHorizontal' );
			} else {
				$( 'body' ).removeClass( 'btMenuVertical btMenuVerticalLeft btMenuVerticalOn' ).addClass( 'btMenuHorizontal' );				
			}
			$(window).on("resize", function(event){
				if( window.innerWidth < window.responsiveResolution ) {
					$( 'body' ).addClass( 'btMenuVerticalLeft btMenuVertical' ).removeClass( 'btMenuHorizontal' );
				} else {
					$( 'body' ).removeClass( 'btMenuVertical btMenuVerticalLeft btMenuVerticalOn' ).addClass( 'btMenuHorizontal' );				
				}
				boldthemes_calculate_content_padding();
			});			
		}
		// Move content below menu, must be donne after menu switch
		if ( ! belowMenu ) {
			boldthemes_calculate_content_padding();
		}
		
		setTimeout( function() { $( 'body' ).addClass( 'btMenuInitFinished' ); }, 100 );
		
		if ( btStickyEnabled ) {
			setTimeout( function() { 
				$( window ).scroll(function(){
					boldthemes_activate_sticky();
				});
			}, 1000 );
		}
		
		/* Menu split */
		
		if ( hasCentralMenu ) divide_menu();

		/* Menu sub togglers */
		
		$( '.menuPort ul ul' ).parent().prepend( '<div class="subToggler"></div>');

		$( '.menuPort ul li' ).on( 'mouseenter mouseleave', function (e) {
			if ( $( 'body' ).hasClass( 'btMenuVertical' ) || $( 'html' ).hasClass( 'touch' ) ) {
				return false;
			}
			e.preventDefault();
			$( this ).siblings().removeClass( 'on' );
			$( this ).toggleClass( 'on' );
		});

		$( 'div.subToggler' ).on( 'click', function(e) {
			var parent = $( this ).parent();
			parent.siblings().removeClass( 'on' );
			parent.toggleClass( 'on' );
			if ( $( 'body' ).hasClass( 'btMenuVertical' ) ) {
				parent.find( 'ul' ).first().slideToggle( 200 );
			}
			return false;
		});
		
	}
	
	/* Calculate content padding for not below menu */
	
	function boldthemes_calculate_content_padding() {
		if ( ! belowMenu ) {
			if( $( window ).width() < window.responsiveResolution || verticalMenuEnabled ) {
				$( '.btContentWrap' ).css( 'padding-top', $( '.btVerticalHeaderTop' ).height() +'px');
			} else {
				$( '.btContentWrap' ).css( 'padding-top', $( '.mainHeader' ).height() +'px');	
			}	
		}
	}

	/* Wide menu setup btMenuWideDropdown */

	$( 'li.btMenuWideDropdown' ).addClass(function(){
		return 'btMenuWideDropdownCols-' + $( this ).children( 'ul' ).children( 'li' ).length;
	});
	
	$( 'li.btMenuWideDropdown' ).each(function() {
		var maxChildItems = 0;
		$( this ).find( '> ul > li > ul' ).each(function( index ) {
			if ( $( this ).children().length > maxChildItems ) {
				maxChildItems = $( this ).children().length;
			}
		});
		$( this ).find( '> ul > li > ul' ).each(function( index ) {
			var bt_menu_base_length = $( this ).children().length;
			if ( bt_menu_base_length < maxChildItems ) {
				for ( var i = 0; i < maxChildItems - bt_menu_base_length; i++ ) {
					$( this ).append( '<li><a class="btEmptyElement">&nbsp;</a></li>' );
				} 
			}
		});
	});

	/* Show hide menu */

	$( '.btHorizontalMenuTrigger' ).on( 'click', function () {
		$( 'body' ).toggleClass( 'btShowMenu' );
		return false;
	});

	/* responsive menu toggler */

	$( '.btVerticalMenuTrigger' ).on( 'click', function () {
		$( 'body' ).toggleClass( 'btMenuVerticalOn' );
		return false;
	});

	/* Top tools search */
	
	$('.mainHeader .btSearchInner').prependTo('body').addClass( 'btFromTopBox' );
	$('.mainHeader .widget_search').addClass( 'btIconWidget' );

	$( '.mainHeader .btSearch, .btFromTopBox .btSearchInnerClose' ).on( 'click', function () {
		$( 'body' ).toggleClass( 'btTopToolsSearchOpen' );
		return false;
	});

	/* Vertical menu setup */
	
	init_menu();
	
})( jQuery );