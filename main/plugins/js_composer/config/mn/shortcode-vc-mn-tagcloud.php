<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$tag_taxonomies = array();
if ( 'vc_edit_form' === vc_post_param( 'action' ) && vc_verify_admin_nonce() ) {
	$taxonomies = get_taxonomies();
	if ( is_array( $taxonomies ) && ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $taxonomy ) {
			$tax = get_taxonomy( $taxonomy );
			if ( ( is_object( $tax ) && ( ! $tax->show_tagcloud || empty( $tax->labels->name ) ) ) || ! is_object( $tax ) ) {
				continue;
			}
			$tag_taxonomies[ $tax->labels->name ] = esc_attr( $taxonomy );
		}
	}
}
return array(
	'name' => 'MN ' . __( 'Tag Cloud' ),
	'base' => 'vc_mn_tagcloud',
	'icon' => 'icon-wpb-mn',
	'category' => __( 'Mtaandao Widgets', 'js_composer' ),
	'class' => 'wpb_vc_mn_widget',
	'weight' => - 50,
	'description' => __( 'Your most used tags in cloud format', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'value' => __( 'Tags', 'js_composer' ),
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Taxonomy', 'js_composer' ),
			'param_name' => 'taxonomy',
			'value' => $tag_taxonomies,
			'description' => __( 'Select source for tag cloud.', 'js_composer' ),
			'admin_label' => true,
			'save_always' => true,
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
		),
	),
);
