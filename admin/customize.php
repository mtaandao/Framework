<?php
/**
 * Theme Customize Screen.
 *
 * @package Mtaandao
 * @subpackage Customize
 * @since 3.4.0
 */

define( 'IFRAME_REQUEST', true );

/** Load Mtaandao Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

if ( ! current_user_can( 'customize' ) ) {
	mn_die(
		'<h1>' . __( 'Cheatin&#8217; uh?' ) . '</h1>' .
		'<p>' . __( 'Sorry, you are not allowed to customize this site.' ) . '</p>',
		403
	);
}

mn_reset_vars( array( 'url', 'return', 'autofocus' ) );
if ( ! empty( $url ) ) {
	$mn_customize->set_preview_url( mn_unslash( $url ) );
}
if ( ! empty( $return ) ) {
	$mn_customize->set_return_url( mn_unslash( $return ) );
}
if ( ! empty( $autofocus ) && is_array( $autofocus ) ) {
	$mn_customize->set_autofocus( mn_unslash( $autofocus ) );
}

/**
 * @global MN_Scripts           $mn_scripts
 * @global MN_Customize_Manager $mn_customize
 */
global $mn_scripts, $mn_customize;

$registered = $mn_scripts->registered;
$mn_scripts = new MN_Scripts;
$mn_scripts->registered = $registered;

add_action( 'customize_controls_print_scripts',        'print_head_scripts', 20 );
add_action( 'customize_controls_print_footer_scripts', '_mn_footer_scripts'     );
add_action( 'customize_controls_print_styles',         'print_admin_styles', 20 );

/**
 * Fires when Customizer controls are initialized, before scripts are enqueued.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_init' );

mn_enqueue_script( 'customize-controls' );
mn_enqueue_style( 'customize-controls' );

/**
 * Enqueue Customizer control scripts.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_enqueue_scripts' );

// Let's roll.
@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));

mn_user_settings();
_mn_admin_html_begin();

$body_class = 'mn-core-ui mn-customizer js';

if ( mn_is_mobile() ) :
	$body_class .= ' mobile';

	?><meta name="viewport" id="viewport-meta" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=1.2" /><?php
endif;

if ( $mn_customize->is_ios() ) {
	$body_class .= ' ios';
}

if ( is_rtl() ) {
	$body_class .= ' rtl';
}
$body_class .= ' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );

$admin_title = sprintf( $mn_customize->get_document_title_template(), __( 'Loading&hellip;' ) );

?><title><?php echo $admin_title; ?></title>

<script type="text/javascript">
var ajaxurl = <?php echo mn_json_encode( admin_url( 'admin-ajax.php', 'relative' ) ); ?>;
</script>

<?php
/**
 * Fires when Customizer control styles are printed.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_print_styles' );

/**
 * Fires when Customizer control scripts are printed.
 *
 * @since 3.4.0
 */
do_action( 'customize_controls_print_scripts' );
?>
</head>
<body class="<?php echo esc_attr( $body_class ); ?>">
<div class="mn-full-overlay expanded">
	<form id="customize-controls" class="wrap mn-full-overlay-sidebar">
		<div id="customize-header-actions" class="mn-full-overlay-header">
			<?php
			$save_text = $mn_customize->is_theme_active() ? __( 'Save &amp; Publish' ) : __( 'Save &amp; Activate' );
			submit_button( $save_text, 'primary save', 'save', false );
			?>
			<span class="spinner"></span>
			<button type="button" class="customize-controls-preview-toggle">
				<span class="controls"><?php _e( 'Customize' ); ?></span>
				<span class="preview"><?php _e( 'Preview' ); ?></span>
			</button>
			<a class="customize-controls-close" href="<?php echo esc_url( $mn_customize->get_return_url() ); ?>">
				<span class="screen-reader-text"><?php _e( 'Close the Customizer and go back to the previous page' ); ?></span>
			</a>
		</div>

		<div id="widgets-right" class="mn-clearfix"><!-- For Widget Customizer, many widgets try to look for instances under div#widgets-right, so we have to add that ID to a container div in the Customizer for compat -->
		<div class="mn-full-overlay-sidebar-content" tabindex="-1">
			<div id="customize-info" class="accordion-section customize-info">
				<div class="accordion-section-title">
					<span class="preview-notice"><?php
						echo sprintf( __( 'You are customizing %s' ), '<strong class="panel-title site-title">' . get_bloginfo( 'name' ) . '</strong>' );
					?></span>
					<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Help' ); ?></span></button>
				</div>
				<div class="customize-panel-description"><?php
					_e( 'The Customizer allows you to preview changes to your site before publishing them. You can also navigate to different pages on your site to preview them.' );
				?></div>
			</div>

			<div id="customize-theme-controls">
				<ul><?php // Panels and sections are managed here via JavaScript ?></ul>
			</div>
		</div>
		</div>

		<div id="customize-footer-actions" class="mn-full-overlay-footer">
			<?php $previewable_devices = $mn_customize->get_previewable_devices(); ?>
			<?php if ( ! empty( $previewable_devices ) ) : ?>
			<div class="devices">
				<?php foreach ( (array) $previewable_devices as $device => $settings ) : ?>
					<?php
					if ( empty( $settings['label'] ) ) {
						continue;
					}
					$active = ! empty( $settings['default'] );
					$class = 'preview-' . $device;
					if ( $active ) {
						$class .= ' active';
					}
					?>
					<button type="button" class="<?php echo esc_attr( $class ); ?>" aria-pressed="<?php echo esc_attr( $active ) ?>" data-device="<?php echo esc_attr( $device ); ?>">
						<span class="screen-reader-text"><?php echo esc_html( $settings['label'] ); ?></span>
					</button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<button type="button" class="collapse-sidebar button-secondary" aria-expanded="true" aria-label="<?php esc_attr_e( 'Collapse Sidebar' ); ?>">
				<span class="collapse-sidebar-arrow"></span>
				<span class="collapse-sidebar-label"><?php _e( 'Collapse' ); ?></span>
			</button>
		</div>
	</form>
	<div id="customize-preview" class="mn-full-overlay-main"></div>
	<?php

	/**
	 * Prints templates, control scripts, and settings in the footer.
	 *
	 * @since 3.4.0
	 */
	do_action( 'customize_controls_print_footer_scripts' );
	?>
</div>
</body>
</html>
