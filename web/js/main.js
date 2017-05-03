$(function() {

	// initialize svg animation icons
	// [].slice.call( document.querySelectorAll( '.si-icon' ) ).forEach( function( el ) {
	// 	var svgicon = new svgIcon( el, svgIconConfig );
	// } );

	var iconMenu = new svgIcon( document.querySelector('.si-icon-hamburger-cross'), svgIconConfig);

	$('.js-menu-button').click(function(){
		$('#menu').toggleClass('active');
		iconMenu.toggle (true);
	});

	$('body').bind( 'touchstart click', function(e){
		if (e.target.id != 'menu' && !$('#menu').find(e.target).length) {
			$("#menu").removeClass('active');
			if (iconMenu.toggled) {
				iconMenu.toggle (true);
			}
		}
	});

	// Replace all SVG images with inline SVG
	$('.js-svg').each(function(){
		var $img = $(this);
		var imgID = $img.attr('id');
		var imgClass = $img.attr('class');
		var imgURL = $img.attr('data');

		$.get(imgURL, function(data) {
			var $svg = $(data).find('svg');
			if (typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}
			if (typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass+' replaced-svg');
			}
			$svg = $svg.removeAttr('xmlns:a');
			$img.replaceWith($svg);
		});
	});

	var sticker = $("#js-sticker").sticky({topSpacing:0});

// swiper
var sliderSwiper = new Swiper('.js-slider', {
	pagination: '.swiper-slider__pagination',
	// effect: 'fade',
	autoplay: 5000,
	paginationClickable: true,
	simulateTouch: false
});

// parallax
$('.js-parallax').parallaxify({
	responsive: true,
	positionProperty: 'transform',
});

// header menu
// $('.js-tab').click(function(){
// 	var $this = $(this);
// 	var target = $this.attr('data-target');
//
// 	$('.js-tab, .js-menu, .js-page').removeClass('js-active');
// 	$this.addClass('js-active');
// 	$(target).addClass('js-active');
// 	$('.js-icon').toggleClass('js-active');
// 	$("html, body").animate({ scrollTop: 0 });
// });

// mobile menu
// $('.js-mobile-menu').click(function(){
// 	$('.header__nav-mobile').addClass('header__nav-mobile_active');
// });
//
// $('.js-mobile-close').click(function(){
// 	$('.header__nav-mobile').removeClass('header__nav-mobile_active');
// });

// service dropdown position
var serviceDropdown = function() {
	$('.js-dropdown').each(function(){
		var $this = $(this);
		var top = $this.parent().outerHeight() + $this.parents('.service__item').position().top + 8;
		var left = $this.parents('.service__item').position().left + 1;
		var count = $this.children('.service__dropdown__li').index();
		var width = $this.outerWidth();
		var contWidth = $this.parents('.service').outerWidth();

		if (count > 10) {
			$this.addClass('service__dropdown_double');
			width = $this.width();
		}

		if (left + width > contWidth) {
			left = contWidth - width;
		}

		$this.css('top', top + 'px');
		$this.css('left', left + 'px');
	})
}

$(window).load(function(){
	serviceDropdown();
})

serviceDropdown();

// magnific-popup lightbox
$('.img-popup').magnificPopup({
	type:'image',
	cursor: null,
	gallery:{
		enabled:true,
		tPrev: 'Назад',
		tNext: 'Далее',
		tCounter: '<span class="mfp-counter">%curr% из %total%</span>'
	}
});

	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();

	$(window).resize(function() {
		delay(function(){
			serviceDropdown();
			// console.log('resized!');

			if ($(window).height() < 730) {
				sticker.unstick();
			}

			if ($(window).height() >= 730) {
				sticker.sticky({topSpacing:0});
			}
		}, 200);
	});
});

