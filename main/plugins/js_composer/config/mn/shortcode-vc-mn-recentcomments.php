<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => 'MN ' . __( 'Recent Comments' ),
	'base' => 'vc_mn_recentcomments',
	'icon' => 'icon-wpb-mn',
	'category' => __( 'Mtaandao Widgets', 'js_composer' ),
	'class' => 'wpb_vc_mn_widget',
	'weight' => - 50,
	'description' => __( 'The most recent comments', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' ),
			'value' => __( 'Recent Comments' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of comments', 'js_composer' ),
			'description' => __( 'Enter number of comments to display.', 'js_composer' ),
			'param_name' => 'number',
			'value' => 5,
			'admin_label' => true,
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
		),
	),
);
