<?php
class Sm_Admin_Views {
	function __construct() {}

	public static function about( $field, $config ) {
		ob_start();
?>
<div id="sm-about-screen">
	<h1><?php _e( 'Welcome to Mtaandao Shortcodes', 'shortcodes' ); ?> <small><?php _e( 'A real swiss army knife for Mtaandao', 'shortcodes' ); ?></small></h1>
	<div class="sunrise-inline-menu">
		<a href="http://mtaandao.co.ke/plugins/shortcodes/" target="_blank"><strong><?php _e( 'Project homepage', 'shortcodes' ); ?></strong></a>
		<a href="http://mtaandao.co.ke/kb/" target="_blank"><?php _e( 'Documentation', 'shortcodes' ); ?></a>
		<a href="http://mtaandao.co.ke/support/plugin/shortcodes/" target="_blank"><?php _e( 'Support forum', 'shortcodes' ); ?></a>
		<a href="http://mtaandao.co.ke/extend/plugins/shortcodes/changelog/" target="_blank"><?php _e( 'Changelog', 'shortcodes' ); ?></a>
		<a href="https://github.com/gndev/shortcodes" target="_blank"><?php _e( 'Fork on GitHub', 'shortcodes' ); ?></a>
	</div>
	<div class="sm-clearfix">
		<div class="sm-about-column">
			<h3><?php _e( 'Plugin features', 'shortcodes' ); ?></h3>
			<ul>
				<li><?php _e( '40+ amazing shortcodes', 'shortcodes' ); ?></li>
				<li><?php _e( 'Power of CSS3 transitions', 'shortcodes' ); ?></li>
				<li><?php _e( 'Handy shortcodes generator', 'shortcodes' ) ?></li>
				<li><?php _e( 'International', 'shortcodes' ); ?></li>
				<li><?php _e( 'Documented API', 'shortcodes' ); ?></li>
			</ul>
		</div>
		<div class="sm-about-column">
			<h3><?php _e( 'What is a shortcode?', 'shortcodes' ); ?></h3>
			<p><?php _e( '<strong>Shortcode</strong> is a mtaandao-specific code that lets you do nifty things with very little effort.', 'shortcodes' ); ?></p>
			<p><?php _e( 'Shortcodes can embed files or create objects that would normally require lots of complicated, ugly code in just one line. Shortcode = shortcut.', 'shortcodes' ); ?></p>
		</div>
	</div>
	<div class="sm-clearfix">
		<div class="sm-about-column">
			<h3><?php _e( 'How does it works', 'shortcodes' ); ?></h3>
			<a href="http://www.youtube.com/watch?v=lni-w2dtcQY?autoplay=1&amp;showinfo=0&amp;rel=0&amp;design=light#" target="_blank" class="sm-demo-video"><img src="<?php echo ( '/' .  RES . '/shortcodes/assets/images/banners/how-it-works.jpg'); ?>" alt=""></a>
		</div>
		<div class="sm-about-column">
			<h3><?php _e( 'More videos', 'shortcodes' ); ?></h3>
			<ul>
				<li><a href="http://www.youtube.com/watch?v=IjmaXz-b55I" target="_blank"><?php _e( 'Mtaandao Shortcodes Tutorial', 'shortcodes' ); ?></a></li>
				<li><a href="http://www.youtube.com/watch?v=YU3Zu6C5ZfA" target="_blank"><?php _e( 'How to use special widget', 'shortcodes' ); ?></a></li>
				<li><a href="http://www.screenr.com/BK0H" target="_blank"><?php _e( 'How to create Carousel', 'shortcodes' ); ?></a></li>
				<li><a href="http://www.youtube.com/watch?v=kCWyO2F7jTw" target="_blank"><?php _e( 'How to create image gallery', 'shortcodes' ); ?></a></li>
			</ul>
		</div>
	</div>
</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		sm_query_asset( 'css', array( 'magnific-popup', 'sm-options-page' ) );
		sm_query_asset( 'js', array( 'jquery', 'magnific-popup', 'sm-options-page' ) );
		return $output;
	}

