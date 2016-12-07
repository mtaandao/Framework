<?php
/**
 * Shortcode Generator
 */
class Sm_Generator_Views {

	/**
	 * Constructor
	 */
	function __construct() {}

	public static function text( $id, $field ) {
		$field = mn_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr" />';
		return $return;
	}

	public static function textarea( $id, $field ) {
		$field = mn_parse_args( $field, array(
			'rows'    => 3,
			'default' => ''
		) );
		$return = '<textarea name="' . $id . '" id="sm-generator-attr-' . $id . '" rows="' . $field['rows'] . '" class="sm-generator-attr">' . esc_textarea( $field['default'] ) . '</textarea>';
		return $return;
	}

	public static function select( $id, $field ) {
		// Multiple selects
		$multiple = ( isset( $field['multiple'] ) ) ? ' multiple' : '';
		$return = '<select name="' . $id . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr"' . $multiple . '>';
		// Create options
		foreach ( $field['values'] as $option_value => $option_title ) {
			// Is this option selected
			$selected = ( $field['default'] === $option_value ) ? ' selected="selected"' : '';
			// Create option
			$return .= '<option value="' . $option_value . '"' . $selected . '>' . $option_title . '</option>';
		}
		$return .= '</select>';
		return $return;
	}

	public static function bool( $id, $field ) {
		$return = '<span class="sm-generator-switch sm-generator-switch-' . $field['default'] . '"><span class="sm-generator-yes">' . __( 'Yes', 'shortcodes' ) . '</span><span class="sm-generator-no">' . __( 'No', 'shortcodes' ) . '</span></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr sm-generator-switch-value" />';
		return $return;
	}

	public static function upload( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr sm-generator-upload-value" /><div class="sm-generator-field-actions"><a href="javascript:;" class="button sm-generator-upload-button"><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Media manager', 'shortcodes' ) . '" />' . __( 'Media manager', 'shortcodes' ) . '</a></div>';
		return $return;
	}

	public static function icon( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr sm-generator-icon-picker-value" /><div class="sm-generator-field-actions"><a href="javascript:;" class="button sm-generator-upload-button sm-generator-field-action"><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Media manager', 'shortcodes' ) . '" />' . __( 'Media manager', 'shortcodes' ) . '</a> <a href="javascript:;" class="button sm-generator-icon-picker-button sm-generator-field-action"><img src="' . admin_url( '/images/media-button-other.gif' ) . '" alt="' . __( 'Icon picker', 'shortcodes' ) . '" />' . __( 'Icon picker', 'shortcodes' ) . '</a></div><div class="sm-generator-icon-picker sm-generator-clearfix"><input type="text" class="widefat" placeholder="' . __( 'Filter icons', 'shortcodes' ) . '" /></div>';
		return $return;
	}

	public static function color( $id, $field ) {
		$return = '<span class="sm-generator-select-color"><span class="sm-generator-select-color-wheel"></span><input type="text" name="' . $id . '" value="' . $field['default'] . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr sm-generator-select-color-value" /></span>';
		return $return;
	}

	public static function gallery( $id, $field ) {
		$shult = Mtaandao_Shortcodes();
		// Prepare galleries list
		$galleries = $shult->get_option( 'galleries' );
		$created = ( is_array( $galleries ) && count( $galleries ) ) ? true : false;
		$return = '<select name="' . $id . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr" data-loading="' . __( 'Please wait', 'shortcodes' ) . '">';
		// Check that galleries is set
		if ( $created ) // Create options
			foreach ( $galleries as $g_id => $gallery ) {
				// Is this option selected
				$selected = ( $g_id == 0 ) ? ' selected="selected"' : '';
				// Prepare title
				$gallery['name'] = ( $gallery['name'] == '' ) ? __( 'Untitled gallery', 'shortcodes' ) : stripslashes( $gallery['name'] );
				// Create option
				$return .= '<option value="' . ( $g_id + 1 ) . '"' . $selected . '>' . $gallery['name'] . '</option>';
			}
		// Galleries not created
		else
			$return .= '<option value="0" selected>' . __( 'Galleries not found', 'shortcodes' ) . '</option>';
		$return .= '</select><small class="description"><a href="' . $shult->admin_url . '#tab-3" target="_blank">' . __( 'Manage galleries', 'shortcodes' ) . '</a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="sm-generator-reload-galleries">' . __( 'Reload galleries', 'shortcodes' ) . '</a></small>';
		return $return;
	}

	public static function number( $id, $field ) {
		$return = '<input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="sm-generator-attr" />';
		return $return;
	}

