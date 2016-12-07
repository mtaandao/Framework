<?php
/**
 * Class for managing plugin data
 */
class Sm_Data {

	/**
	 * Constructor
	 */
	function __construct() {}

	/**
	 * Shortcode groups
	 */
	public static function groups() {
		return apply_filters( 'sm/data/groups', array(
				'all'     => __( 'All', 'shortcodes' ),
				'content' => __( 'Content', 'shortcodes' ),
				'box'     => __( 'Box', 'shortcodes' ),
				'media'   => __( 'Media', 'shortcodes' ),
				'gallery' => __( 'Gallery', 'shortcodes' ),
				'data'    => __( 'Data', 'shortcodes' ),
				'other'   => __( 'Other', 'shortcodes' )
			) );
	}

	/**
	 * Border styles
	 */
	public static function borders() {
		return apply_filters( 'sm/data/borders', array(
				'none'   => __( 'None', 'shortcodes' ),
				'solid'  => __( 'Solid', 'shortcodes' ),
				'dotted' => __( 'Dotted', 'shortcodes' ),
				'dashed' => __( 'Dashed', 'shortcodes' ),
				'double' => __( 'Double', 'shortcodes' ),
				'groove' => __( 'Groove', 'shortcodes' ),
				'ridge'  => __( 'Ridge', 'shortcodes' )
			) );
	}

