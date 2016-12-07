<?php
/**
 * Upgrader API: MN_Upgrader_Skin class
 *
 * @package Mtaandao
 * @subpackage Upgrader
 * @since 16.10.0
 */

/**
 * Generic Skin for the Mtaandao Upgrader classes. This skin is designed to be extended for specific purposes.
 *
 * @since 2.8.0
 * @since 16.10.0 Moved to its own file from admin/includes/class-mn-upgrader-skins.php.
 */
class MN_Upgrader_Skin {

	public $upgrader;
	public $done_header = false;
	public $done_footer = false;

	/**
	 * Holds the result of an upgrade.
	 *
	 * @since 2.8.0
	 * @access public
	 * @var string|bool|MN_Error
	 */
	public $result = false;
	public $options = array();

	/**
	 *
	 * @param array $args
	 */
	public function __construct($args = array()) {
		$defaults = array( 'url' => '', 'nonce' => '', 'title' => '', 'context' => false );
		$this->options = mn_parse_args($args, $defaults);
	}

	/**
	 * @param MN_Upgrader $upgrader
	 */
	public function set_upgrader(&$upgrader) {
		if ( is_object($upgrader) )
			$this->upgrader =& $upgrader;
		$this->add_strings();
	}

	/**
	 * @access public
	 */
	public function add_strings() {
	}

	/**
	 * Sets the result of an upgrade.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param string|bool|MN_Error $result The result of an upgrade.
	 */
	public function set_result( $result ) {
		$this->result = $result;
	}

	/**
	 * Displays a form to the user to request for their FTP/SSH details in order
	 * to connect to the filesystem.
	 *
	 * @since 2.8.0
	 * @since 16.10.0 The `$context` parameter default changed from `false` to an empty string.
	 *
	 * @see request_filesystem_credentials()
	 *
	 * @param bool   $error                        Optional. Whether the current request has failed to connect.
	 *                                             Default false.
	 * @param string $context                      Optional. Full path to the directory that is tested
	 *                                             for being writable. Default empty.
	 * @param bool   $allow_relaxed_file_ownership Optional. Whether to allow Group/World writable. Default false.
	 * @return bool False on failure, true on success.
	 */
	public function request_filesystem_credentials( $error = false, $context = '', $allow_relaxed_file_ownership = false ) {
		$url = $this->options['url'];
		if ( ! $context ) {
			$context = $this->options['context'];
		}
		if ( !empty($this->options['nonce']) ) {
			$url = mn_nonce_url($url, $this->options['nonce']);
		}

		$extra_fields = array();

		return request_filesystem_credentials( $url, '', $error, $context, $extra_fields, $allow_relaxed_file_ownership );
	}

	/**
	 * @access public
	 */
	public function header() {
		if ( $this->done_header ) {
			return;
		}
		$this->done_header = true;
		echo '<div class="wrap">';
		echo '<h1>' . $this->options['title'] . '</h1>';
	}

	/**
	 * @access public
	 */
	public function footer() {
		if ( $this->done_footer ) {
			return;
		}
		$this->done_footer = true;
		echo '</div>';
	}

	/**
	 *
	 * @param string|MN_Error $errors
	 */
	public function error($errors) {
		if ( ! $this->done_header )
			$this->header();
		if ( is_string($errors) ) {
			$this->feedback($errors);
		} elseif ( is_mn_error($errors) && $errors->get_error_code() ) {
			foreach ( $errors->get_error_messages() as $message ) {
				if ( $errors->get_error_data() && is_string( $errors->get_error_data() ) )
					$this->feedback($message . ' ' . esc_html( strip_tags( $errors->get_error_data() ) ) );
				else
					$this->feedback($message);
			}
		}
	}

	/**
	 *
	 * @param string $string
	 */
	public function feedback($string) {
		if ( isset( $this->upgrader->strings[$string] ) )
			$string = $this->upgrader->strings[$string];

		if ( strpos($string, '%') !== false ) {
			$args = func_get_args();
			$args = array_splice($args, 1);
			if ( $args ) {
				$args = array_map( 'strip_tags', $args );
				$args = array_map( 'esc_html', $args );
				$string = vsprintf($string, $args);
			}
		}
		if ( empty($string) )
			return;
		show_message($string);
	}

	/**
	 * @access public
	 */
	public function before() {}

	/**
	 * @access public
	 */
	public function after() {}

	/**
	 * Output JavaScript that calls function to decrement the update counts.
	 *
	 * @since 3.9.0
	 *
	 * @param string $type Type of update count to decrement. Likely values include 'plugin',
	 *                     'theme', 'translation', etc.
	 */
	protected function decrement_update_count( $type ) {
		if ( ! $this->result || is_mn_error( $this->result ) || 'up_to_date' === $this->result ) {
			return;
		}

		if ( defined( 'IFRAME_REQUEST' ) ) {
			echo '<script type="text/javascript">
					if ( window.postMessage && JSON ) {
						window.parent.postMessage( JSON.stringify( { action: "decrementUpdateCount", upgradeType: "' . $type . '" } ), window.location.protocol + "//" + window.location.hostname );
					}
				</script>';
		} else {
			echo '<script type="text/javascript">
					(function( mn ) {
						if ( mn && mn.updates.decrementCount ) {
							mn.updates.decrementCount( "' . $type . '" );
						}
					})( window.mn );
				</script>';
		}
	}

	/**
	 * @access public
	 */
	public function bulk_header() {}

	/**
	 * @access public
	 */
	public function bulk_footer() {}
}
