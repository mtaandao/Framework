/* global getUserSetting, tinymce, QTags */

// Mtaandao, TinyMCE, and Media
// -----------------------------
(function($, _){
	/**
	 * Stores the editors' `mn.media.controller.Frame` instances.
	 *
	 * @static
	 */
	var workflows = {};

	/**
	 * A helper mixin function to avoid truthy and falsey values being
	 *   passed as an input that expects booleans. If key is undefined in the map,
	 *   but has a default value, set it.
	 *
	 * @param {object} attrs Map of props from a shortcode or settings.
	 * @param {string} key The key within the passed map to check for a value.
	 * @returns {mixed|undefined} The original or coerced value of key within attrs
	 */
	mn.media.coerce = function ( attrs, key ) {
		if ( _.isUndefined( attrs[ key ] ) && ! _.isUndefined( this.defaults[ key ] ) ) {
			attrs[ key ] = this.defaults[ key ];
		} else if ( 'true' === attrs[ key ] ) {
			attrs[ key ] = true;
		} else if ( 'false' === attrs[ key ] ) {
			attrs[ key ] = false;
		}
		return attrs[ key ];
	};

	/**
	 * mn.media.string
	 * @namespace
	 */
	mn.media.string = {
		/**
		 * Joins the `props` and `attachment` objects,
		 * outputting the proper object format based on the
		 * attachment's type.
		 *
		 * @global mn.media.view.settings
		 * @global getUserSetting()
		 *
		 * @param {Object} [props={}] Attachment details (align, link, size, etc).
		 * @param {Object} attachment The attachment object, media version of Post.
		 * @returns {Object} Joined props
		 */
		props: function( props, attachment ) {
			var link, linkUrl, size, sizes, fallbacks,
				defaultProps = mn.media.view.settings.defaultProps;

			// Final fallbacks run after all processing has been completed.
			fallbacks = function( props ) {
				// Generate alt fallbacks and strip tags.
				if ( 'image' === props.type && ! props.alt ) {
					if ( props.caption ) {
						props.alt = props.caption;
					} else if ( props.title !== props.url ) {
						props.alt = props.title;
					} else {
						props.alt = '';
					}

					props.alt = props.alt.replace( /<\/?[^>]+>/g, '' );
					props.alt = props.alt.replace( /[\r\n]+/g, ' ' );
				}

				return props;
			};

			props = props ? _.clone( props ) : {};

			if ( attachment && attachment.type ) {
				props.type = attachment.type;
			}

			if ( 'image' === props.type ) {
				props = _.defaults( props || {}, {
					align:   defaultProps.align || getUserSetting( 'align', 'none' ),
					size:    defaultProps.size  || getUserSetting( 'imgsize', 'medium' ),
					url:     '',
					classes: []
				});
			}

			// All attachment-specific settings follow.
			if ( ! attachment ) {
				return fallbacks( props );
			}

			props.title = props.title || attachment.title;

			link = props.link || defaultProps.link || getUserSetting( 'urlbutton', 'file' );
			if ( 'file' === link || 'embed' === link ) {
				linkUrl = attachment.url;
			} else if ( 'post' === link ) {
				linkUrl = attachment.link;
			} else if ( 'custom' === link ) {
				linkUrl = props.linkUrl;
			}
			props.linkUrl = linkUrl || '';

			// Format properties for images.
			if ( 'image' === attachment.type ) {
				props.classes.push( 'mn-image-' + attachment.id );

				sizes = attachment.sizes;
				size = sizes && sizes[ props.size ] ? sizes[ props.size ] : attachment;

				_.extend( props, _.pick( attachment, 'align', 'caption', 'alt' ), {
					width:     size.width,
					height:    size.height,
					src:       size.url,
					captionId: 'attachment_' + attachment.id
				});
			} else if ( 'video' === attachment.type || 'audio' === attachment.type ) {
				_.extend( props, _.pick( attachment, 'title', 'type', 'icon', 'mime' ) );
			// Format properties for non-images.
			} else {
				props.title = props.title || attachment.filename;
				props.rel = props.rel || 'attachment mn-att-' + attachment.id;
			}

			return fallbacks( props );
		},
		/**
		 * Create link markup that is suitable for passing to the editor
		 *
		 * @global mn.html.string
		 *
		 * @param {Object} props Attachment details (align, link, size, etc).
		 * @param {Object} attachment The attachment object, media version of Post.
		 * @returns {string} The link markup
		 */
		link: function( props, attachment ) {
			var options;

			props = mn.media.string.props( props, attachment );

			options = {
				tag:     'a',
				content: props.title,
				attrs:   {
					href: props.linkUrl
				}
			};

			if ( props.rel ) {
				options.attrs.rel = props.rel;
			}

			return mn.html.string( options );
		},
		/**
		 * Create an Audio shortcode string that is suitable for passing to the editor
		 *
		 * @param {Object} props Attachment details (align, link, size, etc).
		 * @param {Object} attachment The attachment object, media version of Post.
		 * @returns {string} The audio shortcode
		 */
		audio: function( props, attachment ) {
			return mn.media.string._audioVideo( 'audio', props, attachment );
		},
		/**
		 * Create a Video shortcode string that is suitable for passing to the editor
		 *
		 * @param {Object} props Attachment details (align, link, size, etc).
		 * @param {Object} attachment The attachment object, media version of Post.
		 * @returns {string} The video shortcode
		 */
		video: function( props, attachment ) {
			return mn.media.string._audioVideo( 'video', props, attachment );
		},
		/**
		 * Helper function to create a media shortcode string
		 *
		 * @access private
		 *
		 * @global mn.shortcode
		 * @global mn.media.view.settings
		 *
		 * @param {string} type The shortcode tag name: 'audio' or 'video'.
		 * @param {Object} props Attachment details (align, link, size, etc).
		 * @param {Object} attachment The attachment object, media version of Post.
		 * @returns {string} The media shortcode
		 */
		_audioVideo: function( type, props, attachment ) {
			var shortcode, html, extension;

			props = mn.media.string.props( props, attachment );
			if ( props.link !== 'embed' )
				return mn.media.string.link( props );

			shortcode = {};

			if ( 'video' === type ) {
				if ( attachment.image && -1 === attachment.image.src.indexOf( attachment.icon ) ) {
					shortcode.poster = attachment.image.src;
				}

				if ( attachment.width ) {
					shortcode.width = attachment.width;
				}

				if ( attachment.height ) {
					shortcode.height = attachment.height;
				}
			}

			extension = attachment.filename.split('.').pop();

			if ( _.contains( mn.media.view.settings.embedExts, extension ) ) {
				shortcode[extension] = attachment.url;
			} else {
				// Render unsupported audio and video files as links.
				return mn.media.string.link( props );
			}

			html = mn.shortcode.string({
				tag:     type,
				attrs:   shortcode
			});

			return html;
		},
		/**
		 * Create image markup, optionally with a link and/or wrapped in a caption shortcode,
		 *  that is suitable for passing to the editor
		 *
		 * @global mn.html
		 * @global mn.shortcode
		 *
		 * @param {Object} props Attachment details (align, link, size, etc).
		 * @param {Object} attachment The attachment object, media version of Post.
		 * @returns {string}
		 */
		image: function( props, attachment ) {
			var img = {},
				options, classes, shortcode, html;

			props.type = 'image';
			props = mn.media.string.props( props, attachment );
			classes = props.classes || [];

			img.src = ! _.isUndefined( attachment ) ? attachment.url : props.url;
			_.extend( img, _.pick( props, 'width', 'height', 'alt' ) );

			// Only assign the align class to the image if we're not printing
			// a caption, since the alignment is sent to the shortcode.
			if ( props.align && ! props.caption ) {
				classes.push( 'align' + props.align );
			}

			if ( props.size ) {
				classes.push( 'size-' + props.size );
			}

			img['class'] = _.compact( classes ).join(' ');

			// Generate `img` tag options.
			options = {
				tag:    'img',
				attrs:  img,
				single: true
			};

			// Generate the `a` element options, if they exist.
			if ( props.linkUrl ) {
				options = {
					tag:   'a',
					attrs: {
						href: props.linkUrl
					},
					content: options
				};
			}

			html = mn.html.string( options );

			// Generate the caption shortcode.
			if ( props.caption ) {
				shortcode = {};

				if ( img.width ) {
					shortcode.width = img.width;
				}

				if ( props.captionId ) {
					shortcode.id = props.captionId;
				}

				if ( props.align ) {
					shortcode.align = 'align' + props.align;
				}

				html = mn.shortcode.string({
					tag:     'caption',
					attrs:   shortcode,
					content: html + ' ' + props.caption
				});
			}

			return html;
		}
	};

	mn.media.embed = {
		coerce : mn.media.coerce,

		defaults : {
			url : '',
			width: '',
			height: ''
		},

		edit : function( data, isURL ) {
			var frame, props = {}, shortcode;

			if ( isURL ) {
				props.url = data.replace(/<[^>]+>/g, '');
			} else {
				shortcode = mn.shortcode.next( 'embed', data ).shortcode;

				props = _.defaults( shortcode.attrs.named, this.defaults );
				if ( shortcode.content ) {
					props.url = shortcode.content;
				}
			}

			frame = mn.media({
				frame: 'post',
				state: 'embed',
				metadata: props
			});

			return frame;
		},

		shortcode : function( model ) {
			var self = this, content;

			_.each( this.defaults, function( value, key ) {
				model[ key ] = self.coerce( model, key );

				if ( value === model[ key ] ) {
					delete model[ key ];
				}
			});

			content = model.url;
			delete model.url;

			return new mn.shortcode({
				tag: 'embed',
				attrs: model,
				content: content
			});
		}
	};

	mn.media.collection = function(attributes) {
		var collections = {};

		return _.extend( {
			coerce : mn.media.coerce,
			/**
			 * Retrieve attachments based on the properties of the passed shortcode
			 *
			 * @global mn.media.query
			 *
			 * @param {mn.shortcode} shortcode An instance of mn.shortcode().
			 * @returns {mn.media.model.Attachments} A Backbone.Collection containing
			 *      the media items belonging to a collection.
			 *      The query[ this.tag ] property is a Backbone.Model
			 *          containing the 'props' for the collection.
			 */
			attachments: function( shortcode ) {
				var shortcodeString = shortcode.string(),
					result = collections[ shortcodeString ],
					attrs, args, query, others, self = this;

				delete collections[ shortcodeString ];
				if ( result ) {
					return result;
				}
				// Fill the default shortcode attributes.
				attrs = _.defaults( shortcode.attrs.named, this.defaults );
				args  = _.pick( attrs, 'orderby', 'order' );

				args.type    = this.type;
				args.perPage = -1;

				// Mark the `orderby` override attribute.
				if ( undefined !== attrs.orderby ) {
					attrs._orderByField = attrs.orderby;
				}

				if ( 'rand' === attrs.orderby ) {
					attrs._orderbyRandom = true;
				}

				// Map the `orderby` attribute to the corresponding model property.
				if ( ! attrs.orderby || /^menu_order(?: ID)?$/i.test( attrs.orderby ) ) {
					args.orderby = 'menuOrder';
				}

				// Map the `ids` param to the correct query args.
				if ( attrs.ids ) {
					args.post__in = attrs.ids.split(',');
					args.orderby  = 'post__in';
				} else if ( attrs.include ) {
					args.post__in = attrs.include.split(',');
				}

				if ( attrs.exclude ) {
					args.post__not_in = attrs.exclude.split(',');
				}

				if ( ! args.post__in ) {
					args.uploadedTo = attrs.id;
				}

				// Collect the attributes that were not included in `args`.
				others = _.omit( attrs, 'id', 'ids', 'include', 'exclude', 'orderby', 'order' );

				_.each( this.defaults, function( value, key ) {
					others[ key ] = self.coerce( others, key );
				});

				query = mn.media.query( args );
				query[ this.tag ] = new Backbone.Model( others );
				return query;
			},
			/**
			 * Triggered when clicking 'Insert {label}' or 'Update {label}'
			 *
			 * @global mn.shortcode
			 * @global mn.media.model.Attachments
			 *
			 * @param {mn.media.model.Attachments} attachments A Backbone.Collection containing
			 *      the media items belonging to a collection.
			 *      The query[ this.tag ] property is a Backbone.Model
			 *          containing the 'props' for the collection.
			 * @returns {mn.shortcode}
			 */
			shortcode: function( attachments ) {
				var props = attachments.props.toJSON(),
					attrs = _.pick( props, 'orderby', 'order' ),
					shortcode, clone;

				if ( attachments.type ) {
					attrs.type = attachments.type;
					delete attachments.type;
				}

				if ( attachments[this.tag] ) {
					_.extend( attrs, attachments[this.tag].toJSON() );
				}

				// Convert all gallery shortcodes to use the `ids` property.
				// Ignore `post__in` and `post__not_in`; the attachments in
				// the collection will already reflect those properties.
				attrs.ids = attachments.pluck('id');

				// Copy the `uploadedTo` post ID.
				if ( props.uploadedTo ) {
					attrs.id = props.uploadedTo;
				}
				// Check if the gallery is randomly ordered.
				delete attrs.orderby;

				if ( attrs._orderbyRandom ) {
					attrs.orderby = 'rand';
				} else if ( attrs._orderByField && attrs._orderByField != 'rand' ) {
					attrs.orderby = attrs._orderByField;
				}

				delete attrs._orderbyRandom;
				delete attrs._orderByField;

				// If the `ids` attribute is set and `orderby` attribute
				// is the default value, clear it for cleaner output.
				if ( attrs.ids && 'post__in' === attrs.orderby ) {
					delete attrs.orderby;
				}

				attrs = this.setDefaults( attrs );

				shortcode = new mn.shortcode({
					tag:    this.tag,
					attrs:  attrs,
					type:   'single'
				});

				// Use a cloned version of the gallery.
				clone = new mn.media.model.Attachments( attachments.models, {
					props: props
				});
				clone[ this.tag ] = attachments[ this.tag ];
				collections[ shortcode.string() ] = clone;

				return shortcode;
			},
			/**
			 * Triggered when double-clicking a collection shortcode placeholder
			 *   in the editor
			 *
			 * @global mn.shortcode
			 * @global mn.media.model.Selection
			 * @global mn.media.view.l10n
			 *
			 * @param {string} content Content that is searched for possible
			 *    shortcode markup matching the passed tag name,
			 *
			 * @this mn.media.{prop}
			 *
			 * @returns {mn.media.view.MediaFrame.Select} A media workflow.
			 */
			edit: function( content ) {
				var shortcode = mn.shortcode.next( this.tag, content ),
					defaultPostId = this.defaults.id,
					attachments, selection, state;

				// Bail if we didn't match the shortcode or all of the content.
				if ( ! shortcode || shortcode.content !== content ) {
					return;
				}

				// Ignore the rest of the match object.
				shortcode = shortcode.shortcode;

				if ( _.isUndefined( shortcode.get('id') ) && ! _.isUndefined( defaultPostId ) ) {
					shortcode.set( 'id', defaultPostId );
				}

				attachments = this.attachments( shortcode );

				selection = new mn.media.model.Selection( attachments.models, {
					props:    attachments.props.toJSON(),
					multiple: true
				});

				selection[ this.tag ] = attachments[ this.tag ];

				// Fetch the query's attachments, and then break ties from the
				// query to allow for sorting.
				selection.more().done( function() {
					// Break ties with the query.
					selection.props.set({ query: false });
					selection.unmirror();
					selection.props.unset('orderby');
				});

				// Destroy the previous gallery frame.
				if ( this.frame ) {
					this.frame.dispose();
				}

				if ( shortcode.attrs.named.type && 'video' === shortcode.attrs.named.type ) {
					state = 'video-' + this.tag + '-edit';
				} else {
					state = this.tag + '-edit';
				}

				// Store the current frame.
				this.frame = mn.media({
					frame:     'post',
					state:     state,
					title:     this.editTitle,
					editing:   true,
					multiple:  true,
					selection: selection
				}).open();

				return this.frame;
			},

			setDefaults: function( attrs ) {
				var self = this;
				// Remove default attributes from the shortcode.
				_.each( this.defaults, function( value, key ) {
					attrs[ key ] = self.coerce( attrs, key );
					if ( value === attrs[ key ] ) {
						delete attrs[ key ];
					}
				});

				return attrs;
			}
		}, attributes );
	};

	mn.media._galleryDefaults = {
		itemtag: 'dl',
		icontag: 'dt',
		captiontag: 'dd',
		columns: '3',
		link: 'post',
		size: 'thumbnail',
		order: 'ASC',
		id: mn.media.view.settings.post && mn.media.view.settings.post.id,
		orderby : 'menu_order ID'
	};

	if ( mn.media.view.settings.galleryDefaults ) {
		mn.media.galleryDefaults = _.extend( {}, mn.media._galleryDefaults, mn.media.view.settings.galleryDefaults );
	} else {
		mn.media.galleryDefaults = mn.media._galleryDefaults;
	}

	mn.media.gallery = new mn.media.collection({
		tag: 'gallery',
		type : 'image',
		editTitle : mn.media.view.l10n.editGalleryTitle,
		defaults : mn.media.galleryDefaults,

		setDefaults: function( attrs ) {
			var self = this, changed = ! _.isEqual( mn.media.galleryDefaults, mn.media._galleryDefaults );
			_.each( this.defaults, function( value, key ) {
				attrs[ key ] = self.coerce( attrs, key );
				if ( value === attrs[ key ] && ( ! changed || value === mn.media._galleryDefaults[ key ] ) ) {
					delete attrs[ key ];
				}
			} );
			return attrs;
		}
	});

	/**
	 * mn.media.featuredImage
	 * @namespace
	 */
	mn.media.featuredImage = {
		/**
		 * Get the featured image post ID
		 *
		 * @global mn.media.view.settings
		 *
		 * @returns {mn.media.view.settings.post.featuredImageId|number}
		 */
		get: function() {
			return mn.media.view.settings.post.featuredImageId;
		},
		/**
		 * Set the featured image id, save the post thumbnail data and
		 * set the HTML in the post meta box to the new featured image.
		 *
		 * @global mn.media.view.settings
		 * @global mn.media.post
		 *
		 * @param {number} id The post ID of the featured image, or -1 to unset it.
		 */
		set: function( id ) {
			var settings = mn.media.view.settings;

			settings.post.featuredImageId = id;

			mn.media.post( 'get-post-thumbnail-html', {
				post_id:      settings.post.id,
				thumbnail_id: settings.post.featuredImageId,
				_mnnonce:     settings.post.nonce
			}).done( function( html ) {
				if ( html == '0' ) {
					window.alert( window.setPostThumbnailL10n.error );
					return;
				}
				$( '.inside', '#postimagediv' ).html( html );
			});
		},
		/**
		 * Remove the featured image id, save the post thumbnail data and
		 * set the HTML in the post meta box to no featured image.
		 */
		remove: function() {
			mn.media.featuredImage.set( -1 );
		},
		/**
		 * The Featured Image workflow
		 *
		 * @global mn.media.controller.FeaturedImage
		 * @global mn.media.view.l10n
		 *
		 * @this mn.media.featuredImage
		 *
		 * @returns {mn.media.view.MediaFrame.Select} A media workflow.
		 */
		frame: function() {
			if ( this._frame ) {
				mn.media.frame = this._frame;
				return this._frame;
			}

			this._frame = mn.media({
				state: 'featured-image',
				states: [ new mn.media.controller.FeaturedImage() , new mn.media.controller.EditImage() ]
			});

			this._frame.on( 'toolbar:create:featured-image', function( toolbar ) {
				/**
				 * @this mn.media.view.MediaFrame.Select
				 */
				this.createSelectToolbar( toolbar, {
					text: mn.media.view.l10n.setFeaturedImage
				});
			}, this._frame );

			this._frame.on( 'content:render:edit-image', function() {
				var selection = this.state('featured-image').get('selection'),
					view = new mn.media.view.EditImage( { model: selection.single(), controller: this } ).render();

				this.content.set( view );

				// after bringing in the frame, load the actual editor via an ajax call
				view.loadEditor();

			}, this._frame );

			this._frame.state('featured-image').on( 'select', this.select );
			return this._frame;
		},
		/**
		 * 'select' callback for Featured Image workflow, triggered when
		 *  the 'Set Featured Image' button is clicked in the media modal.
		 *
		 * @global mn.media.view.settings
		 *
		 * @this mn.media.controller.FeaturedImage
		 */
		select: function() {
			var selection = this.get('selection').single();

			if ( ! mn.media.view.settings.post.featuredImageId ) {
				return;
			}

			mn.media.featuredImage.set( selection ? selection.id : -1 );
		},
		/**
		 * Open the content media manager to the 'featured image' tab when
		 * the post thumbnail is clicked.
		 *
		 * Update the featured image id when the 'remove' link is clicked.
		 *
		 * @global mn.media.view.settings
		 */
		init: function() {
			$('#postimagediv').on( 'click', '#set-post-thumbnail', function( event ) {
				event.preventDefault();
				// Stop propagation to prevent thickbox from activating.
				event.stopPropagation();

				mn.media.featuredImage.frame().open();
			}).on( 'click', '#remove-post-thumbnail', function() {
				mn.media.featuredImage.remove();
				return false;
			});
		}
	};

	$( mn.media.featuredImage.init );

	/**
	 * mn.media.editor
	 * @namespace
	 */
	mn.media.editor = {
		/**
		 * Send content to the editor
		 *
		 * @global tinymce
		 * @global QTags
		 * @global mnActiveEditor
		 * @global tb_remove() - Possibly overloaded by legacy plugins
		 *
		 * @param {string} html Content to send to the editor
		 */
		insert: function( html ) {
			var editor, mnActiveEditor,
				hasTinymce = ! _.isUndefined( window.tinymce ),
				hasQuicktags = ! _.isUndefined( window.QTags );

			if ( this.activeEditor ) {
				mnActiveEditor = window.mnActiveEditor = this.activeEditor;
			} else {
				mnActiveEditor = window.mnActiveEditor;
			}

			// Delegate to the global `send_to_editor` if it exists.
			// This attempts to play nice with any themes/plugins that have
			// overridden the insert functionality.
			if ( window.send_to_editor ) {
				return window.send_to_editor.apply( this, arguments );
			}

			if ( ! mnActiveEditor ) {
				if ( hasTinymce && tinymce.activeEditor ) {
					editor = tinymce.activeEditor;
					mnActiveEditor = window.mnActiveEditor = editor.id;
				} else if ( ! hasQuicktags ) {
					return false;
				}
			} else if ( hasTinymce ) {
				editor = tinymce.get( mnActiveEditor );
			}

			if ( editor && ! editor.isHidden() ) {
				editor.execCommand( 'mceInsertContent', false, html );
			} else if ( hasQuicktags ) {
				QTags.insertContent( html );
			} else {
				document.getElementById( mnActiveEditor ).value += html;
			}

			// If the old thickbox remove function exists, call it in case
			// a theme/plugin overloaded it.
			if ( window.tb_remove ) {
				try { window.tb_remove(); } catch( e ) {}
			}
		},

		/**
		 * Setup 'workflow' and add to the 'workflows' cache. 'open' can
		 *  subsequently be called upon it.
		 *
		 * @global mn.media.view.l10n
		 *
		 * @param {string} id A slug used to identify the workflow.
		 * @param {Object} [options={}]
		 *
		 * @this mn.media.editor
		 *
		 * @returns {mn.media.view.MediaFrame.Select} A media workflow.
		 */
		add: function( id, options ) {
			var workflow = this.get( id );

			// only add once: if exists return existing
			if ( workflow ) {
				return workflow;
			}

			workflow = workflows[ id ] = mn.media( _.defaults( options || {}, {
				frame:    'post',
				state:    'insert',
				title:    mn.media.view.l10n.addMedia,
				multiple: true
			} ) );

			workflow.on( 'insert', function( selection ) {
				var state = workflow.state();

				selection = selection || state.get('selection');

				if ( ! selection )
					return;

				$.when.apply( $, selection.map( function( attachment ) {
					var display = state.display( attachment ).toJSON();
					/**
					 * @this mn.media.editor
					 */
					return this.send.attachment( display, attachment.toJSON() );
				}, this ) ).done( function() {
					mn.media.editor.insert( _.toArray( arguments ).join('\n\n') );
				});
			}, this );

			workflow.state('gallery-edit').on( 'update', function( selection ) {
				/**
				 * @this mn.media.editor
				 */
				this.insert( mn.media.gallery.shortcode( selection ).string() );
			}, this );

			workflow.state('playlist-edit').on( 'update', function( selection ) {
				/**
				 * @this mn.media.editor
				 */
				this.insert( mn.media.playlist.shortcode( selection ).string() );
			}, this );

			workflow.state('video-playlist-edit').on( 'update', function( selection ) {
				/**
				 * @this mn.media.editor
				 */
				this.insert( mn.media.playlist.shortcode( selection ).string() );
			}, this );

			workflow.state('embed').on( 'select', function() {
				/**
				 * @this mn.media.editor
				 */
				var state = workflow.state(),
					type = state.get('type'),
					embed = state.props.toJSON();

				embed.url = embed.url || '';

				if ( 'link' === type ) {
					_.defaults( embed, {
						linkText: embed.url,
						linkUrl: embed.url
					});

					this.send.link( embed ).done( function( resp ) {
						mn.media.editor.insert( resp );
					});

				} else if ( 'image' === type ) {
					_.defaults( embed, {
						title:   embed.url,
						linkUrl: '',
						align:   'none',
						link:    'none'
					});

					if ( 'none' === embed.link ) {
						embed.linkUrl = '';
					} else if ( 'file' === embed.link ) {
						embed.linkUrl = embed.url;
					}

					this.insert( mn.media.string.image( embed ) );
				}
			}, this );

			workflow.state('featured-image').on( 'select', mn.media.featuredImage.select );
			workflow.setState( workflow.options.state );
			return workflow;
		},
		/**
		 * Determines the proper current workflow id
		 *
		 * @global mnActiveEditor
		 * @global tinymce
		 *
		 * @param {string} [id=''] A slug used to identify the workflow.
		 *
		 * @returns {mnActiveEditor|string|tinymce.activeEditor.id}
		 */
		id: function( id ) {
			if ( id ) {
				return id;
			}

			// If an empty `id` is provided, default to `mnActiveEditor`.
			id = window.mnActiveEditor;

			// If that doesn't work, fall back to `tinymce.activeEditor.id`.
			if ( ! id && ! _.isUndefined( window.tinymce ) && tinymce.activeEditor ) {
				id = tinymce.activeEditor.id;
			}

			// Last but not least, fall back to the empty string.
			id = id || '';
			return id;
		},
		/**
		 * Return the workflow specified by id
		 *
		 * @param {string} id A slug used to identify the workflow.
		 *
		 * @this mn.media.editor
		 *
		 * @returns {mn.media.view.MediaFrame} A media workflow.
		 */
		get: function( id ) {
			id = this.id( id );
			return workflows[ id ];
		},
		/**
		 * Remove the workflow represented by id from the workflow cache
		 *
		 * @param {string} id A slug used to identify the workflow.
		 *
		 * @this mn.media.editor
		 */
		remove: function( id ) {
			id = this.id( id );
			delete workflows[ id ];
		},
		/**
		 * @namespace
		 */
		send: {
			/**
			 * Called when sending an attachment to the editor
			 *   from the medial modal.
			 *
			 * @global mn.media.view.settings
			 * @global mn.media.post
			 *
			 * @param {Object} props Attachment details (align, link, size, etc).
			 * @param {Object} attachment The attachment object, media version of Post.
			 * @returns {Promise}
			 */
			attachment: function( props, attachment ) {
				var caption = attachment.caption,
					options, html;

				// If captions are disabled, clear the caption.
				if ( ! mn.media.view.settings.captions ) {
					delete attachment.caption;
				}

				props = mn.media.string.props( props, attachment );

				options = {
					id:           attachment.id,
					post_content: attachment.description,
					post_excerpt: caption
				};

				if ( props.linkUrl ) {
					options.url = props.linkUrl;
				}

				if ( 'image' === attachment.type ) {
					html = mn.media.string.image( props );

					_.each({
						align: 'align',
						size:  'image-size',
						alt:   'image_alt'
					}, function( option, prop ) {
						if ( props[ prop ] )
							options[ option ] = props[ prop ];
					});
				} else if ( 'video' === attachment.type ) {
					html = mn.media.string.video( props, attachment );
				} else if ( 'audio' === attachment.type ) {
					html = mn.media.string.audio( props, attachment );
				} else {
					html = mn.media.string.link( props );
					options.post_title = props.title;
				}

				return mn.media.post( 'send-attachment-to-editor', {
					nonce:      mn.media.view.settings.nonce.sendToEditor,
					attachment: options,
					html:       html,
					post_id:    mn.media.view.settings.post.id
				});
			},
			/**
			 * Called when 'Insert From URL' source is not an image. Example: YouTube url.
			 *
			 * @global mn.media.view.settings
			 *
			 * @param {Object} embed
			 * @returns {Promise}
			 */
			link: function( embed ) {
				return mn.media.post( 'send-link-to-editor', {
					nonce:     mn.media.view.settings.nonce.sendToEditor,
					src:       embed.linkUrl,
					link_text: embed.linkText,
					html:      mn.media.string.link( embed ),
					post_id:   mn.media.view.settings.post.id
				});
			}
		},
		/**
		 * Open a workflow
		 *
		 * @param {string} [id=undefined] Optional. A slug used to identify the workflow.
		 * @param {Object} [options={}]
		 *
		 * @this mn.media.editor
		 *
		 * @returns {mn.media.view.MediaFrame}
		 */
		open: function( id, options ) {
			var workflow;

			options = options || {};

			id = this.id( id );
			this.activeEditor = id;

			workflow = this.get( id );

			// Redo workflow if state has changed
			if ( ! workflow || ( workflow.options && options.state !== workflow.options.state ) ) {
				workflow = this.add( id, options );
			}

			mn.media.frame = workflow;

			return workflow.open();
		},

		/**
		 * Bind click event for .insert-media using event delegation
		 *
		 * @global mn.media.view.l10n
		 */
		init: function() {
			$(document.body)
				.on( 'click.add-media-button', '.insert-media', function( event ) {
					var elem = $( event.currentTarget ),
						editor = elem.data('editor'),
						options = {
							frame:    'post',
							state:    'insert',
							title:    mn.media.view.l10n.addMedia,
							multiple: true
						};

					event.preventDefault();

					// Remove focus from the `.insert-media` button.
					// Prevents Opera from showing the outline of the button
					// above the modal.
					//
					// See: https://core.trac.mtaandao.co.ke/ticket/22445
					elem.blur();

					if ( elem.hasClass( 'gallery' ) ) {
						options.state = 'gallery';
						options.title = mn.media.view.l10n.createGalleryTitle;
					}

					mn.media.editor.open( editor, options );
				});

			// Initialize and render the Editor drag-and-drop uploader.
			new mn.media.view.EditorUploader().render();
		}
	};

	_.bindAll( mn.media.editor, 'open' );
	$( mn.media.editor.init );
}(jQuery, _));
