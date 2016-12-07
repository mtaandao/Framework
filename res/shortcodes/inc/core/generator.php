<?php
/**
 * Shortcode Generator
 */
class Sm_Generator {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'media_buttons',                       array( __CLASS__, 'button' ), 1000 );

		add_action( 'sm/update',                           array( __CLASS__, 'reset' ) );
		add_action( 'sm/activation',                       array( __CLASS__, 'reset' ) );
		add_action( 'sunrise/page/before',                 array( __CLASS__, 'reset' ) );
		add_action( 'create_term',                         array( __CLASS__, 'reset' ), 10, 3 );
		add_action( 'edit_term',                           array( __CLASS__, 'reset' ), 10, 3 );
		add_action( 'delete_term',                         array( __CLASS__, 'reset' ), 10, 3 );

		add_action( 'mn_ajax_sm_generator_settings',       array( __CLASS__, 'settings' ) );
		add_action( 'mn_ajax_sm_generator_preview',        array( __CLASS__, 'preview' ) );
		add_action( 'sm/generator/actions',                array( __CLASS__, 'presets' ) );

		add_action( 'mn_ajax_sm_generator_get_icons',      array( __CLASS__, 'ajax_get_icons' ) );
		add_action( 'mn_ajax_sm_generator_get_terms',      array( __CLASS__, 'ajax_get_terms' ) );
		add_action( 'mn_ajax_sm_generator_get_taxonomies', array( __CLASS__, 'ajax_get_taxonomies' ) );
		add_action( 'mn_ajax_sm_generator_add_preset',     array( __CLASS__, 'ajax_add_preset' ) );
		add_action( 'mn_ajax_sm_generator_remove_preset',  array( __CLASS__, 'ajax_remove_preset' ) );
		add_action( 'mn_ajax_sm_generator_get_preset',     array( __CLASS__, 'ajax_get_preset' ) );
	}

	/**
	 * Generator button
	 */
	public static function button( $args = array() ) {
		// Check access
		if ( !self::access_check() ) return;
		// Prepare button target
		$target = is_string( $args ) ? $args : 'content';
		// Prepare args
		$args = mn_parse_args( $args, array(
				'target'    => $target,
				'text'      => __( 'Shortcode', 'shortcodes' ),
				'class'     => 'button',
				'icon'      => ('images/icons/shortcodes.png'),
				'echo'      => true,
				'shortcode' =>
				 false
			) );
		// Prepare icon
		if ( $args['icon'] ) $args['icon'] = '<img src="' . $args['icon'] . '" /> ';
		// Print button
		$button = '<a href="javascript:void(0);" class="sm-generator-button ' . $args['class'] . '" title="' . $args['text'] . '" data-target="' . $args['target'] . '" data-mfp-src="#sm-generator" data-shortcode="' . (string) $args['shortcode'] . '">' . $args['icon'] . $args['text'] . '</a>';
		// Show generator popup
		add_action( 'mn_footer',    array( __CLASS__, 'popup' ) );
		add_action( 'admin_footer', array( __CLASS__, 'popup' ) );
		// Request assets
		mn_enqueue_media();
		sm_query_asset( 'css', array( 'simpleslider', 'farbtastic', 'magnific-popup', 'font-awesome', 'sm-generator' ) );
		sm_query_asset( 'js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'simpleslider', 'farbtastic', 'magnific-popup', 'jquery-hotkeys', 'sm-generator' ) );
		// Hook
		do_action( 'sm/button', $args );
		// Print/return result
		if ( $args['echo'] ) echo $button;
		return $button;
	}

	/**
	 * Cache reset
	 */
	public static function reset() {
		// Clear popup cache
		delete_transient( 'sm/generator/popup' );
		// Clear shortcodes settings cache
		foreach ( array_keys( (array) Sm_Data::shortcodes() ) as $shortcode ) delete_transient( 'sm/generator/settings/' . $shortcode );
	}

	/**
	 * Generator popup form
	 */
	public static function popup() {
		// Get cache
		$output = get_transient( 'sm/generator/popup' );
		if ( $output && SM_ENABLE_CACHE ) echo $output;
		// Cache not found
		else {
?>
		<div id="sm-generator-wrap" style="display:none">
			<div id="sm-generator">
				<div id="sm-generator-header">
					<div id="sm-generator-tools"><?php echo implode( ' <span></span> ', $tools ); ?></div>
					<input type="text" name="sm_generator_search" id="sm-generator-search" value="" placeholder="<?php _e( 'Search for shortcodes', 'shortcodes' ); ?>" />
					<p id="sm-generator-search-pro-tip"><?php printf( '<strong>%s:</strong> %s', __( 'Pro Tip', 'shortcodes' ), __( 'Hit enter to select highlighted shortcode, while searching' ) ) ?></p>
					<div id="sm-generator-filter">
						<strong><?php _e( 'Filter by type', 'shortcodes' ); ?></strong>
						<?php foreach ( (array) Sm_Data::groups() as $group => $label ) echo '<a href="#" data-filter="' . $group . '">' . $label . '</a>'; ?>
					</div>
					<div id="sm-generator-choices" class="sm-generator-clearfix">
						<?php
			// Choices loop
			foreach ( (array) Sm_Data::shortcodes() as $name => $shortcode ) {
				$icon = ( isset( $shortcode['icon'] ) ) ? $shortcode['icon'] : 'puzzle-piece';
				$shortcode['name'] = ( isset( $shortcode['name'] ) ) ? $shortcode['name'] : $name;
				echo '<span data-name="' . $shortcode['name'] . '" data-shortcode="' . $name . '" title="' . esc_attr( $shortcode['desc'] ) . '" data-desc="' . esc_attr( $shortcode['desc'] ) . '" data-group="' . $shortcode['group'] . '">' . Sm_Tools::icon( $icon ) . $shortcode['name'] . '</span>' . "\n";
			}
?>
					</div>
				</div>
				<div id="sm-generator-settings"></div>
				<input type="hidden" name="sm-generator-selected" id="sm-generator-selected" value="<?php echo ( '/' .  RES . '/shortcodes' . '/' ); ?>" />
				<input type="hidden" name="sm-generator-url" id="sm-generator-url" value="<?php echo ( '/' .  RES . '/shortcodes' . '/' ); ?>" />
				<input type="hidden" name="sm-compatibility-mode-prefix" id="sm-compatibility-mode-prefix" value="<?php echo sm_compatibility_mode_prefix(); ?>" />
				<div id="sm-generator-result" style="display:none"></div>
			</div>
		</div>
	<?php
			$output = ob_get_contents();
			set_transient( 'sm/generator/popup', $output, 2 * DAY_IN_SECONDS );
			ob_end_clean();
			echo $output;
		}
	}

	/**
	 * Process AJAX request
	 */
	public static function settings() {
		self::access();
		// Param check
		if ( empty( $_REQUEST['shortcode'] ) ) mn_die( __( 'Shortcode not specified', 'shortcodes' ) );
		// Get cache
		$output = get_transient( 'sm/generator/settings/' . sanitize_text_field( $_REQUEST['shortcode'] ) );
		if ( $output && SM_ENABLE_CACHE ) echo $output;
		// Cache not found
		else {
			// Request queried shortcode
			$shortcode = Sm_Data::shortcodes( sanitize_key( $_REQUEST['shortcode'] ) );
			// Prepare skip-if-default option
			$skip = ( get_option( 'sm_option_skip' ) === 'on' ) ? ' sm-generator-skip' : '';
			// Prepare actions
			$actions = apply_filters( 'sm/generator/actions', array(
					'insert' => '<a href="javascript:void(0);" class="button button-primary button-large sm-generator-insert"><i class="fa fa-check"></i> ' . __( 'Insert shortcode', 'shortcodes' ) . '</a>',
					'preview' => '<a href="javascript:void(0);" class="button button-large sm-generator-toggle-preview"><i class="fa fa-eye"></i> ' . __( 'Live preview', 'shortcodes' ) . '</a>'
				) );
			// Shortcode header
			$return = '<div id="sm-generator-breadcrumbs">';
			$return .= apply_filters( 'sm/generator/breadcrumbs', '<a href="javascript:void(0);" class="sm-generator-home" title="' . __( 'Click to return to the shortcodes list', 'shortcodes' ) . '">' . __( 'All shortcodes', 'shortcodes' ) . '</a> &rarr; <span>' . $shortcode['name'] . '</span> <small class="alignright">' . $shortcode['desc'] . '</small><div class="sm-generator-clear"></div>' );
			$return .= '</div>';
			// Shortcode note
			if ( isset( $shortcode['note'] ) || isset( $shortcode['example'] ) ) {
				$return .= '<div class="sm-generator-note"><i class="fa fa-info-circle"></i><div class="sm-generator-note-content">';
				if ( isset( $shortcode['note'] ) ) $return .= mnautop( $shortcode['note'] );
				if ( isset( $shortcode['example'] ) ) $return .= mnautop( '<a href="' . admin_url( 'admin.php?page=shortcodes-examples&example=' . $shortcode['example'] ) . '" target="_blank">' . __( 'Examples of use', 'shortcodes' ) . ' &rarr;</a>' );
				$return .= '</div></div>';
			}
			// Shortcode has atts
			if ( isset( $shortcode['atts'] ) && count( $shortcode['atts'] ) ) {
				// Loop through shortcode parameters
				foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {
					// Prepare default value
					$default = (string) ( isset( $attr_info['default'] ) ) ? $attr_info['default'] : '';
					$attr_info['name'] = ( isset( $attr_info['name'] ) ) ? $attr_info['name'] : $attr_name;
					$return .= '<div class="sm-generator-attr-container' . $skip . '" data-default="' . esc_attr( $default ) . '">';
					$return .= '<h5>' . $attr_info['name'] . '</h5>';
					// Create field types
					if ( !isset( $attr_info['type'] ) && isset( $attr_info['values'] ) && is_array( $attr_info['values'] ) && count( $attr_info['values'] ) ) $attr_info['type'] = 'select';
					elseif ( !isset( $attr_info['type'] ) ) $attr_info['type'] = 'text';
					if ( is_callable( array( 'Sm_Generator_Views', $attr_info['type'] ) ) ) $return .= call_user_func( array( 'Sm_Generator_Views', $attr_info['type'] ), $attr_name, $attr_info );
					elseif ( isset( $attr_info['callback'] ) && is_callable( $attr_info['callback'] ) ) $return .= call_user_func( $attr_info['callback'], $attr_name, $attr_info );
					if ( isset( $attr_info['desc'] ) ) $attr_info['desc'] = str_replace( '%sm_skins_link%', sm_skins_link(), $attr_info['desc'] );
					if ( isset( $attr_info['desc'] ) ) $return .= '<div class="sm-generator-attr-desc">' . str_replace( array( '<b%value>', '<b_>' ), '<b class="sm-generator-set-value" title="' . __( 'Click to set this value', 'shortcodes' ) . '">', $attr_info['desc'] ) . '</div>';
					$return .= '</div>';
				}
			}
			// Single shortcode (not closed)
			if ( $shortcode['type'] == 'single' ) $return .= '<input type="hidden" name="sm-generator-content" id="sm-generator-content" value="false" />';
			// Wrapping shortcode
			else {
				// Prepare shortcode content
				$shortcode['content'] = ( isset( $shortcode['content'] ) ) ? $shortcode['content'] : '';
				$return .= '<div class="sm-generator-attr-container"><h5>' . __( 'Content', 'shortcodes' ) . '</h5><textarea name="sm-generator-content" id="sm-generator-content" rows="5">' . esc_attr( str_replace( array( '%prefix_', '__' ), sm_cmpt(), $shortcode['content'] ) ) . '</textarea></div>';
			}
			$return .= '<div id="sm-generator-preview"></div>';
			$return .= '<div class="sm-generator-actions sm-generator-clearfix">' . implode( ' ', array_values( $actions ) ) . '</div>';
			set_transient( 'sm/generator/settings/' . sanitize_text_field( $_REQUEST['shortcode'] ), $return, 2 * DAY_IN_SECONDS );
			echo $return;
		}
		exit;
	}

	/**
	 * Process AJAX request and generate preview HTML
	 */
	public static function preview() {
		// Check authentication
		self::access();
		// Output results
		do_action( 'sm/generator/preview/before' );
		echo '<h5>' . __( 'Preview', 'shortcodes' ) . '</h5>';
		// echo '<hr />' . stripslashes( $_POST['shortcode'] ) . '<hr />'; // Uncomment for debug
		echo do_shortcode( str_replace( '\"', '"', $_POST['shortcode'] ) );
		echo '<div style="clear:both"></div>';
		do_action( 'sm/generator/preview/after' );
		die();
	}

	public static function access() {
		if ( !self::access_check() ) mn_die( __( 'Access denied', 'shortcodes' ) );
	}

	public static function access_check() {
		$by_role = ( get_option( 'sm_generator_access' ) ) ? current_user_can( get_option( 'sm_generator_access' ) ) : true;
		return current_user_can( 'edit_posts' ) && $by_role;
	}

	public static function ajax_get_icons() {
		self::access();
		die( Sm_Tools::icons() );
	}

	public static function ajax_get_terms() {
		self::access();
		$args = array();
		if ( isset( $_REQUEST['tax'] ) ) $args['options'] = (array) Sm_Tools::get_terms( sanitize_key( $_REQUEST['tax'] ) );
		if ( isset( $_REQUEST['class'] ) ) $args['class'] = (string) sanitize_key( $_REQUEST['class'] );
		if ( isset( $_REQUEST['multiple'] ) ) $args['multiple'] = (bool) sanitize_key( $_REQUEST['multiple'] );
		if ( isset( $_REQUEST['size'] ) ) $args['size'] = (int) sanitize_key( $_REQUEST['size'] );
		if ( isset( $_REQUEST['noselect'] ) ) $args['noselect'] = (bool) sanitize_key( $_REQUEST['noselect'] );
		die( Sm_Tools::select( $args ) );
	}

	public static function ajax_get_taxonomies() {
		self::access();
		$args = array();
		$args['options'] = Sm_Tools::get_taxonomies();
		die( Sm_Tools::select( $args ) );
	}

	public static function presets( $actions ) {
		ob_start();
?>
<div class="sm-generator-presets alignright" data-shortcode="<?php echo sanitize_key( $_REQUEST['shortcode'] ); ?>">
	<a href="javascript:void(0);" class="button button-large sm-gp-button"><i class="fa fa-bars"></i> <?php _e( 'Presets', 'shortcodes' ); ?></a>
	<div class="sm-gp-popup">
		<div class="sm-gp-head">
			<a href="javascript:void(0);" class="button button-small button-primary sm-gp-new"><?php _e( 'Save current settings as preset', 'shortcodes' ); ?></a>
		</div>
		<div class="sm-gp-list">
			<?php self::presets_list(); ?>
		</div>
	</div>
</div>
		<?php
		$actions['presets'] = ob_get_contents();
		ob_end_clean();
		return $actions;
	}

	public static function presets_list( $shortcode = false ) {
		// Shortcode isn't specified, try to get it from $_REQUEST
		if ( !$shortcode ) $shortcode = $_REQUEST['shortcode'];
		// Shortcode name is still doesn't exists, exit
		if ( !$shortcode ) return;
		// Shortcode has been specified, sanitize it
		$shortcode = sanitize_key( $shortcode );
		// Get presets
		$presets = get_option( 'sm_presets_' . $shortcode );
		// Presets has been found
		if ( is_array( $presets ) && count( $presets ) ) {
			// Print the presets
			foreach ( $presets as $preset ) {
				echo '<span data-id="' . $preset['id'] . '"><em>' . stripslashes( $preset['name'] ) . '</em> <i class="fa fa-times"></i></span>';
			}
			// Hide default text
			echo sprintf( '<b style="display:none">%s</b>', __( 'Presets not found', 'shortcodes' ) );
		}
		// Presets doesn't found
		else echo sprintf( '<b>%s</b>', __( 'Presets not found', 'shortcodes' ) );
	}

	public static function ajax_add_preset() {
		self::access();
		// Check incoming data
		if ( empty( $_POST['id'] ) ) return;
		if ( empty( $_POST['name'] ) ) return;
		if ( empty( $_POST['settings'] ) ) return;
		if ( empty( $_POST['shortcode'] ) ) return;
		// Clean-up incoming data
		$id = sanitize_key( $_POST['id'] );
		$name = sanitize_text_field( $_POST['name'] );
		$settings = ( is_array( $_POST['settings'] ) ) ? stripslashes_deep( $_POST['settings'] ) : array();
		$shortcode = sanitize_key( $_POST['shortcode'] );
		// Prepare option name
		$option = 'sm_presets_' . $shortcode;
		// Get the existing presets
		$current = get_option( $option );
		// Create array with new preset
		$new = array(
			'id'       => $id,
			'name'     => $name,
			'settings' => $settings
		);
		// Add new array to the option value
		if ( !is_array( $current ) ) $current = array();
		$current[$id] = $new;
		// Save updated option
		update_option( $option, $current );
		// Clear cache
		delete_transient( 'sm/generator/settings/' . $shortcode );
	}

	public static function ajax_remove_preset() {
		self::access();
		// Check incoming data
		if ( empty( $_POST['id'] ) ) return;
		if ( empty( $_POST['shortcode'] ) ) return;
		// Clean-up incoming data
		$id = sanitize_key( $_POST['id'] );
		$shortcode = sanitize_key( $_POST['shortcode'] );
		// Prepare option name
		$option = 'sm_presets_' . $shortcode;
		// Get the existing presets
		$current = get_option( $option );
		// Check that preset is exists
		if ( !is_array( $current ) || empty( $current[$id] ) ) return;
		// Remove preset
		unset( $current[$id] );
		// Save updated option
		update_option( $option, $current );
		// Clear cache
		delete_transient( 'sm/generator/settings/' . $shortcode );
	}

	public static function ajax_get_preset() {
		self::access();
		// Check incoming data
		if ( empty( $_GET['id'] ) ) return;
		if ( empty( $_GET['shortcode'] ) ) return;
		// Clean-up incoming data
		$id = sanitize_key( $_GET['id'] );
		$shortcode = sanitize_key( $_GET['shortcode'] );
		// Default data
		$data = array();
		// Get the existing presets
		$presets = get_option( 'sm_presets_' . $shortcode );
		// Check that preset is exists
		if ( is_array( $presets ) && isset( $presets[$id]['settings'] ) ) $data = $presets[$id]['settings'];
		// Print results
		die( json_encode( $data ) );
	}
}

new Sm_Generator;

class Shortcodes_Ultimate_Generator extends Sm_Generator {
	function __construct() {
		parent::__construct();
	}
}
