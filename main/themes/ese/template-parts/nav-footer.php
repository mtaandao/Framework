<?php
/**
 * The template part for displaying the footer navigation
 *
 * Learn more: http://mtaandao.co.ke/docs/Template_Hierarchy
 *
 * @package Ese
 */

	$args = array(
        'theme_location' => 'footer',
        'menu_class' => 'mdl-mega-footer__link-list',
        'container_class' => 'mdl-mega-footer__bottom-section',
		
	);

	if (has_nav_menu('footer')) {
	    mn_nav_menu($args);
	}
?>
	<center>Powered by <a href="<?php echo esc_url( __( 'https://mtaandao.co.ke/', 'ese' ) ); ?>"><?php printf( __( ' %s', 'ese' ), 'Mtaandao' ); ?></a></center>
<?php
?>
