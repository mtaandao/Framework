jQuery(document).ready(function ($) {
	// Prepare items arrays for lightbox
	$('.sm-lightbox-gallery').each(function () {
		var slides = [];
		$(this).find('.sm-slider-slide, .sm-carousel-slide, .sm-custom-gallery-slide').each(function (i) {
			$(this).attr('data-index', i);
			slides.push({
				src: $(this).children('a').attr('href'),
				title: $(this).children('a').attr('title')
			});
		});
		$(this).data('slides', slides);
	});
	// Enable sliders
	$('.sm-slider').each(function () {
		// Prepare data
		var $slider = $(this);
		// Apply Swiper
		var $swiper = $slider.swiper({
			wrapperClass: 'sm-slider-slides',
			slideClass: 'sm-slider-slide',
			slideActiveClass: 'sm-slider-slide-active',
			slideVisibleClass: 'sm-slider-slide-visible',
			pagination: '#' + $slider.attr('id') + ' .sm-slider-pagination',
			autoplay: $slider.data('autoplay'),
			paginationClickable: true,
			grabCursor: true,
			mode: 'horizontal',
			mousewheelControl: $slider.data('mousewheel'),
			speed: $slider.data('speed'),
			calculateHeight: $slider.hasClass('sm-slider-responsive-yes'),
			loop: true
		});
		// Prev button
		$slider.find('.sm-slider-prev').click(function (e) {
			$swiper.swipeNext();
		});
		// Next button
		$slider.find('.sm-slider-next').click(function (e) {
			$swiper.swipePrev();
		});
	});
	// Enable carousels
	$('.sm-carousel').each(function () {
		// Prepare data
		var $carousel = $(this),
			$slides = $carousel.find('.sm-carousel-slide');
		// Apply Swiper
		var $swiper = $carousel.swiper({
			wrapperClass: 'sm-carousel-slides',
			slideClass: 'sm-carousel-slide',
			slideActiveClass: 'sm-carousel-slide-active',
			slideVisibleClass: 'sm-carousel-slide-visible',
			pagination: '#' + $carousel.attr('id') + ' .sm-carousel-pagination',
			autoplay: $carousel.data('autoplay'),
			paginationClickable: true,
			grabCursor: true,
			mode: 'horizontal',
			mousewheelControl: $carousel.data('mousewheel'),
			speed: $carousel.data('speed'),
			slidesPerView: ($carousel.data('items') > $slides.length) ? $slides.length : $carousel.data('items'),
			slidesPerGroup: $carousel.data('scroll'),
			calculateHeight: $carousel.hasClass('sm-carousel-responsive-yes'),
			loop: true
		});
		// Prev button
		$carousel.find('.sm-carousel-prev').click(function (e) {
			$swiper.swipeNext();
		});
		// Next button
		$carousel.find('.sm-carousel-next').click(function (e) {
			$swiper.swipePrev();
		});
	});
	// Enable lightbox
	$('.sm-lightbox-gallery').on('click', '.sm-slider-slide, .sm-carousel-slide, .sm-custom-gallery-slide', function (e) {
		e.preventDefault();
		var slides = $(this).parents('.sm-lightbox-gallery').data('slides');
		$.magnificPopup.open({
			items: slides,
			type: 'image',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1],
				tPrev: sm_magnific_popup.prev,
				tNext: sm_magnific_popup.next,
				tCounter: sm_magnific_popup.counter
			},
			tClose: sm_magnific_popup.close,
			tLoading: sm_magnific_popup.loading
		}, $(this).data('index'));
	});
});