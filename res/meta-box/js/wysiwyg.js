/* global tinymce, quicktags */

jQuery( function ( $ ) {
	'use strict';

	/**
	 * Update date picker element
	 * Used for static & dynamic added elements (when clone)
	 */
	function update() {
		var $this = $( this ),
			$wrapper = $this.closest( '.mn-editor-wrap' ),
			id = $this.attr( 'id' );

		// Ignore existing editor.
		if ( tinyMCEPreInit.mceInit[id] ) {
			return;
		}

		// Get id of the original editor to get its tinyMCE and quick tags settings
		var originalId = getOriginalId( $this );
		if ( ! originalId ) {
			return;
		}

		// Update the DOM
		$this.show();
		updateDom( $wrapper, id );

		// TinyMCE
		var settings = tinyMCEPreInit.mceInit[originalId];
		settings.selector = '#' + id;
		tinymce.init( settings );

		// Quick tags
		if ( typeof quicktags === 'function' && tinyMCEPreInit.qtInit.hasOwnProperty( originalId ) ) {
			var qtSettings = tinyMCEPreInit.qtInit[originalId];
			qtSettings.id = id;
			quicktags( qtSettings );
			QTags._buttonsInit();
		}
	}

	/**
	 * Get original ID of the textarea
	 * The ID will be used to reference to tinyMCE and quick tags settings
	 * @param $el Current cloned textarea
	 */
	function getOriginalId( $el ) {
		var $clones = $el.closest( '.rwmb-clone' ).siblings( '.rwmb-clone' ),
			id = '';
		$clones.each( function () {
			var currentId = $( this ).find( '.rwmb-wysiwyg' ).attr( 'id' );
			if ( /_\d+$/.test( currentId ) ) {
				currentId = currentId.replace( /_\d+$/, '' );
			}
			if ( tinyMCEPreInit.mceInit.hasOwnProperty( currentId ) ) {
				id = currentId;
				return false; // Immediately stop the .each() loop
			}
		} );
		return id;
	}

	/**
	 * Update id, class, [data-] attributes, ... of the cloned editor.
	 * @param $wrapper Editor wrapper element
	 * @param id       Editor ID
	 */
	function updateDom( $wrapper, id ) {
		// Wrapper div and media buttons
		$wrapper.attr( 'id', 'mn-' + id + '-wrap' )
		        .removeClass( 'html-active' ).addClass( 'mce-active' ) // Active the visual mode by default
		        .find( '.mce-container' ).remove().end()               // Remove rendered tinyMCE editor
		        .find( '.mn-editor-tools' ).attr( 'id', 'mn-' + id + '-editor-tools' )
		        .find( '.mn-media-buttons' ).attr( 'id', 'mn-' + id + '-media-buttons' )
		        .find( 'button' ).data( 'editor', id ).attr( 'data-editor', id );

		// Editor tabs
		$wrapper.find( '.switch-tmce' )
		        .attr( 'id', id + 'tmce' )
		        .data( 'mn-editor-id', id ).attr( 'data-mn-editor-id', id ).end()
		        .find( '.switch-html' )
		        .attr( 'id', id + 'html' )
		        .data( 'mn-editor-id', id ).attr( 'data-mn-editor-id', id );

		// Quick tags
		$wrapper.find( '.mn-editor-container' ).attr( 'id', 'mn-' + id + '-editor-container' )
		        .find( '.quicktags-toolbar' ).attr( 'id', 'qt_' + id + '_toolbar' ).html( '' );
	}

	$( ':input.rwmb-wysiwyg' ).each( update );
	$( '.rwmb-input' ).on( 'clone', ':input.rwmb-wysiwyg', update );
} );
