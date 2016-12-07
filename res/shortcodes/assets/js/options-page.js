// Wait DOM
jQuery(document).ready(function($) {
	// ########## About screen ##########
	$('.sm-demo-video').magnificPopup({
		type: 'iframe',
		callbacks: {
			open: function() {
				// Change z-index
				$('body').addClass('sm-mfp-shown');
			},
			close: function() {
				// Change z-index
				$('body').removeClass('sm-mfp-shown');
			}
		}
	});
	// ########## Custom CSS screen ##########
	$('.sm-custom-css-originals a').magnificPopup({
		type: 'iframe',
		callbacks: {
			open: function() {
				// Change z-index
				$('body').addClass('sm-mfp-shown');
			},
			close: function() {
				// Change z-index
				$('body').removeClass('sm-mfp-shown');
			}
		}
	});
	// Enable ACE editor
	if ($('#sunrise-field-custom-css-editor').length > 0) {
		var editor = ace.edit('sunrise-field-custom-css-editor'),
			$textarea = $('#sunrise-field-custom-css').hide();
		editor.getSession().setValue($textarea.val());
		editor.getSession().on('change', function() {
			$textarea.val(editor.getSession().getValue());
		});
		editor.getSession().setMode('ace/mode/css');
		editor.setdesign('ace/design/monokai');
		editor.getSession().setUseWrapMode(true);
		editor.getSession().setWrapLimitRange(null, null);
		editor.renderer.setShowPrintMargin(null);
		editor.session.setUseSoftTabs(null);
	}
	// ########## Add-ons screen ##########
	var addons_timer = 0;
	$('.sm-addons-item').each(function() {
		var $item = $(this),
			delay = 300;
		$item.click(function(e) {
			window.open($(this).data('url'));
			e.preventDefault();
		});
		addons_timer = addons_timer + delay;
		window.setTimeout(function() {
			$item.addClass('animated bounceIn').css('visibility', 'visible');
		}, addons_timer);
	});
	// ########## Examples screen ##########
	// Disable all buttons
	$('#sm-examples-preview').on('click', '.sm-button', function(e) {
		if ($(this).hasClass('sm-example-button-clicked')) alert(sm_options_page.not_clickable);
		else $(this).addClass('sm-example-button-clicked');
		e.preventDefault();
	});
	var open = $('#sm_open_example').val(),
		nonce = $('#sm_examples_nonce').val(),
		$example_window = $('#sm-examples-window'),
		$example_preview = $('#sm-examples-preview');
	$('.sm-examples-group-title, .sm-examples-item').each(function() {
		var $item = $(this),
			delay = 200;
		if ($item.hasClass('sm-examples-item')) {
			$item.on('click', function(e) {
				var code = $(this).data('code'),
					id = $(this).data('id');
				$item.magnificPopup({
					type: 'inline',
					alignTop: true,
					callbacks: {
						open: function() {
							// Change z-index
							$('body').addClass('sm-mfp-shown');
						},
						close: function() {
							// Change z-index
							$('body').removeClass('sm-mfp-shown');
							$example_preview.html('');
						}
					}
				});
				var sm_example_preview = $.ajax({
					url: ajaxurl,
					type: 'get',
					dataType: 'html',
					data: {
						action: 'sm_example_preview',
						code: code,
						id: id,
						nonce: nonce
					},
					beforeSend: function() {
						if (typeof sm_example_preview === 'object') sm_example_preview.abort();
						$example_window.addClass('sm-ajax');
						$item.magnificPopup('open');
					},
					success: function(data) {
						$example_preview.html(data);
						$example_window.removeClass('sm-ajax');
					}
				});
				e.preventDefault();
			});
			// Open preselected example
			if ($item.data('id') === open) $item.trigger('click');
		}
	});
	$('#sm-examples-window').on('click', '.sm-examples-get-code', function(e) {
		$(this).hide();
		$(this).parent('.sm-examples-code').children('textarea').slideDown(300);
		e.preventDefault();
	});
	// ########## Cheatsheet screen ##########
	$('.sm-cheatsheet-switch').on('click', function(e) {
		$('body').toggleClass('sm-print-cheatsheet');
		e.preventDefault();
	});
});