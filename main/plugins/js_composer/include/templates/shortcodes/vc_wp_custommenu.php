<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $nav_menu
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_mn_Custommenu
 */
$title = $nav_menu = $el_class = '';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$output = '<div class="vc_mn_custommenu wpb_content_element' . esc_attr( $el_class ) . '">';
$type = 'MN_Nav_Menu_Widget';
$args = array();
global $mn_widget_factory;
// to avoid unwanted warnings let's check before using widget
if ( is_object( $mn_widget_factory ) && isset( $mn_widget_factory->widgets, $mn_widget_factory->widgets[ $type ] ) ) {
	ob_start();
	the_widget( $type, $atts, $args );
	$output .= ob_get_clean();

	$output .= '</div>';

	echo $output;
} else {
	echo $this->debugComment( 'Widget ' . esc_attr( $type ) . 'Not found in : vc_mn_custommenu' );
}
