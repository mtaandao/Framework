jQuery( function ( $ ) {
	'use strict';

	/**
	 * Update color picker element
	 * Used for static & dynamic added elements (when clone)
	 */
	function update() {
		var $this = $( this ),
			$container = $this.closest( '.mn-picker-container' ),
			data = $.extend(
				{
					change: function () {
						$( this ).trigger( 'color:change' );
					},
					clear: function () {
						$( this ).trigger( 'color:clear' );
					}
				},
				$this.data( 'options' )
			);

		// Clone doesn't have input for color picker, we have to add the input and remove the color picker container
		if ( $container.length > 0 ) {
			$this.insertBefore( $container );
			$container.remove();
		}

		// Show color picker
		$this.mnColorPicker( data );
	}

	$( '.rwmb-color' ).each( update );
	$( '#mnbody' ).on( 'clone', '.rwmb-color', update );
} );
