<?php
/**
 * About This Version administration panel.
 *
 * @package Mtaandao
 * @subpackage Administration
 */

/** Mtaandao Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

if ( ! mn_is_mobile() ) {
	mn_enqueue_style( 'mn-mediaelement' );
	mn_enqueue_script( 'mn-mediaelement' );
	mn_localize_script( 'mediaelement', '_mnmejsSettings', array(
		'pluginPath'        => includes_url( 'js/mediaelement/', 'relative' ),
		'pauseOtherPlayers' => '',
	) );
}

/**
 * Replaces the height and width attributes with values for full size.
 *
 * mn_video_shortcode() limits the width to 640px.
 *
 * @since 16.10.0
 * @ignore
 *
 * @param $output Video shortcode HTML output.
 * @return string Filtered HTML content to display video.
 */
function _mn_override_admin_video_width_limit( $output ) {
	return str_replace( array( '640', '384' ), array( '1050', '630' ), $output );
}

$video_url = 'https://videopress.com/embed/GbdhpGF3?hd=true';
$locale    = str_replace( '_', '-', get_locale() );
list( $locale ) = explode( '-', $locale );
if ( 'en' !== $locale ) {
	$video_url = add_query_arg( 'defaultLangCode', $locale, $video_url );
}

$title = __( 'About' );

list( $display_version ) = explode( '-', $mn_version );

