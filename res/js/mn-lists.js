/* global ajaxurl, mnAjax */
(function($) {
var fs = {add:'ajaxAdd',del:'ajaxDel',dim:'ajaxDim',process:'process',recolor:'recolor'}, mnList;

mnList = {
	settings: {
		url: ajaxurl, type: 'POST',
		response: 'ajax-response',

		what: '',
		alt: 'alternate', altOffset: 0,
		addColor: null, delColor: null, dimAddColor: null, dimDelColor: null,

		confirm: null,
		addBefore: null, addAfter: null,
		delBefore: null, delAfter: null,
		dimBefore: null, dimAfter: null
	},

	nonce: function(e,s) {
		var url = mnAjax.unserialize(e.attr('href'));
		return s.nonce || url._ajax_nonce || $('#' + s.element + ' input[name="_ajax_nonce"]').val() || url._mnnonce || $('#' + s.element + ' input[name="_mnnonce"]').val() || 0;
	},

	/**
	 * Extract list item data from a DOM element.
	 *
	 * @param  {HTMLElement} e The DOM element.
	 * @param  {string}      t
	 * @return {array}
	 */
	parseData: function(e,t) {
		var d = [], mnListsData;

		try {
			mnListsData = $(e).attr('data-mn-lists') || '';
			mnListsData = mnListsData.match(new RegExp(t+':[\\S]+'));

			if ( mnListsData )
				d = mnListsData[0].split(':');
		} catch(r) {}

		return d;
	},

	pre: function(e,s,a) {
		var bg, r;

		s = $.extend( {}, this.mnList.settings, {
			element: null,
			nonce: 0,
			target: e.get(0)
		}, s || {} );

		if ( $.isFunction( s.confirm ) ) {
			if ( 'add' != a ) {
				bg = $('#' + s.element).css('backgroundColor');
				$('#' + s.element).css('backgroundColor', '#FF9966');
			}
			r = s.confirm.call(this, e, s, a, bg);

			if ( 'add' != a )
				$('#' + s.element).css('backgroundColor', bg );

			if ( !r )
				return false;
		}

		return s;
	},

	ajaxAdd: function( e, s ) {
		e = $(e);
		s = s || {};
		var list = this, data = mnList.parseData(e,'add'), es, valid, formData, res, rres;

		s = mnList.pre.call( list, e, s, 'add' );

		s.element = data[2] || e.attr( 'id' ) || s.element || null;

		if ( data[3] )
			s.addColor = '#' + data[3];
		else
			s.addColor = s.addColor || '#FFFF33';

		if ( !s )
			return false;

		if ( !e.is('[id="' + s.element + '-submit"]') )
			return !mnList.add.call( list, e, s );

		if ( !s.element )
			return true;

		s.action = 'add-' + s.what;

		s.nonce = mnList.nonce(e,s);

		es = $('#' + s.element + ' :input').not('[name="_ajax_nonce"], [name="_mnnonce"], [name="action"]');
		valid = mnAjax.validateForm( '#' + s.element );

		if ( !valid )
			return false;

		s.data = $.param( $.extend( { _ajax_nonce: s.nonce, action: s.action }, mnAjax.unserialize( data[4] || '' ) ) );
		formData = $.isFunction(es.fieldSerialize) ? es.fieldSerialize() : es.serialize();

		if ( formData )
			s.data += '&' + formData;

		if ( $.isFunction(s.addBefore) ) {
			s = s.addBefore( s );
			if ( !s )
				return true;
		}

		if ( !s.data.match(/_ajax_nonce=[a-f0-9]+/) )
			return true;

		s.success = function(r) {
			res = mnAjax.parseAjaxResponse(r, s.response, s.element);

			rres = r;

			if ( !res || res.errors )
				return false;

			if ( true === res )
				return true;

			jQuery.each( res.responses, function() {
				mnList.add.call( list, this.data, $.extend( {}, s, { // this.firstChild.nodevalue
					pos: this.position || 0,
					id: this.id || 0,
					oldId: this.oldId || null
				} ) );
			} );

			list.mnList.recolor();
			$(list).trigger( 'mnListAddEnd', [ s, list.mnList ] );
			mnList.clear.call(list,'#' + s.element);
		};

		s.complete = function(x, st) {
			if ( $.isFunction(s.addAfter) ) {
				var _s = $.extend( { xml: x, status: st, parsed: res }, s );
				s.addAfter( rres, _s );
			}
		};

		$.ajax( s );
		return false;
	},

	/**
	 * Delete an item in the list via AJAX.
	 *
	 * @param  {HTMLElement} e A DOM element containing item data.
	 * @param  {Object}      s
	 * @return {boolean}
	 */
	ajaxDel: function( e, s ) {
		e = $(e);
		s = s || {};
		var list = this, data = mnList.parseData(e,'delete'), element, res, rres;

		s = mnList.pre.call( list, e, s, 'delete' );

		s.element = data[2] || s.element || null;

		if ( data[3] )
			s.delColor = '#' + data[3];
		else
			s.delColor = s.delColor || '#faa';

		if ( !s || !s.element )
			return false;

		s.action = 'delete-' + s.what;

		s.nonce = mnList.nonce(e,s);

		s.data = $.extend(
			{ action: s.action, id: s.element.split('-').pop(), _ajax_nonce: s.nonce },
			mnAjax.unserialize( data[4] || '' )
		);

		if ( $.isFunction(s.delBefore) ) {
			s = s.delBefore( s, list );
			if ( !s )
				return true;
		}

		if ( !s.data._ajax_nonce )
			return true;

		element = $('#' + s.element);

		if ( 'none' != s.delColor ) {
			element.css( 'backgroundColor', s.delColor ).fadeOut( 350, function(){
				list.mnList.recolor();
				$(list).trigger( 'mnListDelEnd', [ s, list.mnList ] );
			});
		} else {
			list.mnList.recolor();
			$(list).trigger( 'mnListDelEnd', [ s, list.mnList ] );
		}

		s.success = function(r) {
			res = mnAjax.parseAjaxResponse(r, s.response, s.element);
			rres = r;

			if ( !res || res.errors ) {
				element.stop().stop().css( 'backgroundColor', '#faa' ).show().queue( function() { list.mnList.recolor(); $(this).dequeue(); } );
				return false;
			}
		};

		s.complete = function(x, st) {
			if ( $.isFunction(s.delAfter) ) {
				element.queue( function() {
					var _s = $.extend( { xml: x, status: st, parsed: res }, s );
					s.delAfter( rres, _s );
				}).dequeue();
			}
		};

		$.ajax( s );
		return false;
	},

	ajaxDim: function( e, s ) {
		if ( $(e).parent().css('display') == 'none' ) // Prevent hidden links from being clicked by hotkeys
			return false;

		e = $(e);
		s = s || {};

		var list = this, data = mnList.parseData(e,'dim'), element, isClass, color, dimColor, res, rres;

		s = mnList.pre.call( list, e, s, 'dim' );

		s.element = data[2] || s.element || null;
		s.dimClass =  data[3] || s.dimClass || null;

		if ( data[4] )
			s.dimAddColor = '#' + data[4];
		else
			s.dimAddColor = s.dimAddColor || '#FFFF33';

		if ( data[5] )
			s.dimDelColor = '#' + data[5];
		else
			s.dimDelColor = s.dimDelColor || '#FF3333';

		if ( !s || !s.element || !s.dimClass )
			return true;

		s.action = 'dim-' + s.what;

		s.nonce = mnList.nonce(e,s);

		s.data = $.extend(
			{ action: s.action, id: s.element.split('-').pop(), dimClass: s.dimClass, _ajax_nonce : s.nonce },
			mnAjax.unserialize( data[6] || '' )
		);

		if ( $.isFunction(s.dimBefore) ) {
			s = s.dimBefore( s );
			if ( !s )
				return true;
		}

		element = $('#' + s.element);
		isClass = element.toggleClass(s.dimClass).is('.' + s.dimClass);
		color = mnList.getColor( element );
		element.toggleClass( s.dimClass );
		dimColor = isClass ? s.dimAddColor : s.dimDelColor;

		if ( 'none' != dimColor ) {
			element
				.animate( { backgroundColor: dimColor }, 'fast' )
				.queue( function() { element.toggleClass(s.dimClass); $(this).dequeue(); } )
				.animate( { backgroundColor: color }, { complete: function() {
						$(this).css( 'backgroundColor', '' );
						$(list).trigger( 'mnListDimEnd', [ s, list.mnList ] );
					}
				});
		} else {
			$(list).trigger( 'mnListDimEnd', [ s, list.mnList ] );
		}

		if ( !s.data._ajax_nonce )
			return true;

		s.success = function(r) {
			res = mnAjax.parseAjaxResponse(r, s.response, s.element);
			rres = r;

			if ( true === res ) {
				return true;
			}

			if ( ! res || res.errors ) {
				element.stop().stop().css( 'backgroundColor', '#FF3333' )[isClass?'removeClass':'addClass'](s.dimClass).show().queue( function() { list.mnList.recolor(); $(this).dequeue(); } );
				return false;
			}

			if ( 'undefined' !== typeof res.responses[0].supplemental.comment_link ) {
				var submittedOn = element.find( '.submitted-on' ),
					commentLink = submittedOn.find( 'a' );

				// Comment is approved; link the date field.
				if ( '' !== res.responses[0].supplemental.comment_link ) {
					submittedOn.html( $('<a></a>').text( submittedOn.text() ).prop( 'href', res.responses[0].supplemental.comment_link ) );

				// Comment is not approved; unlink the date field.
				} else if ( commentLink.length ) {
					submittedOn.text( commentLink.text() );
				}
			}
		};

		s.complete = function(x, st) {
			if ( $.isFunction(s.dimAfter) ) {
				element.queue( function() {
					var _s = $.extend( { xml: x, status: st, parsed: res }, s );
					s.dimAfter( rres, _s );
				}).dequeue();
			}
		};

		$.ajax( s );
		return false;
	},

	getColor: function( el ) {
		var color = jQuery(el).css('backgroundColor');

		return color || '#ffffff';
	},

	add: function( e, s ) {
		if ( 'string' == typeof e ) {
			e = $( $.trim( e ) ); // Trim leading whitespaces
		} else {
			e = $( e );
		}

		var list = $(this), old = false, _s = { pos: 0, id: 0, oldId: null }, ba, ref, color;

		if ( 'string' == typeof s )
			s = { what: s };

		s = $.extend(_s, this.mnList.settings, s);

		if ( !e.length || !s.what )
			return false;

		if ( s.oldId )
			old = $('#' + s.what + '-' + s.oldId);

		if ( s.id && ( s.id != s.oldId || !old || !old.length ) )
			$('#' + s.what + '-' + s.id).remove();

		if ( old && old.length ) {
			old.before(e);
			old.remove();
		} else if ( isNaN(s.pos) ) {
			ba = 'after';

			if ( '-' == s.pos.substr(0,1) ) {
				s.pos = s.pos.substr(1);
				ba = 'before';
			}

			ref = list.find( '#' + s.pos );

			if ( 1 === ref.length )
				ref[ba](e);
			else
				list.append(e);

		} else if ( 'comment' != s.what || 0 === $('#' + s.element).length ) {
			if ( s.pos < 0 ) {
				list.prepend(e);
			} else {
				list.append(e);
			}
		}

		if ( s.alt ) {
			if ( ( list.children(':visible').index( e[0] ) + s.altOffset ) % 2 ) { e.removeClass( s.alt ); }
			else { e.addClass( s.alt ); }
		}

		if ( 'none' != s.addColor ) {
			color = mnList.getColor( e );
			e.css( 'backgroundColor', s.addColor ).animate( { backgroundColor: color }, { complete: function() { $(this).css( 'backgroundColor', '' ); } } );
		}
		list.each( function() { this.mnList.process( e ); } );
		return e;
	},

	clear: function(e) {
		var list = this, t, tag;

		e = $(e);

		if ( list.mnList && e.parents( '#' + list.id ).length )
			return;

		e.find(':input').each( function() {
			if ( $(this).parents('.form-no-clear').length )
				return;

			t = this.type.toLowerCase();
			tag = this.tagName.toLowerCase();

			if ( 'text' == t || 'password' == t || 'textarea' == tag )
				this.value = '';
			else if ( 'checkbox' == t || 'radio' == t )
				this.checked = false;
			else if ( 'select' == tag )
				this.selectedIndex = null;
		});
	},

	process: function(el) {
		var list = this,
			$el = $(el || document);

		$el.delegate( 'form[data-mn-lists^="add:' + list.id + ':"]', 'submit', function(){
			return list.mnList.add(this);
		});

		$el.delegate( 'a[data-mn-lists^="add:' + list.id + ':"], input[data-mn-lists^="add:' + list.id + ':"]', 'click', function(){
			return list.mnList.add(this);
		});

		$el.delegate( '[data-mn-lists^="delete:' + list.id + ':"]', 'click', function(){
			return list.mnList.del(this);
		});

		$el.delegate( '[data-mn-lists^="dim:' + list.id + ':"]', 'click', function(){
			return list.mnList.dim(this);
		});
	},

	recolor: function() {
		var list = this, items, eo;

		if ( !list.mnList.settings.alt )
			return;

		items = $('.list-item:visible', list);

		if ( !items.length )
			items = $(list).children(':visible');

		eo = [':even',':odd'];

		if ( list.mnList.settings.altOffset % 2 )
			eo.reverse();

		items.filter(eo[0]).addClass(list.mnList.settings.alt).end().filter(eo[1]).removeClass(list.mnList.settings.alt);
	},

	init: function() {
		var lists = this;

		lists.mnList.process = function(a) {
			lists.each( function() {
				this.mnList.process(a);
			} );
		};

		lists.mnList.recolor = function() {
			lists.each( function() {
				this.mnList.recolor();
			} );
		};
	}
};

$.fn.mnList = function( settings ) {
	this.each( function() {
		var _this = this;

		this.mnList = { settings: $.extend( {}, mnList.settings, { what: mnList.parseData(this,'list')[1] || '' }, settings ) };
		$.each( fs, function(i,f) { _this.mnList[i] = function( e, s ) { return mnList[f].call( _this, e, s ); }; } );
	} );

	mnList.init.call(this);

	this.mnList.process();

	return this;
};

})(jQuery);
