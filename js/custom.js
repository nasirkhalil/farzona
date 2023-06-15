/*---FULL HEIGHT BANNER SIZE---*/
$(function(){
  $('.banner').css({'height':($(window).height())+'px'});

  // RESIZE THE HEIGHT IF THE WINDOW IS RESIZED
  $(window).resize(function(){
    $('.banner').css({'height':($(window).height())+'px'});

  });
});
/*--------*/
(function($){
	$(document).ready(function(){
		var galLink = $("a.gal_link");
		galLink.lightbox();
	});
	
})(jQuery);
/*---------------*/
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
/*------------------*/
 $(window).load(function() {
		$(".se-pre-con").fadeOut("slow");;
	});
/*--------------------------*/
	var swiper = new Swiper('.swiper1', {
 	  slidesPerView: 3,
      spaceBetween: 20,
		 observer: true,
	  observeParents: true,
		navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
		  breakpoints: {
        1024: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        640: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        320: {
          slidesPerView: 1,
          spaceBetween: 0,
        }
      }
		
    });
/*--------*/
	var swiper = new Swiper('.swiper2', {
 	  slidesPerView: 6,
      spaceBetween: 15,
		 observer: true,
	  observeParents: true,
		navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
		  breakpoints: {
        1024: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        320: {
          slidesPerView: 1,
          spaceBetween: 0,
        }
      }
		
    });