$(document).ready(function() {
	// Валидация формы вопрос - ответ
	$("#faq_form").validate({
		errorClass: "form__group_error",
		errorElement: "label",
		rules: {
			name:{
				required: true,
				minlength: 1,
				maxlength: 64
			},
			email:{
				required: true,
				email: true
			},
			text:{
				required: true,
				minlength: 10,
				maxlength: 2000
			}
		},
		messages: {
			name:{
				required: 'Пожалуйста, заполните это поле.',
				minlength: 'Минимальное количество символов - 1',
				maxlength: 'Максимальное количество символов - 64'
			},
			email:{
				required: 'Пожалуйста, заполните это поле.',
				email: 'Некорректный e-mail адрес.'
			},
			text:{
				required: 'Пожалуйста, заполните это поле.',
				minlength: 'Минимальное количество символов - 10',
				maxlength: 'Максимальное количество символов - 2000'
			}
		},
		submitHandler: function(form) {
			sendFaq(form);
		}
	});

	// Валидация формы отзывов
	$("#reviews_form").validate({
		errorClass: "form__group_error",
		errorElement: "label",
		rules: {
			name:{
				required: true,
				minlength: 1,
				maxlength: 64
			},
			text:{
				required: true,
				minlength: 10,
				maxlength: 2000
			}
		},
		messages: {
			name:{
				required: 'Пожалуйста, заполните это поле.',
				minlength: 'Минимальное количество символов - 1',
				maxlength: 'Максимальное количество символов - 64'
			},
			text:{
				required: 'Пожалуйста, заполните это поле.',
				minlength: 'Минимальное количество символов - 10',
				maxlength: 'Максимальное количество символов - 2000'
			}
		},
		submitHandler: function(form) {
			sendReview(form);
		}
	});

	// Валидация формы заказов сертификатов
	$("#sert_form").validate({
		errorClass: "form__group_error",
		errorElement: "label",
		rules: {
			sert_name:{
				required: true,
				minlength: 1,
				maxlength: 64
			},
			sert_email:{
				required: true,
				email: true
			},
			sert_phone:{
				required: true,
				maxlength: 12
			},
			sert_code:{
				required: true
			},
			sert_address:{
				maxlength: 2000
			},
			sert_address2:{
				maxlength: 2000
			}
		},
		messages: {
			sert_name:{
				required: 'Пожалуйста, заполните это поле.',
				minlength: 'Минимальное количество символов - 1',
				maxlength: 'Максимальное количество символов - 64'
			},
			sert_email:{
				required: 'Пожалуйста, заполните это поле.',
				email: 'Некорректный e-mail адрес.'
			},
			sert_phone:{
				required: 'Пожалуйста, заполните это поле.',
				maxlength: 'Максимальное количество символов - 12'
			},
			sert_code:{
				required: 'Пожалуйста, выберите сертификат.'
			},
			sert_address:{
				maxlength: 'Максимальное количество символов - 2000'
			},
			sert_address2:{
				maxlength: 'Максимальное количество символов - 2000'
			}
		},
		submitHandler: function(form) {
			checkSert(form);
		}
	});
});

function checkSert(form)
{
	var form_data = $(form).serialize();
	$.ajax({
		type: "POST",
		data: form_data,
		url: "/ajaxorder/check_sert",
		dataType: "json",
		beforeSend: function() {
			$(".loading").show();
		},
		complete: function() {
			$(".loading").hide();
		},
		success: function(data)
		{
			if(data.result)
			{
				if(data.payment){
					window.location = data.payment;
				} else {
					$('#sert_name').val('');
					$('#sert_email').val('');
					$('#sert_phone').val('');
					$('#sert_address').val('');
					$('#sert_address2').val('');
					$('#sert_form_thanks').html('<h2 class="otvet_yes">Ваш заказ успешно отправлен!</h2>');
				}
			} else {
				$("#sert_form_thanks").html('<p class="otvet_no">Ошибка в заполнении полей сообщения.</p>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}

function sendFaq(form)
{
	var data = $(form).serialize();
	$.ajax({
		type: "POST",
		data: data,
		url: "/feedback/faq",
		dataType: "json",
		beforeSend: function() {
			$(".loading").show();
		},
		complete: function() {
			$(".loading").hide();
		},
		success: function(data)
		{
			if(data.result)
			{
				$('#faq_form_name').val('');
				$('#faq_form_email').val('');
				$('#faq_form_text').val('');
				$("#faq_form_thanks").html('<h2 class="otvet_yes">Спасибо за Ваш вопрос!<br>Мы получили Ваше сообщение и в ближайшее время ответим на него.</h2>');
			}
			else
			{
				if(data.errors){
					$("#faq_form_thanks").html('<p class="otvet_no">' + data.errors + '</p>');
				} else {
					$("#faq_form_thanks").html('<p class="otvet_no">Ошибка в заполнении полей сообщения.</p>');
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}

function sendReview(form)
{
	var data = $(form).serialize();
	$.ajax({
		type: "POST",
		data: data,
		url: "/feedback/reviews",
		dataType: "json",
		beforeSend: function() {
			$(".loading").show();
		},
		complete: function() {
			$(".loading").hide();
		},
		success: function(data)
		{
			if(data.result)
			{
				$('#reviews_form_name').val('');
				$('#reviews_form_text').val('');
				$("#reviews_form_thanks").html('<h2 class="otvet_yes">Спасибо за Ваш отзыв!<br>Мы получили Ваш отзыв и опубликуем его в ближайшее время.</h2>');
			}
			else
			{
				if(data.errors){
					$("#reviews_form_thanks").html('<p class="otvet_no">' + data.errors + '</p>');
				} else {
					$("#reviews_form_thanks").html('<p class="otvet_no">Ошибка в заполнении полей сообщения.</p>');
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}