	/**
	 * Font-Awesome icons
	 */
	public static function icons() {
		return apply_filters( 'sm/data/icons', array( 'adjust', 'adn', 'align-center', 'align-justify', 'align-left', 'align-right', 'ambulance', 'anchor', 'android', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'apple', 'archive', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'asterisk', 'automobile', 'backward', 'ban', 'bank', 'bar-chart-o', 'barcode', 'bars', 'beer', 'behance', 'behance-square', 'bell', 'bell-o', 'bitbucket', 'bitbucket-square', 'bitcoin', 'bold', 'bolt', 'bomb', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'btc', 'bug', 'building', 'building-o', 'bullhorn', 'bullseye', 'cab', 'calendar', 'calendar-o', 'camera', 'camera-retro', 'car', 'caret-down', 'caret-left', 'caret-right', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'caret-up', 'certificate', 'chain', 'chain-broken', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'child', 'circle', 'circle-o', 'circle-o-notch', 'circle-thin', 'clipboard', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload', 'cny', 'code', 'code-fork', 'codepen', 'coffee', 'cog', 'cogs', 'columns', 'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'compress', 'copy', 'credit-card', 'crop', 'crosshairs', 'css3', 'cube', 'cubes', 'cut', 'cutlery', 'dashboard', 'database', 'dedent', 'delicious', 'desktop', 'deviantart', 'digg', 'dollar', 'dot-circle-o', 'download', 'dribbble', 'dropbox', 'drupal', 'edit', 'eject', 'ellipsis-h', 'ellipsis-v', 'empire', 'envelope', 'envelope-o', 'envelope-square', 'eraser', 'eur', 'euro', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'expand', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'facebook', 'facebook-square', 'fast-backward', 'fast-forward', 'fax', 'female', 'fighter-jet', 'file', 'file-archive-o', 'file-audio-o', 'file-code-o', 'file-excel-o', 'file-image-o', 'file-movie-o', 'file-o', 'file-pdf-o', 'file-photo-o', 'file-picture-o', 'file-powerpoint-o', 'file-sound-o', 'file-text', 'file-text-o', 'file-video-o', 'file-word-o', 'file-zip-o', 'files-o', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'flickr', 'floppy-o', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'font', 'forward', 'foursquare', 'frown-o', 'gamepad', 'gavel', 'gbp', 'ge', 'gear', 'gears', 'gift', 'git', 'git-square', 'github', 'github-alt', 'github-square', 'gittip', 'glass', 'globe', 'google', 'google-plus', 'google-plus-square', 'graduation-cap', 'group', 'h-square', 'hacker-news', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hdd-o', 'header', 'headphones', 'heart', 'heart-o', 'history', 'home', 'hospital-o', 'html5', 'image', 'inbox', 'indent', 'info', 'info-circle', 'inr', 'instagram', 'institution', 'italic', 'joomla', 'jpy', 'jsfiddle', 'key', 'keyboard-o', 'krw', 'language', 'laptop', 'leaf', 'legal', 'lemon-o', 'level-down', 'level-up', 'life-bouy', 'life-ring', 'life-saver', 'lightbulb-o', 'link', 'linkedin', 'linkedin-square', 'linux', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'magic', 'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'maxcdn', 'medkit', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'mortar-board', 'music', 'navicon', 'openid', 'outdent', 'pagelines', 'paper-plane', 'paper-plane-o', 'paperclip', 'paragraph', 'paste', 'pause', 'paw', 'pencil', 'pencil-square', 'pencil-square-o', 'phone', 'phone-square', 'photo', 'picture-o', 'pied-piper', 'pied-piper-alt', 'pied-piper-square', 'pinterest', 'pinterest-square', 'plane', 'play', 'play-circle', 'play-circle-o', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qq', 'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'ra', 'random', 'rebel', 'recycle', 'reddit', 'reddit-square', 'refresh', 'renren', 'reorder', 'repeat', 'reply', 'reply-all', 'retweet', 'rmb', 'road', 'rocket', 'rotate-left', 'rotate-right', 'rouble', 'rss', 'rss-square', 'rub', 'ruble', 'rupee', 'save', 'scissors', 'search', 'search-minus', 'search-plus', 'send', 'send-o', 'share', 'share-alt', 'share-alt-square', 'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal', 'sitemap', 'skype', 'slack', 'sliders', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up', 'soundcloud', 'space-shuttle', 'spinner', 'spoon', 'spotify', 'square', 'square-o', 'stack-exchange', 'stack-overflow', 'star', 'star-half', 'star-half-empty', 'star-half-full', 'star-half-o', 'star-o', 'steam', 'steam-square', 'step-backward', 'step-forward', 'stethoscope', 'stop', 'strikethrough', 'stumbleupon', 'stumbleupon-circle', 'subscript', 'suitcase', 'sun-o', 'superscript', 'support', 'table', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'taxi', 'tencent-weibo', 'terminal', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'trash-o', 'tree', 'trello', 'trophy', 'truck', 'try', 'tumblr', 'tumblr-square', 'turkish-lira', 'twitter', 'twitter-square', 'umbrella', 'underline', 'undo', 'university', 'unlink', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'usd', 'user', 'user-md', 'users', 'video-camera', 'vimeo-square', 'vine', 'vk', 'volume-down', 'volume-off', 'volume-up', 'warning', 'wechat', 'weibo', 'weixin', 'wheelchair', 'windows', 'won', 'Mtaandao', 'wrench', 'xing', 'xing-square', 'yahoo', 'yen', 'youtube', 'youtube-play', 'youtube-square' ) );
	}

	/**
	 * Animate.css animations
	 */
	public static function animations() {
		return apply_filters( 'sm/data/animations', array( 'flash', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse', 'flip', 'flipInX', 'flipOutX', 'flipInY', 'flipOutY', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig', 'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutUpBig', 'fadeOutDownBig', 'fadeOutLeftBig', 'fadeOutRightBig', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutLeft', 'slideOutRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'lightSpeedIn', 'lightSpeedOut', 'hinge', 'rollIn', 'rollOut' ) );
	}

	/**
	 * Examples section
	 */
	public static function examples() {
		return apply_filters( 'sm/data/examples', array(
				'basic' => array(
					'title' => __( 'Basic examples', 'shortcodes' ),
					'items' => array(
						array(
							'name' => __( 'Accordions, spoilers, different styles, anchors', 'shortcodes' ),
							'id'   => 'spoilers',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/spoilers.example',
							'icon' => 'tasks'
						),
						array(
							'name' => __( 'Tabs, vertical tabs, tab anchors', 'shortcodes' ),
							'id'   => 'tabs',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/tabs.example',
							'icon' => 'folder'
						),
						array(
							'name' => __( 'Column layouts', 'shortcodes' ),
							'id'   => 'columns',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/columns.example',
							'icon' => 'th-large'
						),
						array(
							'name' => __( 'Media elements, YouTube, Vimeo, Screenr and self-hosted videos, audio player', 'shortcodes' ),
							'id'   => 'media',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/media.example',
							'icon' => 'play-circle'
						),
						array(
							'name' => __( 'Unlimited buttons', 'shortcodes' ),
							'id'   => 'buttons',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/buttons.example',
							'icon' => 'heart'
						),
						array(
							'name' => __( 'Animations', 'shortcodes' ),
							'id'   => 'animations',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/animations.example',
							'icon' => 'bolt'
						),
					)
				),
				'advanced' => array(
					'title' => __( 'Advanced examples', 'shortcodes' ),
					'items' => array(
						array(
							'name' => __( 'Interacting with posts shortcode', 'shortcodes' ),
							'id' => 'posts',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/posts.example',
							'icon' => 'list'
						),
						array(
							'name' => __( 'Nested shortcodes, shortcodes inside of attributes', 'shortcodes' ),
							'id' => 'nested',
							'code' => plugin_dir_path( SM_PLUGIN_FILE ) . '/inc/examples/nested.example',
							'icon' => 'indent'
						),
					)
				),
			) );
	}

	/**
	 * Shortcodes
	 */
	public static function shortcodes( $shortcode = false ) {
		$shortcodes = apply_filters( 'sm/data/shortcodes', array(
				// heading
				'heading' => array(
					'name' => __( 'Heading', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ),
							'desc' => __( 'Choose style for this heading', 'shortcodes' ) . '%sm_skins_link%'
						),
						'size' => array(
							'type' => 'slider',
							'min' => 7,
							'max' => 48,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Size', 'shortcodes' ),
							'desc' => __( 'Select heading size (pixels)', 'shortcodes' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'shortcodes' ),
								'center' => __( 'Center', 'shortcodes' ),
								'right' => __( 'Right', 'shortcodes' )
							),
							'default' => 'center',
							'name' => __( 'Align', 'shortcodes' ),
							'desc' => __( 'Heading text alignment', 'shortcodes' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Margin', 'shortcodes' ),
							'desc' => __( 'Bottom margin (pixels)', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Heading text', 'shortcodes' ),
					'desc' => __( 'Styled heading', 'shortcodes' ),
					'icon' => 'h-square'
				),
				// tabs
				'tabs' => array(
					'name' => __( 'Tabs', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ),
							'desc' => __( 'Choose style for this tabs', 'shortcodes' ) . '%sm_skins_link%'
						),
						'active' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Active tab', 'shortcodes' ),
							'desc' => __( 'Select which tab is open by default', 'shortcodes' )
						),
						'vertical' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Vertical', 'shortcodes' ),
							'desc' => __( 'Show tabs vertically', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( "[%prefix_tab title=\"Title 1\"]Content 1[/%prefix_tab]\n[%prefix_tab title=\"Title 2\"]Content 2[/%prefix_tab]\n[%prefix_tab title=\"Title 3\"]Content 3[/%prefix_tab]", 'shortcodes' ),
					'desc' => __( 'Tabs container', 'shortcodes' ),
					'example' => 'tabs',
					'icon' => 'list-alt'
				),
				// tab
				'tab' => array(
					'name' => __( 'Tab', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Tab name', 'shortcodes' ),
							'name' => __( 'Title', 'shortcodes' ),
							'desc' => __( 'Enter tab name', 'shortcodes' )
						),
						'disabled' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Disabled', 'shortcodes' ),
							'desc' => __( 'Is this tab disabled', 'shortcodes' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'shortcodes' ),
							'desc' => __( 'You can use unique anchor for this tab to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This tab will be activated and scrolled in', 'shortcodes' )
						),
						'url' => array(
							'default' => '',
							'name' => __( 'URL', 'shortcodes' ),
							'desc' => __( 'You can link this tab to any webpage. Enter here full URL to switch this tab into link', 'shortcodes' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self'  => __( 'Open link in same window/tab', 'shortcodes' ),
								'blank' => __( 'Open link in new window/tab', 'shortcodes' )
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'shortcodes' ),
							'desc' => __( 'Choose how to open the custom tab link', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Tab content', 'shortcodes' ),
					'desc' => __( 'Single tab', 'shortcodes' ),
					'note' => __( 'Did you know that you need to wrap single tabs with [tabs] shortcode?', 'shortcodes' ),
					'example' => 'tabs',
					'icon' => 'list-alt'
				),
				// spoiler
				'spoiler' => array(
					'name' => __( 'Spoiler', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Spoiler title', 'shortcodes' ),
							'name' => __( 'Title', 'shortcodes' ), 'desc' => __( 'Text in spoiler title', 'shortcodes' )
						),
						'open' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Open', 'shortcodes' ),
							'desc' => __( 'Is spoiler content visible by default', 'shortcodes' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
								'fancy' => __( 'Fancy', 'shortcodes' ),
								'simple' => __( 'Simple', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ),
							'desc' => __( 'Choose style for this spoiler', 'shortcodes' ) . '%sm_skins_link%'
						),
						'icon' => array(
							'type' => 'select',
							'values' => array(
								'plus'           => __( 'Plus', 'shortcodes' ),
								'plus-circle'    => __( 'Plus circle', 'shortcodes' ),
								'plus-square-1'  => __( 'Plus square 1', 'shortcodes' ),
								'plus-square-2'  => __( 'Plus square 2', 'shortcodes' ),
								'arrow'          => __( 'Arrow', 'shortcodes' ),
								'arrow-circle-1' => __( 'Arrow circle 1', 'shortcodes' ),
								'arrow-circle-2' => __( 'Arrow circle 2', 'shortcodes' ),
								'chevron'        => __( 'Chevron', 'shortcodes' ),
								'chevron-circle' => __( 'Chevron circle', 'shortcodes' ),
								'caret'          => __( 'Caret', 'shortcodes' ),
								'caret-square'   => __( 'Caret square', 'shortcodes' ),
								'folder-1'       => __( 'Folder 1', 'shortcodes' ),
								'folder-2'       => __( 'Folder 2', 'shortcodes' )
							),
							'default' => 'plus',
							'name' => __( 'Icon', 'shortcodes' ),
							'desc' => __( 'Icons for spoiler', 'shortcodes' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'shortcodes' ),
							'desc' => __( 'You can use unique anchor for this spoiler to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This spoiler will be open and scrolled in', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Hidden content', 'shortcodes' ),
					'desc' => __( 'Spoiler with hidden content', 'shortcodes' ),
					'note' => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'shortcodes' ),
					'example' => 'spoilers',
					'icon' => 'list-ul'
				),
				// accordion
				'accordion' => array(
					'name' => __( 'Accordion', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( "[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]", 'shortcodes' ),
					'desc' => __( 'Accordion with spoilers', 'shortcodes' ),
					'note' => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'shortcodes' ),
					'example' => 'spoilers',
					'icon' => 'list'
				),
				// divider
				'divider' => array(
					'name' => __( 'Divider', 'shortcodes' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'top' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show TOP link', 'shortcodes' ),
							'desc' => __( 'Show link to top of the page or not', 'shortcodes' )
						),
						'text' => array(
							'values' => array( ),
							'default' => __( 'Go to top', 'shortcodes' ),
							'name' => __( 'Link text', 'shortcodes' ), 'desc' => __( 'Text for the GO TOP link', 'shortcodes' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
								'dotted'  => __( 'Dotted', 'shortcodes' ),
								'dashed'  => __( 'Dashed', 'shortcodes' ),
								'double'  => __( 'Double', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ),
							'desc' => __( 'Choose style for this divider', 'shortcodes' )
						),
						'divider_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#999999',
							'name' => __( 'Divider color', 'shortcodes' ),
							'desc' => __( 'Pick the color for divider', 'shortcodes' )
						),
						'link_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#999999',
							'name' => __( 'Link color', 'shortcodes' ),
							'desc' => __( 'Pick the color for TOP link', 'shortcodes' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 40,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'shortcodes' ),
							'desc' => __( 'Height of the divider (in pixels)', 'shortcodes' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 5,
							'default' => 15,
							'name' => __( 'Margin', 'shortcodes' ),
							'desc' => __( 'Adjust the top and bottom margins of this divider (in pixels)', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Content divider with optional TOP link', 'shortcodes' ),
					'icon' => 'ellipsis-h'
				),
				// spacer
				'spacer' => array(
					'name' => __( 'Spacer', 'shortcodes' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 800,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Height of the spacer in pixels', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Empty space with adjustable height', 'shortcodes' ),
					'icon' => 'arrows-v'
				),
				// highlight
				'highlight' => array(
					'name' => __( 'Highlight', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#DDFF99',
							'name' => __( 'Background', 'shortcodes' ),
							'desc' => __( 'Highlighted text background color', 'shortcodes' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#000000',
							'name' => __( 'Text color', 'shortcodes' ), 'desc' => __( 'Highlighted text color', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Highlighted text', 'shortcodes' ),
					'desc' => __( 'Highlighted text', 'shortcodes' ),
					'icon' => 'pencil'
				),
				// label
				'label' => array(
					'name' => __( 'Label', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
								'success' => __( 'Success', 'shortcodes' ),
								'warning' => __( 'Warning', 'shortcodes' ),
								'important' => __( 'Important', 'shortcodes' ),
								'black' => __( 'Black', 'shortcodes' ),
								'info' => __( 'Info', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Type', 'shortcodes' ),
							'desc' => __( 'Style of the label', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Label', 'shortcodes' ),
					'desc' => __( 'Styled label', 'shortcodes' ),
					'icon' => 'tag'
				),
				// quote
				'quote' => array(
					'name' => __( 'Quote', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ),
							'desc' => __( 'Choose style for this quote', 'shortcodes' ) . '%sm_skins_link%'
						),
						'cite' => array(
							'default' => '',
							'name' => __( 'Cite', 'shortcodes' ),
							'desc' => __( 'Quote author name', 'shortcodes' )
						),
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Cite url', 'shortcodes' ),
							'desc' => __( 'Url of the quote author. Leave empty to disable link', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Quote', 'shortcodes' ),
					'desc' => __( 'Blockquote alternative', 'shortcodes' ),
					'icon' => 'quote-right'
				),
				// pullquote
				'pullquote' => array(
					'name' => __( 'Pullquote', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'shortcodes' ),
								'right' => __( 'Right', 'shortcodes' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'shortcodes' ), 'desc' => __( 'Pullquote alignment (float)', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Pullquote', 'shortcodes' ),
					'desc' => __( 'Pullquote', 'shortcodes' ),
					'icon' => 'quote-left'
				),
				// dropcap
				'dropcap' => array(
					'name' => __( 'Dropcap', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
								'flat' => __( 'Flat', 'shortcodes' ),
								'light' => __( 'Light', 'shortcodes' ),
								'simple' => __( 'Simple', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ), 'desc' => __( 'Dropcap style preset', 'shortcodes' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 5,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'shortcodes' ),
							'desc' => __( 'Choose dropcap size', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'D', 'shortcodes' ),
					'desc' => __( 'Dropcap', 'shortcodes' ),
					'icon' => 'bold'
				),
				// frame
				'frame' => array(
					'name' => __( 'Frame', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'shortcodes' ),
								'center' => __( 'Center', 'shortcodes' ),
								'right' => __( 'Right', 'shortcodes' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'shortcodes' ),
							'desc' => __( 'Frame alignment', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => '<img src="http://lorempixel.com/g/400/200/" />',
					'desc' => __( 'Styled image frame', 'shortcodes' ),
					'icon' => 'picture-o'
				),
				// row
				'row' => array(
					'name' => __( 'Row', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( "[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]", 'shortcodes' ),
					'desc' => __( 'Row for flexible columns', 'shortcodes' ),
					'icon' => 'columns'
				),
				// column
				'column' => array(
					'name' => __( 'Column', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'1/1' => __( 'Full width', 'shortcodes' ),
								'1/2' => __( 'One half', 'shortcodes' ),
								'1/3' => __( 'One third', 'shortcodes' ),
								'2/3' => __( 'Two third', 'shortcodes' ),
								'1/4' => __( 'One fourth', 'shortcodes' ),
								'3/4' => __( 'Three fourth', 'shortcodes' ),
								'1/5' => __( 'One fifth', 'shortcodes' ),
								'2/5' => __( 'Two fifth', 'shortcodes' ),
								'3/5' => __( 'Three fifth', 'shortcodes' ),
								'4/5' => __( 'Four fifth', 'shortcodes' ),
								'1/6' => __( 'One sixth', 'shortcodes' ),
								'5/6' => __( 'Five sixth', 'shortcodes' )
							),
							'default' => '1/2',
							'name' => __( 'Size', 'shortcodes' ),
							'desc' => __( 'Select column width. This width will be calculated depend page width', 'shortcodes' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'shortcodes' ),
							'desc' => __( 'Is this column centered on the page', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Column content', 'shortcodes' ),
					'desc' => __( 'Flexible and responsive columns', 'shortcodes' ),
					'note' => __( 'Did you know that you need to wrap columns with [row] shortcode?', 'shortcodes' ),
					'example' => 'columns',
					'icon' => 'columns'
				),
				// list
				'list' => array(
					'name' => __( 'List', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'shortcodes' ),
							'desc' => __( 'You can upload custom icon for this list or pick a built-in icon', 'shortcodes' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'shortcodes' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( "<ul>\n<li>List item</li>\n<li>List item</li>\n<li>List item</li>\n</ul>", 'shortcodes' ),
					'desc' => __( 'Styled unordered list', 'shortcodes' ),
					'icon' => 'list-ol'
				),
				// button
				'button' => array(
					'name' => __( 'Button', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'shortcodes' ),
							'desc' => __( 'Button link', 'shortcodes' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'shortcodes' ),
								'blank' => __( 'New tab', 'shortcodes' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'shortcodes' ),
							'desc' => __( 'Button link target', 'shortcodes' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
								'flat' => __( 'Flat', 'shortcodes' ),
								'ghost' => __( 'Ghost', 'shortcodes' ),
								'soft' => __( 'Soft', 'shortcodes' ),
								'glass' => __( 'Glass', 'shortcodes' ),
								'bubbles' => __( 'Bubbles', 'shortcodes' ),
								'noise' => __( 'Noise', 'shortcodes' ),
								'stroked' => __( 'Stroked', 'shortcodes' ),
								'3d' => __( '3D', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ), 'desc' => __( 'Button background style preset', 'shortcodes' )
						),
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#2D89EF',
							'name' => __( 'Background', 'shortcodes' ), 'desc' => __( 'Button background color', 'shortcodes' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'shortcodes' ),
							'desc' => __( 'Button text color', 'shortcodes' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'shortcodes' ),
							'desc' => __( 'Button size', 'shortcodes' )
						),
						'wide' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Fluid', 'shortcodes' ), 'desc' => __( 'Fluid buttons has 100% width', 'shortcodes' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'shortcodes' ), 'desc' => __( 'Is button centered on the page', 'shortcodes' )
						),
						'radius' => array(
							'type' => 'select',
							'values' => array(
								'auto' => __( 'Auto', 'shortcodes' ),
								'round' => __( 'Round', 'shortcodes' ),
								'0' => __( 'Square', 'shortcodes' ),
								'5' => '5px',
								'10' => '10px',
								'20' => '20px'
							),
							'default' => 'auto',
							'name' => __( 'Radius', 'shortcodes' ),
							'desc' => __( 'Radius of button corners. Auto-radius calculation based on button size', 'shortcodes' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'shortcodes' ),
							'desc' => __( 'You can upload custom icon for this button or pick a built-in icon', 'shortcodes' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Icon color', 'shortcodes' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'shortcodes' )
						),
						'text_shadow' => array(
							'type' => 'shadow',
							'default' => 'none',
							'name' => __( 'Text shadow', 'shortcodes' ),
							'desc' => __( 'Button text shadow', 'shortcodes' )
						),
						'desc' => array(
							'default' => '',
							'name' => __( 'Description', 'shortcodes' ),
							'desc' => __( 'Small description under button text. This option is incompatible with icon.', 'shortcodes' )
						),
						'onclick' => array(
							'default' => '',
							'name' => __( 'onClick', 'shortcodes' ),
							'desc' => __( 'Advanced JavaScript code for onClick action', 'shortcodes' )
						),
						'rel' => array(
							'default' => '',
							'name' => __( 'Rel attribute', 'shortcodes' ),
							'desc' => __( 'Here you can add value for the rel attribute.<br>Example values: <b%value>nofollow</b>, <b%value>lightbox</b>', 'shortcodes' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Title attribute', 'shortcodes' ),
							'desc' => __( 'Here you can add value for the title attribute', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Button text', 'shortcodes' ),
					'desc' => __( 'Styled button', 'shortcodes' ),
					'example' => 'buttons',
					'icon' => 'heart'
				),
				// service
				'service' => array(
					'name' => __( 'Service', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Service title', 'shortcodes' ),
							'name' => __( 'Title', 'shortcodes' ),
							'desc' => __( 'Service name', 'shortcodes' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'shortcodes' ),
							'desc' => __( 'You can upload custom icon for this box', 'shortcodes' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'shortcodes' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'shortcodes' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 128,
							'step' => 2,
							'default' => 32,
							'name' => __( 'Icon size', 'shortcodes' ),
							'desc' => __( 'Size of the uploaded icon in pixels', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Service description', 'shortcodes' ),
					'desc' => __( 'Service box with title', 'shortcodes' ),
					'icon' => 'check-square-o'
				),
				// box
				'box' => array(
					'name' => __( 'Box', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Box title', 'shortcodes' ),
							'name' => __( 'Title', 'shortcodes' ), 'desc' => __( 'Text for the box title', 'shortcodes' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
								'soft' => __( 'Soft', 'shortcodes' ),
								'glass' => __( 'Glass', 'shortcodes' ),
								'bubbles' => __( 'Bubbles', 'shortcodes' ),
								'noise' => __( 'Noise', 'shortcodes' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'shortcodes' ),
							'desc' => __( 'Box style preset', 'shortcodes' )
						),
						'box_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Color', 'shortcodes' ),
							'desc' => __( 'Color for the box title and borders', 'shortcodes' )
						),
						'title_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Title text color', 'shortcodes' ), 'desc' => __( 'Color for the box title text', 'shortcodes' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'shortcodes' ),
							'desc' => __( 'Box corners radius', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Box content', 'shortcodes' ),
					'desc' => __( 'Colored box with caption', 'shortcodes' ),
					'icon' => 'list-alt'
				),
				// note
				'note' => array(
					'name' => __( 'Note', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'note_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFF66',
							'name' => __( 'Background', 'shortcodes' ), 'desc' => __( 'Note background color', 'shortcodes' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'shortcodes' ),
							'desc' => __( 'Note text color', 'shortcodes' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'shortcodes' ), 'desc' => __( 'Note corners radius', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Note text', 'shortcodes' ),
					'desc' => __( 'Colored box', 'shortcodes' ),
					'icon' => 'list-alt'
				),
				// expand
				'expand' => array(
					'name' => __( 'Expand', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'more_text' => array(
							'default' => __( 'Show more', 'shortcodes' ),
							'name' => __( 'More text', 'shortcodes' ),
							'desc' => __( 'Enter the text for more link', 'shortcodes' )
						),
						'less_text' => array(
							'default' => __( 'Show less', 'shortcodes' ),
							'name' => __( 'Less text', 'shortcodes' ),
							'desc' => __( 'Enter the text for less link', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 1000,
							'step' => 10,
							'default' => 100,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Height for collapsed state (in pixels)', 'shortcodes' )
						),
						'hide_less' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Hide less link', 'shortcodes' ),
							'desc' => __( 'This option allows you to hide less link, when the text block has been expanded', 'shortcodes' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'shortcodes' ),
							'desc' => __( 'Pick the text color', 'shortcodes' )
						),
						'link_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#0088FF',
							'name' => __( 'Link color', 'shortcodes' ),
							'desc' => __( 'Pick the link color', 'shortcodes' )
						),
						'link_style' => array(
							'type' => 'select',
							'values' => array(
								'default'    => __( 'Default', 'shortcodes' ),
								'underlined' => __( 'Underlined', 'shortcodes' ),
								'dotted'     => __( 'Dotted', 'shortcodes' ),
								'dashed'     => __( 'Dashed', 'shortcodes' ),
								'button'     => __( 'Button', 'shortcodes' ),
							),
							'default' => 'default',
							'name' => __( 'Link style', 'shortcodes' ),
							'desc' => __( 'Select the style for more/less link', 'shortcodes' )
						),
						'link_align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'shortcodes' ),
								'center' => __( 'Center', 'shortcodes' ),
								'right' => __( 'Right', 'shortcodes' ),
							),
							'default' => 'left',
							'name' => __( 'Link align', 'shortcodes' ),
							'desc' => __( 'Select link alignment', 'shortcodes' )
						),
						'more_icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'More icon', 'shortcodes' ),
							'desc' => __( 'Add an icon to the more link', 'shortcodes' )
						),
						'less_icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Less icon', 'shortcodes' ),
							'desc' => __( 'Add an icon to the less link', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'This text block can be expanded', 'shortcodes' ),
					'desc' => __( 'Expandable text block', 'shortcodes' ),
					'icon' => 'sort-amount-asc'
				),
				// lightbox
				'lightbox' => array(
					'name' => __( 'Lightbox', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'gallery',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'iframe' => __( 'Iframe', 'shortcodes' ),
								'image' => __( 'Image', 'shortcodes' ),
								'inline' => __( 'Inline (html content)', 'shortcodes' )
							),
							'default' => 'iframe',
							'name' => __( 'Content type', 'shortcodes' ),
							'desc' => __( 'Select type of the lightbox window content', 'shortcodes' )
						),
						'src' => array(
							'default' => '',
							'name' => __( 'Content source', 'shortcodes' ),
							'desc' => __( 'Insert here URL or CSS selector. Use URL for Iframe and Image content types. Use CSS selector for Inline content type.<br />Example values:<br /><b%value>http://www.youtube.com/watch?v=XXXXXXXXX</b> - YouTube video (iframe)<br /><b%value>http://example.com/mn-content/uploads/image.jpg</b> - uploaded image (image)<br /><b%value>http://example.com/</b> - any web page (iframe)<br /><b%value>#my-custom-popup</b> - any HTML content (inline)', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( '[%prefix_button] Click Here to Watch the Video [/%prefix_button]', 'shortcodes' ),
					'desc' => __( 'Lightbox window with custom content', 'shortcodes' ),
					'icon' => 'external-link'
				),
				// lightbox content
				'lightbox_content' => array(
					'name' => __( 'Lightbox content', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'gallery',
					'atts' => array(
						'id' => array(
							'default' => '',
							'name' => __( 'ID', 'shortcodes' ),
							'desc' => sprintf( __( 'Enter here the ID from Content source field. %s Example value: %s', 'shortcodes' ), '<br>', '<b%value>my-custom-popup</b>' )
						),
						'width' => array(
							'default' => '50%',
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => sprintf( __( 'Adjust the width for inline content (in pixels or percents). %s Example values: %s, %s, %s', 'shortcodes' ), '<br>', '<b%value>300px</b>', '<b%value>600px</b>', '<b%value>90%</b>' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 600,
							'step' => 5,
							'default' => 40,
							'name' => __( 'Margin', 'shortcodes' ),
							'desc' => __( 'Adjust the margin for inline content (in pixels)', 'shortcodes' )
						),
						'padding' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 600,
							'step' => 5,
							'default' => 40,
							'name' => __( 'Padding', 'shortcodes' ),
							'desc' => __( 'Adjust the padding for inline content (in pixels)', 'shortcodes' )
						),
						'text_align' => array(
							'type' => 'select',
							'values' => array(
								'left'   => __( 'Left', 'shortcodes' ),
								'center' => __( 'Center', 'shortcodes' ),
								'right'  => __( 'Right', 'shortcodes' )
							),
							'default' => 'center',
							'name' => __( 'Text alignment', 'shortcodes' ),
							'desc' => __( 'Select the text alignment', 'shortcodes' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Background color', 'shortcodes' ),
							'desc' => __( 'Pick a background color', 'shortcodes' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'shortcodes' ),
							'desc' => __( 'Pick a text color', 'shortcodes' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Text color', 'shortcodes' ),
							'desc' => __( 'Pick a text color', 'shortcodes' )
						),
						'shadow' => array(
							'type' => 'shadow',
							'default' => '0px 0px 15px #333333',
							'name' => __( 'Shadow', 'shortcodes' ),
							'desc' => __( 'Adjust the shadow for content box', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Inline content', 'shortcodes' ),
					'desc' => __( 'Inline content for lightbox', 'shortcodes' ),
					'icon' => 'external-link'
				),
				// tooltip
				'tooltip' => array(
					'name' => __( 'Tooltip', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'light' => __( 'Basic: Light', 'shortcodes' ),
								'dark' => __( 'Basic: Dark', 'shortcodes' ),
								'yellow' => __( 'Basic: Yellow', 'shortcodes' ),
								'green' => __( 'Basic: Green', 'shortcodes' ),
								'red' => __( 'Basic: Red', 'shortcodes' ),
								'blue' => __( 'Basic: Blue', 'shortcodes' ),
								'youtube' => __( 'Youtube', 'shortcodes' ),
								'tipsy' => __( 'Tipsy', 'shortcodes' ),
								'bootstrap' => __( 'Bootstrap', 'shortcodes' ),
								'jtools' => __( 'jTools', 'shortcodes' ),
								'tipped' => __( 'Tipped', 'shortcodes' ),
								'cluetip' => __( 'Cluetip', 'shortcodes' ),
							),
							'default' => 'yellow',
							'name' => __( 'Style', 'shortcodes' ),
							'desc' => __( 'Tooltip window style', 'shortcodes' )
						),
						'position' => array(
							'type' => 'select',
							'values' => array(
								'north' => __( 'Top', 'shortcodes' ),
								'south' => __( 'Bottom', 'shortcodes' ),
								'west' => __( 'Left', 'shortcodes' ),
								'east' => __( 'Right', 'shortcodes' )
							),
							'default' => 'top',
							'name' => __( 'Position', 'shortcodes' ),
							'desc' => __( 'Tooltip position', 'shortcodes' )
						),
						'shadow' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Shadow', 'shortcodes' ),
							'desc' => __( 'Add shadow to tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'shortcodes' )
						),
						'rounded' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Rounded corners', 'shortcodes' ),
							'desc' => __( 'Use rounded for tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'shortcodes' )
						),
						'size' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'shortcodes' ),
								'1' => 1,
								'2' => 2,
								'3' => 3,
								'4' => 4,
								'5' => 5,
								'6' => 6,
							),
							'default' => 'default',
							'name' => __( 'Font size', 'shortcodes' ),
							'desc' => __( 'Tooltip font size', 'shortcodes' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Tooltip title', 'shortcodes' ),
							'desc' => __( 'Enter title for tooltip window. Leave this field empty to hide the title', 'shortcodes' )
						),
						'content' => array(
							'default' => __( 'Tooltip text', 'shortcodes' ),
							'name' => __( 'Tooltip content', 'shortcodes' ),
							'desc' => __( 'Enter tooltip content here', 'shortcodes' )
						),
						'behavior' => array(
							'type' => 'select',
							'values' => array(
								'hover' => __( 'Show and hide on mouse hover', 'shortcodes' ),
								'click' => __( 'Show and hide by mouse click', 'shortcodes' ),
								'always' => __( 'Always visible', 'shortcodes' )
							),
							'default' => 'hover',
							'name' => __( 'Behavior', 'shortcodes' ),
							'desc' => __( 'Select tooltip behavior', 'shortcodes' )
						),
						'close' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Close button', 'shortcodes' ),
							'desc' => __( 'Show close button', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( '[%prefix_button] Hover me to open tooltip [/%prefix_button]', 'shortcodes' ),
					'desc' => __( 'Tooltip window with custom content', 'shortcodes' ),
					'icon' => 'comment-o'
				),
				// private
				'private' => array(
					'name' => __( 'Private', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Private note text', 'shortcodes' ),
					'desc' => __( 'Private note for post authors', 'shortcodes' ),
					'icon' => 'lock'
				),
				// youtube
				'youtube' => array(
					'name' => __( 'YouTube', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'shortcodes' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Player width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Player height', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Play video automatically when page is loaded', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'YouTube video', 'shortcodes' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// youtube_advanced
				'youtube_advanced' => array(
					'name' => __( 'YouTube Advanced', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'shortcodes' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'shortcodes' )
						),
						'playlist' => array(
							'default' => '',
							'name' => __( 'Playlist', 'shortcodes' ),
							'desc' => __( 'Value is a comma-separated list of video IDs to play. If you specify a value, the first video that plays will be the VIDEO_ID specified in the URL path, and the videos specified in the playlist parameter will play thereafter', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Player width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Player height', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'shortcodes' )
						),
						'controls' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Hide controls', 'shortcodes' ),
								'yes' => __( '1 - Show controls', 'shortcodes' ),
								'alt' => __( '2 - Show controls when playback is started', 'shortcodes' )
							),
							'default' => 'yes',
							'name' => __( 'Controls', 'shortcodes' ),
							'desc' => __( 'This parameter indicates whether the video player controls will display', 'shortcodes' )
						),
						'autohide' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Do not hide controls', 'shortcodes' ),
								'yes' => __( '1 - Hide all controls on mouse out', 'shortcodes' ),
								'alt' => __( '2 - Hide progress bar on mouse out', 'shortcodes' )
							),
							'default' => 'alt',
							'name' => __( 'Autohide', 'shortcodes' ),
							'desc' => __( 'This parameter indicates whether the video controls will automatically hide after a video begins playing', 'shortcodes' )
						),
						'showinfo' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show title bar', 'shortcodes' ),
							'desc' => __( 'If you set the parameter value to NO, then the player will not display information like the video title and uploader before the video starts playing.', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Play video automatically when page is loaded', 'shortcodes' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'shortcodes' ),
							'desc' => __( 'Setting of YES will cause the player to play the initial video again and again', 'shortcodes' )
						),
						'rel' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Related videos', 'shortcodes' ),
							'desc' => __( 'This parameter indicates whether the player should show related videos when playback of the initial video ends', 'shortcodes' )
						),
						'fs' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show full-screen button', 'shortcodes' ),
							'desc' => __( 'Setting this parameter to NO prevents the fullscreen button from displaying', 'shortcodes' )
						),
						'modestbranding' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => 'modestbranding',
							'desc' => __( 'This parameter lets you use a YouTube player that does not show a YouTube logo. Set the parameter value to YES to prevent the YouTube logo from displaying in the control bar. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player', 'shortcodes' )
						),
						'design' => array(
							'type' => 'select',
							'values' => array(
								'dark' => __( 'Dark design', 'shortcodes' ),
								'light' => __( 'Light design', 'shortcodes' )
							),
							'default' => 'dark',
							'name' => __( 'design', 'shortcodes' ),
							'desc' => __( 'This parameter indicates whether the embedded player will display player controls (like a play button or volume control) within a dark or light control bar', 'shortcodes' )
						),
						'https' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Force HTTPS', 'shortcodes' ),
							'desc' => __( 'Use HTTPS in player iframe', 'shortcodes' )
						),
						'wmode' => array(
							'default' => '',
							'name'    => __( 'WMode', 'shortcodes' ),
							'desc'    => sprintf( __( 'Here you can specify wmode value for the embed URL. %s Example values: %s, %s', 'shortcodes' ), '<br>', '<b%value>transparent</b>', '<b%value>opaque</b>' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'YouTube video player with advanced settings', 'shortcodes' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// vimeo
				'vimeo' => array(
					'name' => __( 'Vimeo', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'shortcodes' ), 'desc' => __( 'Url of Vimeo page with video', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Player width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Player height', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Play video automatically when page is loaded', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Vimeo video', 'shortcodes' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// screenr
				'screenr' => array(
					'name' => __( 'Screenr', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'shortcodes' ),
							'desc' => __( 'Url of Screenr page with video', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Player width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Player height', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Screenr video', 'shortcodes' ),
					'icon' => 'youtube-play'
				),
				// dailymotion
				'dailymotion' => array(
					'name' => __( 'Dailymotion', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'shortcodes' ),
							'desc' => __( 'Url of Dailymotion page with video', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Player width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Player height', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Start the playback of the video automatically after the player load. May not work on some mobile OS versions', 'shortcodes' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#FFC300',
							'name' => __( 'Background color', 'shortcodes' ),
							'desc' => __( 'HTML color of the background of controls elements', 'shortcodes' )
						),
						'foreground' => array(
							'type' => 'color',
							'default' => '#F7FFFD',
							'name' => __( 'Foreground color', 'shortcodes' ),
							'desc' => __( 'HTML color of the foreground of controls elements', 'shortcodes' )
						),
						'highlight' => array(
							'type' => 'color',
							'default' => '#171D1B',
							'name' => __( 'Highlight color', 'shortcodes' ),
							'desc' => __( 'HTML color of the controls elements\' highlights', 'shortcodes' )
						),
						'logo' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show logo', 'shortcodes' ),
							'desc' => __( 'Allows to hide or show the Dailymotion logo', 'shortcodes' )
						),
						'quality' => array(
							'type' => 'select',
							'values' => array(
								'240'  => '240',
								'380'  => '380',
								'480'  => '480',
								'720'  => '720',
								'1080' => '1080'
							),
							'default' => '380',
							'name' => __( 'Quality', 'shortcodes' ),
							'desc' => __( 'Determines the quality that must be played by default if available', 'shortcodes' )
						),
						'related' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show related videos', 'shortcodes' ),
							'desc' => __( 'Show related videos at the end of the video', 'shortcodes' )
						),
						'info' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show video info', 'shortcodes' ),
							'desc' => __( 'Show videos info (title/author) on the start screen', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Dailymotion video', 'shortcodes' ),
					'icon' => 'youtube-play'
				),
				// audio
				'audio' => array(
					'name' => __( 'Audio', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'shortcodes' ),
							'desc' => __( 'Audio file url. Supported formats: mp3, ogg', 'shortcodes' )
						),
						'width' => array(
							'values' => array(),
							'default' => '100%',
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Player width. You can specify width in percents and player will be responsive. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Play file automatically when page is loaded', 'shortcodes' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'shortcodes' ),
							'desc' => __( 'Repeat when playback is ended', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Custom audio player', 'shortcodes' ),
					'example' => 'media',
					'icon' => 'play-circle'
				),
				// video
				'video' => array(
					'name' => __( 'Video', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'shortcodes' ),
							'desc' => __( 'Url to mp4/flv video-file', 'shortcodes' )
						),
						'poster' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Poster', 'shortcodes' ),
							'desc' => __( 'Url to poster image, that will be shown before playback', 'shortcodes' )
						),
						'title' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Title', 'shortcodes' ),
							'desc' => __( 'Player title', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Player width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Player height', 'shortcodes' )
						),
						'controls' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Controls', 'shortcodes' ),
							'desc' => __( 'Show player controls (play/pause etc.) or not', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Play file automatically when page is loaded', 'shortcodes' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'shortcodes' ),
							'desc' => __( 'Repeat when playback is ended', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Custom video player', 'shortcodes' ),
					'example' => 'media',
					'icon' => 'play-circle'
				),
				// table
				'table' => array(
					'name' => __( 'Table', 'shortcodes' ),
					'type' => 'mixed',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'CSV file', 'shortcodes' ),
							'desc' => __( 'Upload CSV file if you want to create HTML-table from file', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( "<table>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n</table>", 'shortcodes' ),
					'desc' => __( 'Styled table from HTML or CSV file', 'shortcodes' ),
					'icon' => 'table'
				),
				// prettylink
				'prettylink' => array(
					'name' => __( 'Prettylink', 'shortcodes' ),
					'type' => 'mixed',
					'group' => 'content other',
					'atts' => array(
						'id' => array(
							'values' => array( ), 'default' => 1,
							'name' => __( 'ID', 'shortcodes' ),
							'desc' => __( 'Post or page ID', 'shortcodes' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'shortcodes' ),
								'blank' => __( 'New tab', 'shortcodes' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'shortcodes' ),
							'desc' => __( 'Link target. blank - link will be opened in new window/tab', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => '',
					'desc' => __( 'Prettylink to specified post/page', 'shortcodes' ),
					'icon' => 'link'
				),
				// members
				'members' => array(
					'name' => __( 'Members', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'message' => array(
							'default' => __( 'This content is for registered users only. Please %login%.', 'shortcodes' ),
							'name' => __( 'Message', 'shortcodes' ), 'desc' => __( 'Message for not logged users', 'shortcodes' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#ffcc00',
							'name' => __( 'Box color', 'shortcodes' ), 'desc' => __( 'This color will applied only to box for not logged users', 'shortcodes' )
						),
						'login_text' => array(
							'default' => __( 'login', 'shortcodes' ),
							'name' => __( 'Login link text', 'shortcodes' ), 'desc' => __( 'Text for the login link', 'shortcodes' )
						),
						'login_url' => array(
							'default' => mn_login_url(),
							'name' => __( 'Login link url', 'shortcodes' ), 'desc' => __( 'Login link url', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Content for logged members', 'shortcodes' ),
					'desc' => __( 'Content for logged in members only', 'shortcodes' ),
					'icon' => 'lock'
				),
				// guests
				'guests' => array(
					'name' => __( 'Guests', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Content for guests', 'shortcodes' ),
					'desc' => __( 'Content for guests only', 'shortcodes' ),
					'icon' => 'user'
				),
				// feed
				'feed' => array(
					'name' => __( 'RSS Feed', 'shortcodes' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'shortcodes' ),
							'desc' => __( 'Url to RSS-feed', 'shortcodes' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Limit', 'shortcodes' ), 'desc' => __( 'Number of items to show', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Feed grabber', 'shortcodes' ),
					'icon' => 'rss'
				),
				// menu
				'menu' => array(
					'name' => __( 'Menu', 'shortcodes' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Menu name', 'shortcodes' ), 'desc' => __( 'Custom menu name. Ex: Main menu', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Custom menu by name', 'shortcodes' ),
					'icon' => 'bars'
				),
				// subpages
				'subpages' => array(
					'name' => __( 'Sub pages', 'shortcodes' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5 ), 'default' => 1,
							'name' => __( 'Depth', 'shortcodes' ),
							'desc' => __( 'Max depth level of children pages', 'shortcodes' )
						),
						'p' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Parent ID', 'shortcodes' ),
							'desc' => __( 'ID of the parent page. Leave blank to use current page', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'List of sub pages', 'shortcodes' ),
					'icon' => 'bars'
				),
				// siblings
				'siblings' => array(
					'name' => __( 'Siblings', 'shortcodes' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3 ), 'default' => 1,
							'name' => __( 'Depth', 'shortcodes' ),
							'desc' => __( 'Max depth level', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'List of cureent page siblings', 'shortcodes' ),
					'icon' => 'bars'
				),
				// document
				'document' => array(
					'name' => __( 'Document', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Url', 'shortcodes' ),
							'desc' => __( 'Url to uploaded document. Supported formats: doc, xls, pdf etc.', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Viewer width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Viewer height', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make viewer responsive', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Document viewer by Google', 'shortcodes' ),
					'icon' => 'file-text'
				),
				// gmap
				'gmap' => array(
					'name' => __( 'Gmap', 'shortcodes' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Map width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Map height', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make map responsive', 'shortcodes' )
						),
						'address' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Marker', 'shortcodes' ),
							'desc' => __( 'Address for the marker. You can type it in any language', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Maps by Google', 'shortcodes' ),
					'icon' => 'globe'
				),
				// slider
				'slider' => array(
					'name' => __( 'Slider', 'shortcodes' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'shortcodes' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'shortcodes' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'shortcodes' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'shortcodes' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'shortcodes' ),
								'image'      => __( 'Full-size image', 'shortcodes' ),
								'lightbox'   => __( 'Lightbox', 'shortcodes' ),
								'custom'     => __( 'Slide link (added in media editor)', 'shortcodes' ),
								'attachment' => __( 'Attachment page', 'shortcodes' ),
								'post'       => __( 'Post prettylink', 'shortcodes' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'shortcodes' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'shortcodes' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'shortcodes' ),
								'blank' => __( 'New window', 'shortcodes' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'shortcodes' ),
							'desc' => __( 'Open links in', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ), 'desc' => __( 'Slider width (in pixels)', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'shortcodes' ), 'desc' => __( 'Slider height (in pixels)', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make slider responsive', 'shortcodes' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'shortcodes' ), 'desc' => __( 'Display slide titles', 'shortcodes' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'shortcodes' ), 'desc' => __( 'Is slider centered on the page', 'shortcodes' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'shortcodes' ), 'desc' => __( 'Show left and right arrows', 'shortcodes' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Pagination', 'shortcodes' ),
							'desc' => __( 'Show pagination', 'shortcodes' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'shortcodes' ),
							'desc' => __( 'Allow to change slides with mouse wheel', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Choose interval between slide animations. Set to 0 to disable autoplay', 'shortcodes' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'shortcodes' ), 'desc' => __( 'Specify animation speed', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Customizable image slider', 'shortcodes' ),
					'icon' => 'picture-o'
				),
				// carousel
				'carousel' => array(
					'name' => __( 'Carousel', 'shortcodes' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'shortcodes' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'shortcodes' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'shortcodes' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'shortcodes' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'shortcodes' ),
								'image'      => __( 'Full-size image', 'shortcodes' ),
								'lightbox'   => __( 'Lightbox', 'shortcodes' ),
								'custom'     => __( 'Slide link (added in media editor)', 'shortcodes' ),
								'attachment' => __( 'Attachment page', 'shortcodes' ),
								'post'       => __( 'Post prettylink', 'shortcodes' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'shortcodes' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'shortcodes' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'shortcodes' ),
								'blank' => __( 'New window', 'shortcodes' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'shortcodes' ),
							'desc' => __( 'Open links in', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 100,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Carousel width (in pixels)', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 20,
							'max' => 1600,
							'step' => 20,
							'default' => 100,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Carousel height (in pixels)', 'shortcodes' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'shortcodes' ),
							'desc' => __( 'Ignore width and height parameters and make carousel responsive', 'shortcodes' )
						),
						'items' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Items to show', 'shortcodes' ),
							'desc' => __( 'How much carousel items is visible', 'shortcodes' )
						),
						'scroll' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1, 'default' => 1,
							'name' => __( 'Scroll number', 'shortcodes' ),
							'desc' => __( 'How much items are scrolled in one transition', 'shortcodes' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'shortcodes' ), 'desc' => __( 'Display titles for each item', 'shortcodes' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'shortcodes' ), 'desc' => __( 'Is carousel centered on the page', 'shortcodes' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'shortcodes' ), 'desc' => __( 'Show left and right arrows', 'shortcodes' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Pagination', 'shortcodes' ),
							'desc' => __( 'Show pagination', 'shortcodes' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'shortcodes' ),
							'desc' => __( 'Allow to rotate carousel with mouse wheel', 'shortcodes' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'shortcodes' ),
							'desc' => __( 'Choose interval between auto animations. Set to 0 to disable autoplay', 'shortcodes' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'shortcodes' ), 'desc' => __( 'Specify animation speed', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Customizable image carousel', 'shortcodes' ),
					'icon' => 'picture-o'
				),
				// custom_gallery
				'custom_gallery' => array(
					'name' => __( 'Gallery', 'shortcodes' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'shortcodes' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'shortcodes' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'shortcodes' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'shortcodes' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'shortcodes' ),
								'image'      => __( 'Full-size image', 'shortcodes' ),
								'lightbox'   => __( 'Lightbox', 'shortcodes' ),
								'custom'     => __( 'Slide link (added in media editor)', 'shortcodes' ),
								'attachment' => __( 'Attachment page', 'shortcodes' ),
								'post'       => __( 'Post prettylink', 'shortcodes' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'shortcodes' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'shortcodes' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'shortcodes' ),
								'blank' => __( 'New window', 'shortcodes' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'shortcodes' ),
							'desc' => __( 'Open links in', 'shortcodes' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Width', 'shortcodes' ), 'desc' => __( 'Single item width (in pixels)', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Height', 'shortcodes' ), 'desc' => __( 'Single item height (in pixels)', 'shortcodes' )
						),
						'title' => array(
							'type' => 'select',
							'values' => array(
								'never' => __( 'Never', 'shortcodes' ),
								'hover' => __( 'On mouse over', 'shortcodes' ),
								'always' => __( 'Always', 'shortcodes' )
							),
							'default' => 'hover',
							'name' => __( 'Show titles', 'shortcodes' ),
							'desc' => __( 'Title display mode', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Customizable image gallery', 'shortcodes' ),
					'icon' => 'picture-o'
				),
				// posts
				'posts' => array(
					'name' => __( 'Posts', 'shortcodes' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'template' => array(
							'default' => 'templates/default-loop.php', 'name' => __( 'Template', 'shortcodes' ),
							'desc' => __( '<b>Do not change this field value if you do not understand description below.</b><br/>Relative path to the template file. Default templates is placed under the plugin directory (templates folder). You can copy it under your design directory and modify as you want. You can use following default templates that already available in the plugin directory:<br/><b%value>templates/default-loop.php</b> - posts loop<br/><b%value>templates/teaser-loop.php</b> - posts loop with thumbnail and title<br/><b%value>templates/single-post.php</b> - single post template<br/><b%value>templates/list-loop.php</b> - unordered list with posts titles', 'shortcodes' )
						),
						'id' => array(
							'default' => '',
							'name' => __( 'Post ID\'s', 'shortcodes' ),
							'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'shortcodes' )
						),
						'posts_per_page' => array(
							'type' => 'number',
							'min' => -1,
							'max' => 10000,
							'step' => 1,
							'default' => get_option( 'posts_per_page' ),
							'name' => __( 'Posts per page', 'shortcodes' ),
							'desc' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'shortcodes' )
						),
						'post_type' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => Sm_Tools::get_types(),
							'default' => 'post',
							'name' => __( 'Post types', 'shortcodes' ),
							'desc' => __( 'Select post types. Hold Ctrl key to select multiple post types', 'shortcodes' )
						),
						'taxonomy' => array(
							'type' => 'select',
							'values' => Sm_Tools::get_taxonomies(),
							'default' => 'category',
							'name' => __( 'Taxonomy', 'shortcodes' ),
							'desc' => __( 'Select taxonomy to show posts from', 'shortcodes' )
						),
						'tax_term' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => Sm_Tools::get_terms( 'category' ),
							'default' => '',
							'name' => __( 'Terms', 'shortcodes' ),
							'desc' => __( 'Select terms to show posts from', 'shortcodes' )
						),
						'tax_operator' => array(
							'type' => 'select',
							'values' => array( 'IN', 'NOT IN', 'AND' ),
							'default' => 'IN', 'name' => __( 'Taxonomy term operator', 'shortcodes' ),
							'desc' => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that is does not have any of selected terms<br/>AND - posts that have all selected terms', 'shortcodes' )
						),
						// 'author' => array(
						// 	'type' => 'select',
						// 	'multiple' => true,
						// 	'values' => Sm_Tools::get_users(),
						// 	'default' => 'default',
						// 	'name' => __( 'Authors', 'shortcodes' ),
						// 	'desc' => __( 'Choose the authors whose posts you want to show. Enter here comma-separated list of users (IDs). Example: 1,7,18', 'shortcodes' )
						// ),
						'author' => array(
							'default' => '',
							'name' => __( 'Authors', 'shortcodes' ),
							'desc' => __( 'Enter here comma-separated list of author\'s IDs. Example: 1,7,18', 'shortcodes' )
						),
						'meta_key' => array(
							'default' => '',
							'name' => __( 'Meta key', 'shortcodes' ),
							'desc' => __( 'Enter meta key name to show posts that have this key', 'shortcodes' )
						),
						'offset' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 1, 'default' => 0,
							'name' => __( 'Offset', 'shortcodes' ),
							'desc' => __( 'Specify offset to start posts loop not from first post', 'shortcodes' )
						),
						'order' => array(
							'type' => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'shortcodes' ),
								'asc' => __( 'Ascending', 'shortcodes' )
							),
							'default' => 'DESC',
							'name' => __( 'Order', 'shortcodes' ),
							'desc' => __( 'Posts order', 'shortcodes' )
						),
						'orderby' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'shortcodes' ),
								'id' => __( 'Post ID', 'shortcodes' ),
								'author' => __( 'Post author', 'shortcodes' ),
								'title' => __( 'Post title', 'shortcodes' ),
								'name' => __( 'Post slug', 'shortcodes' ),
								'date' => __( 'Date', 'shortcodes' ), 'modified' => __( 'Last modified date', 'shortcodes' ),
								'parent' => __( 'Post parent', 'shortcodes' ),
								'rand' => __( 'Random', 'shortcodes' ), 'comment_count' => __( 'Comments number', 'shortcodes' ),
								'menu_order' => __( 'Menu order', 'shortcodes' ), 'meta_value' => __( 'Meta key values', 'shortcodes' ),
							),
							'default' => 'date',
							'name' => __( 'Order by', 'shortcodes' ),
							'desc' => __( 'Order posts by', 'shortcodes' )
						),
						'post_parent' => array(
							'default' => '',
							'name' => __( 'Post parent', 'shortcodes' ),
							'desc' => __( 'Show childrens of entered post (enter post ID)', 'shortcodes' )
						),
						'post_status' => array(
							'type' => 'select',
							'values' => array(
								'publish' => __( 'Published', 'shortcodes' ),
								'pending' => __( 'Pending', 'shortcodes' ),
								'draft' => __( 'Draft', 'shortcodes' ),
								'auto-draft' => __( 'Auto-draft', 'shortcodes' ),
								'future' => __( 'Future post', 'shortcodes' ),
								'private' => __( 'Private post', 'shortcodes' ),
								'inherit' => __( 'Inherit', 'shortcodes' ),
								'trash' => __( 'Trashed', 'shortcodes' ),
								'any' => __( 'Any', 'shortcodes' ),
							),
							'default' => 'publish',
							'name' => __( 'Post status', 'shortcodes' ),
							'desc' => __( 'Show only posts with selected status', 'shortcodes' )
						),
						'ignore_sticky_posts' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Ignore sticky', 'shortcodes' ),
							'desc' => __( 'Select Yes to ignore posts that is sticked', 'shortcodes' )
						)
					),
					'desc' => __( 'Custom posts query with customizable template', 'shortcodes' ),
					'icon' => 'th-list'
				),
				// dummy_text
				'dummy_text' => array(
					'name' => __( 'Dummy text', 'shortcodes' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'what' => array(
							'type' => 'select',
							'values' => array(
								'paras' => __( 'Paragraphs', 'shortcodes' ),
								'words' => __( 'Words', 'shortcodes' ),
								'bytes' => __( 'Bytes', 'shortcodes' ),
							),
							'default' => 'paras',
							'name' => __( 'What', 'shortcodes' ),
							'desc' => __( 'What to generate', 'shortcodes' )
						),
						'amount' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Amount', 'shortcodes' ),
							'desc' => __( 'How many items (paragraphs or words) to generate. Minimum words amount is 5', 'shortcodes' )
						),
						'cache' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Cache', 'shortcodes' ),
							'desc' => __( 'Generated text will be cached. Be careful with this option. If you disable it and insert many dummy_text shortcodes the page load time will be highly increased', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Text placeholder', 'shortcodes' ),
					'icon' => 'text-height'
				),
				// dummy_image
				'dummy_image' => array(
					'name' => __( 'Dummy image', 'shortcodes' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 500,
							'name' => __( 'Width', 'shortcodes' ),
							'desc' => __( 'Image width', 'shortcodes' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 300,
							'name' => __( 'Height', 'shortcodes' ),
							'desc' => __( 'Image height', 'shortcodes' )
						),
						'design' => array(
							'type' => 'select',
							'values' => array(
								'any'       => __( 'Any', 'shortcodes' ),
								'abstract'  => __( 'Abstract', 'shortcodes' ),
								'animals'   => __( 'Animals', 'shortcodes' ),
								'business'  => __( 'Business', 'shortcodes' ),
								'cats'      => __( 'Cats', 'shortcodes' ),
								'city'      => __( 'City', 'shortcodes' ),
								'food'      => __( 'Food', 'shortcodes' ),
								'nightlife' => __( 'Night life', 'shortcodes' ),
								'fashion'   => __( 'Fashion', 'shortcodes' ),
								'people'    => __( 'People', 'shortcodes' ),
								'nature'    => __( 'Nature', 'shortcodes' ),
								'sports'    => __( 'Sports', 'shortcodes' ),
								'technics'  => __( 'Technics', 'shortcodes' ),
								'transport' => __( 'Transport', 'shortcodes' )
							),
							'default' => 'any',
							'name' => __( 'design', 'shortcodes' ),
							'desc' => __( 'Select the design for this image', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Image placeholder with random image', 'shortcodes' ),
					'icon' => 'picture-o'
				),
				// animate
				'animate' => array(
					'name' => __( 'Animation', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'bounceIn',
							'name' => __( 'Animation', 'shortcodes' ),
							'desc' => __( 'Select animation type', 'shortcodes' )
						),
						'duration' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 1,
							'name' => __( 'Duration', 'shortcodes' ),
							'desc' => __( 'Animation duration (seconds)', 'shortcodes' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 0,
							'name' => __( 'Delay', 'shortcodes' ),
							'desc' => __( 'Animation delay (seconds)', 'shortcodes' )
						),
						'inline' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Inline', 'shortcodes' ),
							'desc' => __( 'This parameter determines what HTML tag will be used for animation wrapper. Turn this option to YES and animated element will be wrapped in SPAN instead of DIV. Useful for inline animations, like buttons', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'content' => __( 'Animated content', 'shortcodes' ),
					'desc' => __( 'Wrapper for animation. Any nested element will be animated', 'shortcodes' ),
					'example' => 'animations',
					'icon' => 'bolt'
				),
				// meta
				'meta' => array(
					'name' => __( 'Meta', 'shortcodes' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'key' => array(
							'default' => '',
							'name' => __( 'Key', 'shortcodes' ),
							'desc' => __( 'Meta key name', 'shortcodes' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'shortcodes' ),
							'desc' => __( 'This text will be shown if data is not found', 'shortcodes' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'shortcodes' ),
							'desc' => __( 'This content will be shown before the value', 'shortcodes' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'shortcodes' ),
							'desc' => __( 'This content will be shown after the value', 'shortcodes' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'shortcodes' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'shortcodes' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'shortcodes' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'shortcodes' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post meta', 'shortcodes' ),
					'icon' => 'info-circle'
				),
				// user
				'user' => array(
					'name' => __( 'User', 'shortcodes' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'display_name'        => __( 'Display name', 'shortcodes' ),
								'ID'                  => __( 'ID', 'shortcodes' ),
								'user_login'          => __( 'Login', 'shortcodes' ),
								'user_nicename'       => __( 'Nice name', 'shortcodes' ),
								'user_email'          => __( 'Email', 'shortcodes' ),
								'user_url'            => __( 'URL', 'shortcodes' ),
								'user_registered'     => __( 'Registered', 'shortcodes' ),
								'user_activation_key' => __( 'Activation key', 'shortcodes' ),
								'user_status'         => __( 'Status', 'shortcodes' )
							),
							'default' => 'display_name',
							'name' => __( 'Field', 'shortcodes' ),
							'desc' => __( 'User data field name', 'shortcodes' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'shortcodes' ),
							'desc' => __( 'This text will be shown if data is not found', 'shortcodes' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'shortcodes' ),
							'desc' => __( 'This content will be shown before the value', 'shortcodes' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'shortcodes' ),
							'desc' => __( 'This content will be shown after the value', 'shortcodes' )
						),
						'user_id' => array(
							'default' => '',
							'name' => __( 'User ID', 'shortcodes' ),
							'desc' => __( 'You can specify custom user ID. Leave this field empty to use an ID of the current user', 'shortcodes' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'shortcodes' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'shortcodes' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'User data', 'shortcodes' ),
					'icon' => 'info-circle'
				),
				// post
				'post' => array(
					'name' => __( 'Post', 'shortcodes' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'ID'                    => __( 'Post ID', 'shortcodes' ),
								'post_author'           => __( 'Post author', 'shortcodes' ),
								'post_date'             => __( 'Post date', 'shortcodes' ),
								'post_date_gmt'         => __( 'Post date', 'shortcodes' ) . ' GMT',
								'post_content'          => __( 'Post content', 'shortcodes' ),
								'post_title'            => __( 'Post title', 'shortcodes' ),
								'post_excerpt'          => __( 'Post excerpt', 'shortcodes' ),
								'post_status'           => __( 'Post status', 'shortcodes' ),
								'comment_status'        => __( 'Comment status', 'shortcodes' ),
								'ping_status'           => __( 'Ping status', 'shortcodes' ),
								'post_name'             => __( 'Article name', 'shortcodes' ),
								'post_modified'         => __( 'Post modified', 'shortcodes' ),
								'post_modified_gmt'     => __( 'Post modified', 'shortcodes' ) . ' GMT',
								'post_content_filtered' => __( 'Filtered post content', 'shortcodes' ),
								'post_parent'           => __( 'Post parent', 'shortcodes' ),
								'guid'                  => __( 'GUID', 'shortcodes' ),
								'menu_order'            => __( 'Menu order', 'shortcodes' ),
								'post_type'             => __( 'Post type', 'shortcodes' ),
								'post_mime_type'        => __( 'Post mime type', 'shortcodes' ),
								'comment_count'         => __( 'Comment count', 'shortcodes' )
							),
							'default' => 'post_title',
							'name' => __( 'Field', 'shortcodes' ),
							'desc' => __( 'Post data field name', 'shortcodes' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'shortcodes' ),
							'desc' => __( 'This text will be shown if data is not found', 'shortcodes' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'shortcodes' ),
							'desc' => __( 'This content will be shown before the value', 'shortcodes' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'shortcodes' ),
							'desc' => __( 'This content will be shown after the value', 'shortcodes' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'shortcodes' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'shortcodes' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'shortcodes' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'shortcodes' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post data', 'shortcodes' ),
					'icon' => 'info-circle'
				),
				// post_terms
				// 'post_terms' => array(
				// 	'name' => __( 'Post terms', 'shortcodes' ),
				// 	'type' => 'single',
				// 	'group' => 'data',
				// 	'atts' => array(
				// 		'post_id' => array(
				// 			'default' => '',
				// 			'name' => __( 'Post ID', 'shortcodes' ),
				// 			'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'shortcodes' )
				// 		),
				// 		'links' => array(
				// 			'type' => 'bool',
				// 			'default' => 'yes',
				// 			'name' => __( 'Show links', 'shortcodes' ),
				// 			'desc' => __( 'Show terms names as hyperlinks', 'shortcodes' )
				// 		),
				// 		'format' => array(
				// 			'type' => 'select',
				// 			'values' => array(
				// 				'text' => __( 'Terms separated by commas', 'shortcodes' ),
				// 				'br' => __( 'Terms separated by new lines', 'shortcodes' ),
				// 				'ul' => __( 'Unordered list', 'shortcodes' ),
				// 				'ol' => __( 'Ordered list', 'shortcodes' ),
				// 			),
				// 			'default' => 'text',
				// 			'name' => __( 'Format', 'shortcodes' ),
				// 			'desc' => __( 'Choose how to output the terms', 'shortcodes' )
				// 		),
				// 	),
				// 	'desc' => __( 'Terms list', 'shortcodes' ),
				// 	'icon' => 'info-circle'
				// ),
				// template
				'template' => array(
					'name' => __( 'Template', 'shortcodes' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'default' => '',
							'name' => __( 'Template name', 'shortcodes' ),
							'desc' => sprintf( __( 'Use template file name (with optional .php extension). If you need to use templates from design sub-folder, use relative path. Example values: %s, %s, %s', 'shortcodes' ), '<b%value>page</b>', '<b%value>page.php</b>', '<b%value>res/page.php</b>' )
						)
					),
					'desc' => __( 'design template', 'shortcodes' ),
					'icon' => 'puzzle-piece'
				),
				// qrcode
				'qrcode' => array(
					'name' => __( 'QR code', 'shortcodes' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'data' => array(
							'default' => '',
							'name' => __( 'Data', 'shortcodes' ),
							'desc' => __( 'The text to store within the QR code. You can use here any text or even URL', 'shortcodes' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Title', 'shortcodes' ),
							'desc' => __( 'Enter here short description. This text will be used in alt attribute of QR code', 'shortcodes' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1000,
							'step' => 10,
							'default' => 200,
							'name' => __( 'Size', 'shortcodes' ),
							'desc' => __( 'Image width and height (in pixels)', 'shortcodes' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 50,
							'step' => 5,
							'default' => 0,
							'name' => __( 'Margin', 'shortcodes' ),
							'desc' => __( 'Thickness of a margin (in pixels)', 'shortcodes' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'shortcodes' ),
								'left' => __( 'Left', 'shortcodes' ),
								'center' => __( 'Center', 'shortcodes' ),
								'right' => __( 'Right', 'shortcodes' ),
							),
							'default' => 'none',
							'name' => __( 'Align', 'shortcodes' ),
							'desc' => __( 'Choose image alignment', 'shortcodes' )
						),
						'link' => array(
							'default' => '',
							'name' => __( 'Link', 'shortcodes' ),
							'desc' => __( 'You can make this QR code clickable. Enter here the URL', 'shortcodes' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open link in same window/tab', 'shortcodes' ),
								'blank' => __( 'Open link in new window/tab', 'shortcodes' ),
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'shortcodes' ),
							'desc' => __( 'Select link target', 'shortcodes' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#000000',
							'name' => __( 'Primary color', 'shortcodes' ),
							'desc' => __( 'Pick a primary color', 'shortcodes' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#ffffff',
							'name' => __( 'Background color', 'shortcodes' ),
							'desc' => __( 'Pick a background color', 'shortcodes' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'shortcodes' ),
							'desc' => __( 'Extra CSS class', 'shortcodes' )
						)
					),
					'desc' => __( 'Advanced QR code generator', 'shortcodes' ),
					'icon' => 'qrcode'
				),
				// scheduler
				'scheduler' => array(
					'name' => __( 'Scheduler', 'shortcodes' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'time' => array(
							'default' => '',
							'name' => __( 'Time', 'shortcodes' ),
							'desc' => sprintf( __( 'In this field you can specify one or more time ranges. Every day at this time the content of shortcode will be visible. %s %s %s - show content from 9:00 to 18:00 %s - show content from 9:00 to 13:00 and from 14:00 to 18:00 %s - example with minutes (content will be visible each day, 45 minutes) %s - example with seconds', 'shortcodes' ), '<br><br>', __( 'Examples (click to set)', 'shortcodes' ), '<br><b%value>9-18</b>', '<br><b%value>9-13, 14-18</b>', '<br><b%value>9:30-10:15</b>', '<br><b%value>9:00:00-17:59:59</b>' )
						),
						'days_week' => array(
							'default' => '',
							'name' => __( 'Days of the week', 'shortcodes' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the week. Every week at these days the content of shortcode will be visible. %s 0 - Sunday %s 1 - Monday %s 2 - Tuesday %s 3 - Wednesday %s 4 - Thursday %s 5 - Friday %s 6 - Saturday %s %s %s - show content from Monday to Friday %s - show content only at Sunday %s - show content at Sunday and from Wednesday to Friday', 'shortcodes' ), '<br><br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br><br>', __( 'Examples (click to set)', 'shortcodes' ), '<br><b%value>1-5</b>', '<br><b%value>0</b>', '<br><b%value>0, 3-5</b>' )
						),
						'days_month' => array(
							'default' => '',
							'name' => __( 'Days of the month', 'shortcodes' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the month. Every month at these days the content of shortcode will be visible. %s %s %s - show content only at first day of month %s - show content from 1th to 5th %s - show content from 10th to 15th and from 20th to 25th', 'shortcodes' ), '<br><br>', __( 'Examples (click to set)', 'shortcodes' ), '<br><b%value>1</b>', '<br><b%value>1-5</b>', '<br><b%value>10-15, 20-25</b>' )
						),
						'months' => array(
							'default' => '',
							'name' => __( 'Months', 'shortcodes' ),
							'desc' => sprintf( __( 'In this field you can specify the month or months in which the content will be visible. %s %s %s - show content only in January %s - show content from February to June %s - show content in January, March and from May to July', 'shortcodes' ), '<br><br>', __( 'Examples (click to set)', 'shortcodes' ), '<br><b%value>1</b>', '<br><b%value>2-6</b>', '<br><b%value>1, 3, 5-7</b>' )
						),
						'years' => array(
							'default' => '',
							'name' => __( 'Years', 'shortcodes' ),
							'desc' => sprintf( __( 'In this field you can specify the year or years in which the content will be visible. %s %s %s - show content only in 2014 %s - show content from 2014 to 2016 %s - show content in 2014, 2018 and from 2020 to 2022', 'shortcodes' ), '<br><br>', __( 'Examples (click to set)', 'shortcodes' ), '<br><b%value>2014</b>', '<br><b%value>2014-2016</b>', '<br><b%value>2014, 2018, 2020-2022</b>' )
						),
						'alt' => array(
							'default' => '',
							'name' => __( 'Alternative text', 'shortcodes' ),
							'desc' => __( 'In this field you can type the text which will be shown if content is not visible at the current moment', 'shortcodes' )
						)
					),
					'content' => __( 'Scheduled content', 'shortcodes' ),
					'desc' => __( 'Allows to show the content only at the specified time period', 'shortcodes' ),
					'note' => __( 'This shortcode allows you to show content only at the specified time.', 'shortcodes' ) . '<br><br>' . __( 'Please pay special attention to the descriptions, which are located below each text field. It will save you a lot of time', 'shortcodes' ) . '<br><br>' . __( 'By default, the content of this shortcode will be visible all the time. By using fields below, you can add some limitations. For example, if you type 1-5 in the Days of the week field, content will be only shown from Monday to Friday. Using the same principles, you can limit content visibility from years to seconds.', 'shortcodes' ),
					'icon' => 'clock-o'
				),
			) );
		// Return result
		return ( is_string( $shortcode ) ) ? $shortcodes[sanitize_text_field( $shortcode )] : $shortcodes;
	}
}

class Shortcodes_Ultimate_Data extends Sm_Data {
	function __construct() {
		parent::__construct();
	}
}