	public static function custom_css( $field, $config ) {
		ob_start();
?>
<div id="sm-custom-css-screen">
	<div class="sm-custom-css-originals">
		<p><strong><?php _e( 'You can overview the original styles to overwrite it', $config['textdomain'] ); ?></strong></p>
		<div class="sunrise-inline-menu">
			<a href="<?php echo sm_skin_url( 'content-shortcodes.css' ); ?>">content-shortcodes.css</a>
			<a href="<?php echo sm_skin_url( 'box-shortcodes.css' ); ?>">box-shortcodes.css</a>
			<a href="<?php echo sm_skin_url( 'media-shortcodes.css' ); ?>">media-shortcodes.css</a>
			<a href="<?php echo sm_skin_url( 'galleries-shortcodes.css' ); ?>">galleries-shortcodes.css</a>
			<a href="<?php echo sm_skin_url( 'players-shortcodes.css' ); ?>">players-shortcodes.css</a>
			<a href="<?php echo sm_skin_url( 'other-shortcodes.css' ); ?>">other-shortcodes.css</a>
		</div>
		<?php do_action( 'sm/admin/css/originals/after' ); ?>
	</div>
	<div class="sm-custom-css-vars">
		<p><strong><?php _e( 'You can use next variables in your custom CSS', $config['textdomain'] ); ?></strong></p>
		<code>%home_url%</code> - <?php _e( 'home url', $config['textdomain'] ); ?><br/>
		<code>%design_url%</code> - <?php _e( 'design url', $config['textdomain'] ); ?><br/>
		<code>%plugin_url%</code> - <?php _e( 'plugin url', $config['textdomain'] ); ?>
	</div>
	<div id="sm-custom-css-editor">
		<div id="sunrise-field-<?php echo $field['id']; ?>-editor"></div>
		<textarea name="sunrise[<?php echo $field['id']; ?>]" id="sunrise-field-<?php echo $field['id']; ?>" class="regular-text" rows="10"><?php echo stripslashes( get_option( $config['prefix'] . $field['id'] ) ); ?></textarea>
	</div>
</div>
			<?php
		$output = ob_get_contents();
		ob_end_clean();
		sm_query_asset( 'css', array( 'magnific-popup', 'sm-options-page' ) );
		sm_query_asset( 'js', array( 'jquery', 'magnific-popup', 'ace', 'sm-options-page' ) );
		return $output;
	}

	public static function examples( $field, $config ) {
		$output = array();
		$examples = Sm_Data::examples();
		$preview = '<div style="display:none"><div id="sm-examples-window"><div id="sm-examples-preview"></div></div></div>';
		$open = ( isset( $_GET['example'] ) ) ? sanitize_key( $_GET['example'] ) : '';
		$open = '<input id="sm_open_example" type="hidden" name="sm_open_example" value="' . $open . '" />';
		$nonce = '<input id="sm_examples_nonce" type="hidden" name="sm_examples_nonce" value="' . mn_create_nonce( 'sm_examples_nonce' ) . '" />';
		foreach ( $examples as $group ) {
			$items = array();
			if ( isset( $group['items'] ) ) foreach ( $group['items'] as $item ) {
					$code = ( isset( $item['code'] ) ) ? $item['code'] : ( '/' .  RES . '/shortcodes/inc/examples/' . $item['id'] . '.example');
					$id = ( isset( $item['id'] ) ) ? $item['id'] : '';
					$items[] = '<div class="sm-examples-item" data-code="' . $code . '" data-id="' . $id . '" data-mfp-src="#sm-examples-window"><i class="fa fa-' . $item['icon'] . '"></i> ' . $item['name'] . '</div>';
				}
			$output[] = '<div class="sm-examples-group sm-clearfix"><h2 class="sm-examples-group-title">' . $group['title'] . '</h2>' . implode( '', $items ) . '</div>';
		}
		sm_query_asset( 'css', array( 'magnific-popup', 'font-awesome', 'sm-options-page' ) );
		sm_query_asset( 'js', array( 'jquery', 'magnific-popup', 'sm-options-page' ) );
		return '<div id="sm-examples-screen">' . implode( '', $output ) . '</div>' . $preview . $open . $nonce;
	}

