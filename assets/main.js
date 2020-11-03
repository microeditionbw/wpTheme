// Webpack Imports
import 'bootstrap';


( function ( $ ) {
	'use strict';
	$('.carousel').carousel({
		interval: 4000
	  });
	  
	// Focus Search if Searchform is empty
	$( '.search-form' ).on( 'submit', function ( e ) {
		var search = $( '#s' );
		if ( search.val().length < 1 ) {
			e.preventDefault();
			search.focus();
		}
	} );

}( jQuery ) );