include( ABSPATH . 'admin/admin-header.php' );
?>
	<div class="wrap about-wrap">
		<h1><?php printf( __( 'Welcome to Mtaandao&nbsp;%s' ), $display_version ); ?></h1>

		<p class="about-text"><?php printf( __( 'Thank you for choosing Mtaandao. Version %s has numerous improvements to make your WordPress experience even better!' ), $display_version ); ?></p>
		<div class="mn-badge"><?php printf( __( 'Version %s' ), $display_version ); ?></div>

		<h2 class="nav-tab-wrapper mn-clearfix">
			<a href="about.php" class="nav-tab nav-tab-active"><?php _e( 'What&#8217;s New' ); ?></a>
			<a href="credits.php" class="nav-tab"><?php _e( 'Credits' ); ?></a>
			<a href="freedoms.php" class="nav-tab"><?php _e( 'Freedoms' ); ?></a>
		</h2>

		<div class="changelog point-releases">
			<h3><?php _e( 'User Roles Manager' ); ?></h3>
			<p><?php printf( _n( '<strong>Version %1$s</strong> adds the feature that allows you to create new user classes and assign specific capabilities to those users.',
				'<strong>Version %1$s</strong> adds the feature that allows you to create new user classes and assign specific capabilities to those users', 15 ), '16.10', number_format_i18n( 15 ) ); ?>
				<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://mtaandao.co.ke/docs/v16.10' ); ?>
			</p>
		</div>

		<div class="headline-feature feature-video">
			<iframe width="1050" height="591" src="<?php echo (admin_url() . 'users.php?page=users-role-manager.php'); ?>" frameborder="0" allowfullscreen></iframe>
		</div>

		<hr>

		<div class="changelog point-releases">
			<h3><?php _e( 'More Branding Options' ); ?></h3>
			<p><?php printf( _n( '<strong>Make %1$s</strong> trully your own with endless customization options. Change colours, hide menu items, change footer text and more.',
				'<strong>Make %1$s</strong> trully your own with endless customization options. Change colours, hide menu items, change footer text and more', 15 ), 'Mtaandao', number_format_i18n( 15 ) ); ?>
				<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://mtaandao.co.ke/docs/v16.10' ); ?>
			</p>
		</div>

		<div class="headline-feature feature-video">
			<iframe width="1050" height="591" src="<?php echo (admin_url() . 'admin.php?page=custom_branding_color_schemes'); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
		
		<hr />
		<div class="changelog">
			<h2><?php _e( 'Under the Hood' ); ?></h2>

			<div class="under-the-hood three-col">
				<div class="col">
					<h3><?php _e( 'Resource Hints' ); ?></h3>
					<p><?php
						printf(
							/* translators: %s: https://make.mtaandao.co.ke/core/2016/07/06/resource-hints-in-4-6/ */
							__( '<a href="%s">Resource hints help browsers</a> decide which resources to fetch and preprocess. Mtaandao 16.10 adds them automatically for your styles and scripts making your site even faster.' ),
							'https://make.mtaandao.co.ke/core/2016/07/06/resource-hints-in-4-6/'
						);
					?></p>
				</div>
				<div class="col">
					<h3><?php _e( 'Robust Requests' ); ?></h3>
					<p><?php _e( 'The HTTP API now leverages the Requests library, improving HTTP standard support and adding case-insensitive headers, parallel HTTP requests, and support for Internationalized Domain Names.' ); ?></p>
				</div>
				<div class="col">
					<h3><?php
						/* translators: 1: MN_Term_Query, 2: MN_Post_Type */
						printf( __( '%1$s and %2$s' ), '<code>MN_Term_Query</code>', '<code>MN_Post_Type</code>' );
					?></h3>
					<p><?php
						printf(
							/* translators: 1: MN_Term_Query, 2: MN_Post_Type */
							__( 'A new %1$s class adds flexibility to query term information while a new %2$s object makes interacting with post types more predictable.' ),
							'<code>MN_Term_Query</code>',
							'<code>MN_Post_Type</code>'
						);
					?></p>
				</div>
			</div>

			<div class="under-the-hood three-col">
				<div class="col">
					<h3><?php _e( 'Meta Registration API' ); ?></h3>
					<p><?php
						printf(
							/* translators: %s: https://make.mtaandao.co.ke/core/2016/07/08/enhancing-register_meta-in-4-6/  */
							__( 'The Meta Registration API <a href="%s">has been expanded</a> to support types, descriptions, and REST API visibility.' ),
							'https://make.mtaandao.co.ke/core/2016/07/08/enhancing-register_meta-in-4-6/'
						);
					?></p>
				</div>
				<div class="col">
					<h3><?php _e( 'Material Design' ); ?></h3>
					<p><?php _e( 'Mtaandao now natively integrates Material design so you can make beautiful apps with it.' ); ?></p>
				</div>
				<div class="col">
					<h3><?php _e( 'Font Awesome' ); ?></h3>
					<p><?php _e( 'Now you can use the wide library of Font-Awesome icons in your admin as well as front-end. Mtaandao integrates Font Awesome natively.' ); ?></p>
				</div>
			</div>

			<div class="under-the-hood two-col">
				<div class="col">
					<h3><?php _e( 'Customizer APIs for Setting Validation and Notifications' ); ?></h3>
					<p><?php _e( 'Settings now have an <a href="https://make.mtaandao.co.ke/core/2016/07/05/customizer-apis-in-4-6-for-setting-validation-and-notifications/">API for enforcing validation constraints</a>. Likewise, customizer controls now support notifications, which are used to display validation errors instead of failing silently.' ); ?></p>
				</div>
				<div class="col">
					<h3><?php _e( 'Native Fonts' ); ?></h3>
					<p><?php
						printf(
							/* translators: 1: MN_Site_Query, 2: MN_Network_Query */
							__( 'Mtaandao utilizes fonts already installed on your device so as to load faster')
						);
					?></p>
				</div>
			</div>
		</div>

		<hr />

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? _e( 'Return to Updates' ) : _e( 'Return to Dashboard &rarr; Updates' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? _e( 'Go to Dashboard &rarr; Home' ) : _e( 'Go to Dashboard' ); ?></a>
		</div>

	</div>
<?php

include( ABSPATH . 'admin/admin-footer.php' );

// These are strings we may use to describe maintenance/security releases, where we aim for no new strings.
return;

__( 'Maintenance Release' );
__( 'Maintenance Releases' );

__( 'Security Release' );
__( 'Security Releases' );

__( 'Maintenance and Security Release' );
__( 'Maintenance and Security Releases' );

/* translators: %s: Mtaandao version number */
__( '<strong>Version %s</strong> addressed one security issue.' );
/* translators: %s: Mtaandao version number */
__( '<strong>Version %s</strong> addressed some security issues.' );

/* translators: 1: Mtaandao version number, 2: plural number of bugs. */
_n_noop( '<strong>Version %1$s</strong> addressed %2$s bug.',
         '<strong>Version %1$s</strong> addressed %2$s bugs.' );

/* translators: 1: Mtaandao version number, 2: plural number of bugs. Singular security issue. */
_n_noop( '<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bugs.' );

/* translators: 1: Mtaandao version number, 2: plural number of bugs. More than one security issue. */
_n_noop( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.' );

/* translators: %s: Codex URL */
__( 'For more information, see <a href="%s">the release notes</a>.' );