	public static function cheatsheet( $field, $config ) {
		// Prepare print button
		$print = '<div><a href="javascript:;" id="sm-cheatsheet-print" class="sm-cheatsheet-switch button button-primary button-large">' . __( 'Printable version', 'shortcodes' ) . '</a><div id="sm-cheatsheet-print-head"><h1>' . __( 'Mtaandao Shortcodes', 'shortcodes' ) . ': ' . __( 'Cheatsheet', 'shortcodes' ) . '</h1><a href="javascript:;" class="sm-cheatsheet-switch">&larr; ' . __( 'Back to Dashboard', 'shortcodes' ) . '</a></div></div>';
		// Prepare table array
		$table = array();
		// Table start
		$table[] = '<table><tr><th style="width:20%;">' . __( 'Shortcode', 'shortcodes' ) . '</th><th style="width:50%">' . __( 'Attributes', 'shortcodes' ) . '</th><th style="width:30%">' . __( 'Example code', 'shortcodes' ) . '</th></tr>';
		// Loop through shortcodes
		foreach ( (array) Sm_Data::shortcodes() as $name => $shortcode ) {
			// Prepare vars
			$icon = ( isset( $shortcode['icon'] ) ) ? $shortcode['icon'] : 'puzzle-piece';
			$shortcode['name'] = ( isset( $shortcode['name'] ) ) ? $shortcode['name'] : $name;
			$attributes = array();
			$example = array();
			$icons = 'icon: music, icon: envelope &hellip; <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">' . __( 'full list', 'shortcodes' ) . '</a>';
			// Loop through attributes
			if ( is_array( $shortcode['atts'] ) )
				foreach ( $shortcode['atts'] as $id => $data ) {
					// Prepare default value
					$default = ( isset( $data['default'] ) && $data['default'] !== '' ) ? '<p><em>' . __( 'Default value', 'shortcodes' ) . ':</em> ' . $data['default'] . '</p>' : '';
					// Check type is set
					if ( empty( $data['type'] ) ) $data['type'] = 'text';
					// Switch attribute types
					switch ( $data['type'] ) {
						// Select
					case 'select':
						$value = implode( ', ', array_keys( $data['values'] ) );
						break;
						// Slider and number
					case 'slider':
					case 'number':
						$value = $data['min'] . '&hellip;' . $data['max'];
						break;
						// Bool
					case 'bool':
						$value = 'yes | no';
						break;
						// Icon
					case 'icon':
						$value = $icons;
						break;
						// Color
					case 'color':
						$value = __( '#RGB and rgba() colors' );
						break;
						// Default value
					default:
						$value = $data['default'];
						break;
					}
					// Check empty value
					if ( $value === '' ) $value = __( 'Any text value', 'shortcodes' );
					// Extra CSS class
					if ( $id === 'class' ) $value = __( 'Any custom CSS classes', 'shortcodes' );
					// Add attribute
					$attributes[] = '<div class="sm-shortcode-attribute"><strong>' . $data['name'] . ' <em>&ndash; ' . $id . '</em></strong><p><em>' . __( 'Possible values', 'shortcodes' ) . ':</em> ' . $value . '</p>' . $default . '</div>';
					// Add attribute to the example code
					$example[] = $id . '="' . $data['default'] . '"';
				}
			// Prepare example code
			$example = '[%prefix_' . $name . ' ' . implode( ' ', $example ) . ']';
			// Prepare content value
			if ( empty( $shortcode['content'] ) ) $shortcode['content'] = '';
			// Add wrapping code
			if ( $shortcode['type'] === 'wrap' ) $example .= esc_textarea( $shortcode['content'] ) . '[/%prefix_' . $name . ']';
			// Change compatibility prefix
			$example = str_replace( array( '%prefix_', '__' ), sm_cmpt(), $example );
			// Shortcode
			$table[] = '<td>' . '<span class="sm-shortcode-icon">' . Sm_Tools::icon( $icon ) . '</span>' . $shortcode['name'] . '<br/><em class="sm-shortcode-desc">' . $shortcode['desc'] . '</em></td>';
			// Attributes
			$table[] = '<td>' . implode( '', $attributes ) . '</td>';
			// Example code
			$table[] = '<td><code contenteditable="true">' . $example . '</code></td></tr>';
		}
		// Table end
		$table[] = '</table>';
		// Query assets
		sm_query_asset( 'css', array( 'font-awesome', 'sm-cheatsheet' ) );
		sm_query_asset( 'js', array( 'jquery', 'sm-options-page' ) );
		// Return output
		return '<div id="sm-cheatsheet-screen">' . $print . implode( '', $table ) . '</div>';
	}