	public static function slider( $id, $field ) {
		$return = '<div class="sm-generator-range-picker sm-generator-clearfix"><input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="sm-generator-attr" /></div>';
		return $return;
	}

	public static function shadow( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', '0', '0', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$return = '<div class="sm-generator-shadow-picker"><span class="sm-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="sm-generator-sp-hoff" /><small>' . __( 'Horizontal offset', 'shortcodes' ) . ' (px)</small></span><span class="sm-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[1] . '" class="sm-generator-sp-voff" /><small>' . __( 'Vertical offset', 'shortcodes' ) . ' (px)</small></span><span class="sm-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[2] . '" class="sm-generator-sp-blur" /><small>' . __( 'Blur', 'shortcodes' ) . ' (px)</small></span><span class="sm-generator-shadow-picker-field sm-generator-shadow-picker-color"><span class="sm-generator-shadow-picker-color-wheel"></span><input type="text" value="' . $defaults[3] . '" class="sm-generator-shadow-picker-color-value" /><small>' . __( 'Color', 'shortcodes' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr" /></div>';
		return $return;
	}

	public static function border( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', 'solid', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$borders = Sm_Tools::select( array(
				'options' => Sm_Data::borders(),
				'class' => 'sm-generator-bp-style',
				'selected' => $defaults[1]
			) );
		$return = '<div class="sm-generator-border-picker"><span class="sm-generator-border-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="sm-generator-bp-width" /><small>' . __( 'Border width', 'shortcodes' ) . ' (px)</small></span><span class="sm-generator-border-picker-field">' . $borders . '<small>' . __( 'Border style', 'shortcodes' ) . '</small></span><span class="sm-generator-border-picker-field sm-generator-border-picker-color"><span class="sm-generator-border-picker-color-wheel"></span><input type="text" value="' . $defaults[2] . '" class="sm-generator-border-picker-color-value" /><small>' . __( 'Border color', 'shortcodes' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr" /></div>';
		return $return;
	}

	public static function image_source( $id, $field ) {
		$field = mn_parse_args( $field, array(
				'default' => 'none'
			) );
		$sources = Sm_Tools::select( array(
				'options'  => array(
					'media'         => __( 'Media library', 'shortcodes' ),
					'posts: recent' => __( 'Recent posts', 'shortcodes' ),
					'category'      => __( 'Category', 'shortcodes' ),
					'taxonomy'      => __( 'Taxonomy', 'shortcodes' )
				),
				'selected' => '0',
				'none'     => __( 'Select images source', 'shortcodes' ) . '&hellip;',
				'class'    => 'sm-generator-isp-sources'
			) );
		$categories = Sm_Tools::select( array(
				'options'  => Sm_Tools::get_terms( 'category' ),
				'multiple' => true,
				'size'     => 10,
				'class'    => 'sm-generator-isp-categories'
			) );
		$taxonomies = Sm_Tools::select( array(
				'options'  => Sm_Tools::get_taxonomies(),
				'none'     => __( 'Select taxonomy', 'shortcodes' ) . '&hellip;',
				'selected' => '0',
				'class'    => 'sm-generator-isp-taxonomies'
			) );
		$terms = Sm_Tools::select( array(
				'class'    => 'sm-generator-isp-terms',
				'multiple' => true,
				'size'     => 10,
				'disabled' => true,
				'style'    => 'display:none'
			) );
		$return = '<div class="sm-generator-isp">' . $sources . '<div class="sm-generator-isp-source sm-generator-isp-source-media"><div class="sm-generator-clearfix"><a href="javascript:;" class="button button-primary sm-generator-isp-add-media"><i class="fa fa-plus"></i>&nbsp;&nbsp;' . __( 'Add images', 'shortcodes' ) . '</a></div><div class="sm-generator-isp-images sm-generator-clearfix"><em class="description">' . __( 'Click the button above and select images.<br>You can select multimple images with Ctrl (Cmd) key', 'shortcodes' ) . '</em></div></div><div class="sm-generator-isp-source sm-generator-isp-source-category"><em class="description">' . __( 'Select categories to retrieve posts from.<br>You can select multiple categories with Ctrl (Cmd) key', 'shortcodes' ) . '</em>' . $categories . '</div><div class="sm-generator-isp-source sm-generator-isp-source-taxonomy"><em class="description">' . __( 'Select taxonomy and it\'s terms.<br>You can select multiple terms with Ctrl (Cmd) key', 'shortcodes' ) . '</em>' . $taxonomies . $terms . '</div><input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="sm-generator-attr-' . $id . '" class="sm-generator-attr" /></div>';
		return $return;
	}

}
