<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * WPBakery Visual Composer shortcodes
 *
 * @package WPBakeryVisualComposer
 *
 */
class WPBakeryShortCode_VC_mn_Search extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Meta extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Recentcomments extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Calendar extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Pages extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Tagcloud extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Custommenu extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Text extends WPBakeryShortCode {
	/**
	 * This actually fixes #1537 by converting 'text' to 'content'
	 * @since 4.4
	 *
	 * @param $atts
	 *
	 * @return mixed
	 */
	public static function convertTextAttributeToContent( $atts ) {
		if ( isset( $atts['text'] ) ) {
			if ( ! isset( $atts['content'] ) || empty( $atts['content'] ) ) {
				$atts['content'] = $atts['text'];
			}
		}

		return $atts;
	}
}

class WPBakeryShortCode_VC_mn_Posts extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Links extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Categories extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Archives extends WPBakeryShortCode {
}

class WPBakeryShortCode_VC_mn_Rss extends WPBakeryShortCode {
}
