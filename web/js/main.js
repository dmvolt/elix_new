$(function() {

	// Replace all SVG images with inline SVG
	$('.js-svg').each(function(){
		var $img = $(this);
		var imgID = $img.attr('id');
		var imgClass = $img.attr('class');
		var imgURL = $img.attr('src');

		$.get(imgURL, function(data) {
			var $svg = $(data).find('svg');
			if (typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}
			if (typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass+' js-svg--replaced');
			}
			$svg = $svg.removeAttr('xmlns:a');
			$img.replaceWith($svg);
		});
	});

	//ripple button effect
	$('.js-ripple').on('click', function (event) {
		// event.preventDefault();

		var btnOffset = $(this).offset(),
		xPos = event.pageX - btnOffset.left - 25,
		yPos = event.pageY - btnOffset.top - 25,
		$div = $('<div class="js-ripple__effect" style="top:' + yPos + 'px; left:' + xPos + 'px;"></div>');

		$div.appendTo($(this));

		window.setTimeout(function(){
			$div.remove();
		}, 2000);
	});

	// menu icon
	var iconMenu = new svgIcon( document.querySelector('.si-icon-hamburger-cross'), svgIconConfig);

	$('.js-menu-button').click(function(){
		$('#js-mobile-menu').toggleClass('active');
		iconMenu.toggle(true);
	});

	$('body').bind( 'touchstart click', function(e){
		if (e.target.id != 'menu' && !$('#js-mobile-menu').find(e.target).length) {
			$("#js-mobile-menu").removeClass('active');
			if (iconMenu.toggled) {
				iconMenu.toggle (true);
			}
		}
	});

	// toggle
	$('.js-toggle-button').click(function(e){
		e.preventDefault();
		var $this = $(this);
		var target = $this.attr('data-target');
		var toggle = $('.js-toggle');
		$('.js-toggle-button').removeClass('js-toggle-button--active');
		$(this).addClass('js-toggle-button--active');

		if ($(target).hasClass('js-toggle--active')) {
			$(target).removeClass('js-toggle--active')
			$(this).removeClass('js-toggle-button--active');
		} else {
			$(toggle).removeClass('js-toggle--active');
			$(target).addClass('js-toggle--active');
		}
	});

	// lavalamp
	$('#js-lava').lavalamp({
		autoUpdate: true,
		updateTime: 1000
	});

	// swiper
	var swiper = new Swiper('.js-swiper', {
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		effect: 'fade',
		autoplay: 5000,
		loop: true,
		simulateTouch: false
	});

	var swiperCarousel = new Swiper('.js-swiper-carousel', {
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		slidesPerView: 3,
		spaceBetween: 30,
		loop: true,

		breakpoints: {
			980: {
			slidesPerView: 2,
			spaceBetween: 20
			}
		}
	});

	//popup
	$('.js-popup-image').magnificPopup({
		type:'image',
		gallery:{
			enabled:true
		},

		image: {
			markup: '<div class="mfp-figure">'+
			'<div class="mfp-close"></div>'+
			'<div class="mfp-img"></div>'+
			'</div>'
		}
	});

	$('.js-popup-inline').magnificPopup({
		removalDelay: 500,
		callbacks: {
			beforeOpen: function() {
				this.st.mainClass = this.st.el.attr('data-effect');
			}
		},
		midClick: true
	});

	// resize handler
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();

	$(window).resize(function() {
		delay(function(){
			// console.log('resized');
		}, 100);
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