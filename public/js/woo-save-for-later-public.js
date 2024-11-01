(function( $ ) {

	$( window ).load( function() {

		$( 'body' ).on( 'click', '.set_wsfl_save_for_later', function( e ) {
			e.preventDefault();

			var productID = $( this ).attr( 'id' );

			$.ajax( {
				type: 'POST',
				url: wsflurl.ajaxurl,
				async: false,
				data: {
					action: 'wsfl_add_save_for_later',
					productID: productID,
					nonce: $( this ).closest( 'table.shop_table' ).find( '#wsfl_dot_nonce' ).val()
				},
				success: function( response ) {
					if ( response == '1' ) {
						alert( 'Product already exsits in save for later.' );
					} else {
						location.reload();
					}
				}
			} );

		} );

		$( 'body' ).on( 'click', '.remove_product_to_wsfl', function() {

			var productID = $( this ).attr( 'id' );

			$.ajax( {
				type: 'POST',
				url: wsflurl.ajaxurl,
				async: false,
				data: {
					action: 'wsfl_remove_save_for_later',
					productID: productID,
					nonce: $( this ).data( 'nonce' )
				},
				success: function( response ) {
					location.reload();
				}
			} );

		} );

		$( 'body' ).on( 'click', '.wsfl_add_product_to_cart', function() {

			var productID = $( this ).attr( 'id' );

			$.ajax( {
				type: 'POST',
				url: wsflurl.ajaxurl,
				async: false,
				data: {
					action: 'wsfl_add_product_to_cart',
					productID: productID,
					nonce: $( this ).data( 'nonce' )
				},
				success: function( response ) {
					location.reload();
				}
			} );

		} );

		$( 'form' ).each( function() {
			var cmdcode = $( this ).find( 'input[name="cmd"]' ).val();
			var bncode = $( this ).find( 'input[name="bn"]' ).val();

			if ( cmdcode && bncode ) {
				$( 'input[name="bn"]' ).val( 'Multidots_SP' );
			} else if ( (cmdcode) && (! bncode) ) {
				$( this ).find( 'input[name="cmd"]' ).after( '<input type=\'hidden\' name=\'bn\' value=\'Multidots_SP\' />' );
			}
		} );

	} );

})( jQuery );