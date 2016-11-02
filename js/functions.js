/* ==============================================
	Preload
=============================================== */
$ = jQuery.noConflict();
"use strict";

// array foreach prototype declare
(function(A) {

if (!Array.prototype.forEach) {
	A.forEach = A.forEach || function(action, that) {
		for (var i = 0, l = this.length; i < l; i++) {
			if (i in this) action.call(that, this[i], i, this);
		}
	};
}

})(Array.prototype);
$(window).load(function() { // makes sure the whole site is loaded
	$('#status').fadeOut(); // will first fade out the loading animation
	$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
	$('body').delay(350).css({'overflow':'visible'});
})
/* ==============================================
	Sticky nav
=============================================== */
$(window).scroll(function(){
	'use strict';
	if ($(this).scrollTop() > 1){  
		$('header').addClass("sticky");
	}
	else{
		$('header').removeClass("sticky");
	}
});

/* ==============================================
	Menu
=============================================== */
$('a.open_close').on("click",function() {
	$('.main-menu').toggleClass('show');
	$('.layer').toggleClass('layer-is-visible');
});
$('.menu-item-has-children > a').on("click",function(e) {
	e.preventDefault();
	$(this).next().toggleClass("show_normal");
	return false;
});
$('.menu-item-has-children-mega > a').on("click",function() {
	$(this).next().toggleClass("show_mega");
});
if($(window).width() <= 480){
	$('a.open_close').on("click",function() {
	$('.cmn-toggle-switch').removeClass('active')
});
}

$(window).bind('resize load',function(){
if( $(this).width() < 991 )
{
$('.collapse#collapseFilters').removeClass('in');
$('.collapse#collapseFilters').addClass('out');
}
else
{
$('.collapse#collapseFilters').removeClass('out');
$('.collapse#collapseFilters').addClass('in');
}
});
/* ==============================================
	Overaly mask form + incrementer
=============================================== */
$('.expose').on("click",function(e){
	"use strict";
	$('#overlay i.animate-spin').hide();
	$(this).css('z-index','100');
	$('#overlay').fadeIn(300);
});
$('#overlay').click(function(e){
	"use strict";
	$('#overlay i.animate-spin').show();
	$('#overlay').fadeOut(300, function(){
		$('.expose').css('z-index','1');
	});
});

/* ==============================================
	Common
=============================================== */

<!-- Tooltip -->	
$('.tooltip-1').tooltip({html:true});

//accordion
function toggleChevron(e) {
	$(e.target)
		.prev('.panel-heading')
		.find("i.indicator")
		.toggleClass('icon-plus icon-minus');
}
$('.panel-group').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);


/* ==============================================
	Animation on scroll
=============================================== */
new WOW().init();

/* ==============================================
	Video modal dialog + Parallax + Scroll to top + Incrementer
=============================================== */
$(function () {
'use strict';
$('.video').magnificPopup({type:'iframe'});	/* video modal*/
$('.parallax-window').parallax({}); /* Parallax modal*/
// Image popups

$('.magnific-gallery').each(function() {
	$(this).magnificPopup({
		delegate: 'a', 
		type: 'image',
		gallery:{enabled:true}
	});
}); 

$('.dropdown-menu').on("click",function(e) {e.stopPropagation();});  /* top drodown prevent close*/

/* Hamburger icon*/
var toggles = document.querySelectorAll(".cmn-toggle-switch"); 

  for (var i = toggles.length - 1; i >= 0; i--) {
	var toggle = toggles[i];
	toggleHandler(toggle);
  };

  function toggleHandler(toggle) {
	toggle.addEventListener( "click", function(e) {
	  e.preventDefault();
	  (this.classList.contains("active") === true) ? this.classList.remove("active") : this.classList.add("active");
	});
  };
  
  /* Scroll to top*/
  $(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();	
		} else {
			$('#toTop').fadeOut();
		}
	});
	$('#toTop').on("click",function() {
		$('body,html').animate({scrollTop:0},500);
	});
	
	/* Input incrementer*/
	$(".numbers-row").append('<div class="inc button_inc">+</div><div class="dec button_inc">-</div>');
	$(".numbers-row input").change(function(){
		if ( $(this).parent().attr("data-max") && $(this).val() > $(this).parent().data('max') ) {
			$(this).val( $(this).parent().data('max') );
		}
		if ( $(this).parent().attr("data-min") && $(this).val() < $(this).parent().data('min') ) {
			$(this).val( $(this).parent().data('min') );
		}
	});
	$(".button_inc").on("click", function () {

		var $button = $(this);
		var oldValue = $button.parent().find("input").val();

		if ($button.text() == "+") {
			var max_val = 9999;
			if ( $(this).parent().attr("data-max") ) {
				max_val = $(this).parent().data("max");
			}
			if (oldValue < max_val) {
				var newVal = parseFloat(oldValue) + 1;
			} else {
				newVal = max_val;
			}
		} else {
			// Don't allow decrementing below zero
			var min_val = 0;
			if ( $(this).parent().attr("data-min") ) {
				min_val = $(this).parent().data("min");
			}
			if (oldValue > min_val) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				if ( $(this).parent() )
				newVal = min_val;
			}
		}
		$button.parent().find("input").val(newVal).change();
	});
});