	public static function addons( $field, $config ) {
		$output = array();
		$addons = array(
			array(
				'name' => __( 'New Shortcodes', 'shortcodes' ),
				'desc' => __( 'Parallax sections, responsive content slider, pricing tables, vector icons, testimonials, progress bars and even more', 'shortcodes' ),
				'url' => 'http://mtaandao.co.ke/plugins/shortcodes/extra/',
				'image' => ( '/' .  RES . '/shortcodes/assets/images/banners/extra.png')
			),
			array(
				'name' => __( 'Maker', 'shortcodes' ),
				'desc' => __( 'This add-on allows you to create custom shortcodes. You can easily create any shortcode with different parameters or even override default shortcodes', 'shortcodes' ),
				'url' => 'http://mtaandao.co.ke/plugins/shortcodes/maker/',
				'image' => ( '/' .  RES . '/shortcodes/assets/images/banners/maker.png')
			),
			array(
				'name' => __( 'Skins', 'shortcodes' ),
				'desc' => __( 'Set of additional skins for Mtaandao Shortcodes. It includes skins for accordeons/spoilers, tabs and some other shortcodes', 'shortcodes' ),
				'url' => 'http://mtaandao.co.ke/plugins/shortcodes/skins/',
				'image' => ( '/' .  RES . '/shortcodes/assets/images/banners/skins.png' )
			),
			array(
				'name' => __( 'Add-ons bundle', 'shortcodes' ),
				'desc' => __( 'Get all three add-ons with huge discount!', 'shortcodes' ),
				'url' => 'http://mtaandao.co.ke/plugins/shortcodes/add-ons-bundle/',
				'image' => ( '/' .  RES . '/shortcodes/assets/images/banners/bundle.png' )
			),
		);
		$plugins = array();
		$output[] = '<h2>' . __( 'Mtaandao Shortcodes Add-ons', 'shortcodes' ) . '</h2>';
		$output[] = '<div class="sm-addons-loop sm-clearfix">';
		foreach ( $addons as $addon ) {
			$output[] = '<div class="sm-addons-item" style="visibility:hidden" data-url="' . $addon['url'] . '"><img src="' . $addon['image'] . '" alt="' . $addon['image'] . '" /><div class="sm-addons-item-content"><h4>' . $addon['name'] . '</h4><p>' . $addon['desc'] . '</p><div class="sm-addons-item-button"><a href="' . $addon['url'] . '" class="button button-primary" target="_blank">' . __( 'Learn more', 'shortcodes' ) . '</a></div></div></div>';
		}
		$output[] = '</div>';
		if ( count( $plugins ) ) {
			$output[] = '<h2>' . __( 'Other Mtaandao Plugins', 'shortcodes' ) . '</h2>';
			$output[] = '<div class="sm-addons-loop sm-clearfix">';
			foreach ( $plugins as $plugin ) {
				$output[] = '<div class="sm-addons-item" style="visibility:hidden" data-url="' . $plugin['url'] . '"><img src="' . $plugin['image'] . '" alt="' . $plugin['image'] . '" /><div class="sm-addons-item-content"><h4>' . $plugin['name'] . '</h4><p>' . $plugin['desc'] . '</p>' . Sm_Shortcodes::button( array( 'url' => $plugin['url'], 'target' => 'blank', 'style' => 'flat', 'background' => '#FF7654', 'wide' => 'yes', 'radius' => '0' ), __( 'Learn more', 'shortcodes' ) ) . '</div></div>';
			}
			$output[] = '</div>';
		}
		sm_query_asset( 'css', array( 'animate', 'sm-options-page' ) );
		sm_query_asset( 'js', array( 'jquery', 'sm-options-page' ) );
		return '<div id="sm-addons-screen">' . implode( '', $output ) . '</div>';
	}
}
