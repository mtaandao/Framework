<?php
/**
 * Enqueue scripts and styles.
 */
function ese_scripts() {
	$primary = get_theme_mod( 'primary_color', 'teal' );
	$secondary = get_theme_mod( 'secondary_color', 'green' );

	mn_enqueue_style( 'ese-mdl-css', home_url() . '/install/css/material.min.css' );

	mn_enqueue_style( 'ese-mdl-css', '//storage.googleapis.com/code.getmdl.io/1.1.3/material.'.$primary.'-'.$secondary.'.min.css' );

	mn_enqueue_style( 'ese-mdl-icons', '//fonts.googleapis.com/icon?family=Material+Icons' );

	mn_enqueue_style( 'ese-mdl-roboto', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700' );

	mn_enqueue_style( 'ese-style', get_template_directory_uri() . '/style.min.css' );

	mn_enqueue_script( 'ese-mdl-js', home_url() . '/install/js/material.min.js', array(), '1.1.1', true );

	mn_enqueue_script( 'ese-ese-js', get_template_directory_uri() . '/js/dist/scripts.min.js', array('jquery'), '1.1.9', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		mn_enqueue_script( 'comment-reply' );
	}
}
add_action( 'mn_enqueue_scripts', 'ese_scripts' );


/**
 * Enqueue customizer script
 */
function ese_customizer_live_preview() {
	mn_enqueue_script( 'ese-themecustomizer',	get_template_directory_uri() . '/js/customizer.js', array( 'jquery','customize-preview' ), '', true );
}
add_action( 'customize_preview_init', 'ese_customizer_live_preview' );