$(document).ready(function(){
	if ( $('.widget_recent_entries').length ) {
		$( '.widget_recent_entries > ul > li' ).each(function(index){
			$(this).children('.post-date').after($(this).children('a'));
		});
	}
	if ( $(".carousel").length ) {
		$(".carousel").owlCarousel({
			items : 4,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [979,3]
		});
	}
});

//reviews ajax loading
$('.guest-reviews .more-review').click(function() {
	$.ajax({
		url: ajaxurl,
		type: "POST",
		data: {
			'action': 'get_more_reviews',
			'post_id' : $(this).data('post_id'),
			'last_no' : $('.guest-review').length
		},
		success: function(response){
			if (response == '') {
				$('.more-review').remove();
			} else {
				$('.guest-reviews').append(response);
			}
		}
	});
	return false;
});

$('#review-form').submit(function() {
	$('#message-review').hide();
	var ajax_data = $(this).serialize();
	$.ajax({
		url: ajaxurl,
		type: "POST",
		data: ajax_data,
		success: function(response){
			if (response.success == 1) {
				$('#review-form').hide();
				$('#message-review').html(response.result);
				$('#myReviewLabel').html(response.title);
				$('#message-review').show();
			} else {
				$('#message-review').html(response.result);
				$('#message-review').show();
			}
		}
	});

	return false;
});

// load more button click action on search result page
$("body").on('click', '.btn-add-wishlist', function(e) {
	e.preventDefault();
	$('#overlay i.animate-spin').show();
	$('#overlay').show();
	var $t = $(this);
	$.ajax({
		url: ajaxurl,
		type: "POST",
		data: {
			'action' : 'add_to_wishlist',
			'post_id' : $(this).data('post-id')
		},
		success: function(response){
			if (response.success == 1) {
				$t.hide();
				$t.siblings('.btn-remove-wishlist').show();
			} else {
				alert(response.result);
			}
			$('#overlay').hide();
		}
	});
	return false;
});

// load more button click action on search result page
$("body").on('click', '.btn-remove-wishlist', function(e) {
	e.preventDefault();
	$('#overlay i.animate-spin').show();
	$('#overlay').show();
	var $t = $(this);
	$.ajax({
		url: ajaxurl,
		type: "POST",
		data: {
			'action' : 'add_to_wishlist',
			'post_id' : $(this).data('post-id'),
			'remove' : 1
		},
		success: function(response){
			if (response.success == 1) {
				$t.hide();
				$t.siblings('.btn-add-wishlist').show();
			} else {
				alert(response.result);
			}
			$('#overlay').hide();
		}
	});
	return false;
});

// filters on list page
$(document).ready(function(){
	$('.list-filter input').on( 'ifToggled', function(){
		var base_url = $(this).closest('ul').data('base-url').replace(/&amp;/g, '&');
		var new_url = base_url;
		var arg = $(this).closest('ul').data('arg');
		$(this).closest('ul').find('input:checked').each(function(index){
			if ( $(this).val() == -1 ) {new_url = base_url; return false;}
			new_url += '&' + arg + '[]=' + $(this).val();
		});
		if (new_url.indexOf("?") < 0) { new_url = new_url.replace(/&/, '?'); }
		window.location.href = new_url;
		return false;
	});
	$('#sort_price').change(function(){
		var base_url = $(this).data('base-url').replace(/&amp;/g, '&');
		if ( $(this).val() == "lower" ) {
			base_url += '&order_by=price&order=ASC';
		} else if ( $(this).val() == "higher" ) {
			base_url += '&order_by=price&order=DESC';
		}
		if (base_url.indexOf("?") < 0) { base_url = base_url.replace(/&/, '?'); }
		window.location.href = base_url;
		return false;
	});
	$('#sort_rating').change(function(){
		var base_url = $(this).data('base-url').replace(/&amp;/g, '&');
		if ( $(this).val() == "lower" ) {
			base_url += '&order_by=rating&order=ASC';
		} else if ( $(this).val() == "higher" ) {
			base_url += '&order_by=rating&order=DESC';
		}
		if (base_url.indexOf("?") < 0) { base_url = base_url.replace(/&/, '?'); }
		window.location.href = base_url;
		return false;
	});
});

$('.signup-btn').click(function(e) {
	e.preventDefault();
	$('.loginform').hide();
	$('.signupform').show();
	return false;
});

$('.login-btn').click(function(e) {
	e.preventDefault();
	$('.loginform').show();
	$('.signupform').hide();
	return false;
});

$('.cl-switcher').change(function(){
	window.location.href = $(this).find(":selected").data('url');
	return false;
});