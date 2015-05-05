/**
 * GCVector-specific scripts
 */
jQuery( function ( $ ) {
	$( 'div.gcvectorMenu' ).each( function () {
		var $el = $( this );
		$el.find( 'h5:first a:first' )
			// For accessibility, show the menu when the hidden link in the menu is clicked (bug 24298)
			.click( function ( e ) {
				$el.find( '.menu:first' ).toggleClass( 'menuForceShow' );
				e.preventDefault();
			} )
			// When the hidden link has focus, also set a class that will change the arrow icon
			.focus( function () {
				$el.addClass( 'gcvectorMenuFocus' );
			} )
			.blur( function () {
				$el.removeClass( 'gcvectorMenuFocus' );
			} );
	} );
} );
