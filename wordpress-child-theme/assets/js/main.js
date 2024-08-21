(function ($) {
    var adminbar = 0;
    if ($('#wpadminbar').length) {
        adminbar = $('#wpadminbar').height();
    }

    // Scroll Top Nav Items whaich has targetd item are ID's
    $(document).on('click', 'a[href*="#"]:not(.skip-main)', function (e) {
        // Check if the href is on the same page
        if (this.pathname == window.location.pathname) {
            e.stopImmediatePropagation();
            e.preventDefault();
            // let headerHeight = $('header').height();
            let headerHeight = $('header').height();
            let targetId = $(this).attr('href').split('#')[1];
            let targetElement = $('#' + targetId);
            if (targetElement.length) {
                $('html, body').animate({
                    scrollTop: targetElement.offset().top - headerHeight
                }, 500);
            }
        }
    });

    $(document).ready(function () {
        $('.header-toggle-icon').on('click', function () {
            $('.site-nav .menu').slideToggle();
            $('body').toggleClass('overflow-hidden');
        });
        $('.site-nav .menu a').on('click', function() {
            if (window.matchMedia("(max-width: 1024px)").matches == true) {
                if ($(this).attr('href').startsWith('#')) {
                    $('.site-nav .menu').slideUp();
                    $('body').removeClass('overflow-hidden');
                }
            }
        });

        $('.back-top').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 'slow');
        });

        // Services Slider
        $('.services-slider-wrapper').append(`
            <div class="slider-controlls"> 
            <div class="slider-nav-btn service-slide-previous slider-arrow-previous"></div>
                <div class="slider-pagination service-pagination"></div>
                <div class="slider-nav-btn service-slide-next slider-arrow-next"></div>
            </div>
        `);
        let cs_swiper;
        if ($(".services-slider-wrapper").length) {
            $(".services-slider-wrapper").addClass("swiper");
            $(".services-slider-wrapper > .e-con-inner").addClass("swiper-wrapper");
            $(".services-slider-wrapper > .e-con-inner > .elementor-element").addClass("swiper-slide");
                cs_swiper = new Swiper(".services-slider-wrapper", {
                    slidesPerView: 1.18,
                    loop: false,
                    spaceBetween: 15,
                    grabCursor: true,
                    pagination: {
                        el: ".service-pagination",
                        clickable: true,
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2.3,
                            spaceBetween: 25,
                        },
                    },
                    navigation: {
                        nextEl: ".service-slide-next",
                        prevEl: ".service-slide-previous",
                    },
                });
        }

    });

    $(window).on('resize load', function () {
        if (window.matchMedia("(max-width: 1024px)").matches == true) {

            // Header Sticky top Value and Dropw height Calculation code
            let headerHeight = $('header').height() + adminbar;
            console.log(headerHeight)
            $('.site-nav .menu').css('top', headerHeight + 'px');
            $('.site-nav .menu').css('height', 'calc(100vh - ' + headerHeight + 'px)');

        }
    });

}(jQuery))
