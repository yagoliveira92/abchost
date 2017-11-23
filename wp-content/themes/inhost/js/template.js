(function ($) {
    "use strict";

    /** PANEL FUNCTION **/
    var colorSetting = '';
    var defaultSetting = '';
    var timeout = 0;
    var html = '';
    var clickOutSite = false;
	
    function panel_setting() {
        $.ajax({
            type: "GET",
            url: inwaveCfg.baseUrl + '/wp-content/themes/inhost/css/color.css',
            dataType: "html",
            success: function (result) {
                colorSetting = result;
            }
        });
        $('.color-setting button').each(function () {
            if (this.value[0] == '#') {
                $(this).css('background-color', this.value);
            } else {
                $(this).css('background', 'url(' + this.value + ')');
            }
        });
        $('body').append('<style type="text/css" id="color-setting"></style>');
        panelBindEvents();
        panelLoadSetting();
    }

    function panelBindEvents() {
        var clickOutSite = true;
        $('.panel-button').click(function () {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                $('.panel-content').show().animate({
                    'margin-left': 0
                }, 400, 'easeInOutExpo');
            } else {
                $(this).removeClass('active');
                $('.panel-content').animate({
                    'margin-left': '-240px'
                }, 400, 'easeInOutExpo', function () {
                    $('.panel-content').hide()
                });
            }
            clickOutSite = false;
            setTimeout(function () {
                clickOutSite = true;
            }, 100);
        });
        $('.panel-content').click(function () {
            clickOutSite = false;
            setTimeout(function () {
                clickOutSite = true;
            }, 100);
        });
        $(document).click(function () {
            if (clickOutSite && $('.panel-button').hasClass('active')) {
                $('.panel-button').trigger('click');
            }
        });

        $('.button-command-layout').click(function () {
            if (!$(this).hasClass('active')) {
                $('.button-command-layout').removeClass('active');
                $(this).addClass('active');
                panelAddOverlay();
                panelWriteSetting();
                $(window).resize();
            }
        });
        $('.button-command-style').click(function () {
            if (!$(this).hasClass('active')) {
                $('.button-command-style').removeClass('active');
                $(this).addClass('active');
                if ($(this).hasClass('dark')) {
                    $('body').addClass('index-dark');
                    $('head').append('<link id="theme-dark-css" rel="stylesheet" type="text/css" href="' + inwaveCfg.baseUrl + '/wp-content/themes/inhost/css/dark.css' + '">');
                } else {
                    $('body').removeClass('index-dark');
                    $('#theme-dark-css').remove();
                }
                $('body').addClass('active');
                panelWriteSetting();
            }
        });
        $('.background-setting button').click(function () {
            if ($('.button-command-layout.active').val() == 'wide') {
                return;
            }
            if (!$(this).hasClass('active')) {
                $('.background-setting button').removeClass('active');
                $(this).addClass('active');
                if (this.value[0] == '#') {
                    $('body').css('background', this.value);
                } else {
                    $('body').css('background', 'url(' + this.value + ')');
                }
                panelWriteSetting();
            }
        });
        $('.sample-setting button').click(function () {
            if (!$(this).hasClass('active')) {
                $('.sample-setting button').removeClass('active');
                $(this).addClass('active');
                var newColorSetting = colorSetting.replace(/#49a32b/g, this.value);
                $('#color-setting').html(newColorSetting);
                panelWriteSetting();
            }
        });
        $('.reset-button button').click(function () {
            panelApplySetting(defaultSetting);
            setCookie('layoutsetting', '');
            if ($('.rtl-setting .active').attr('data-value') == 'rtl') {
                var link;
                if (document.location.href.indexOf('=rtl') > 0) {
                    link = document.location.href.replace(/=rtl/, '=ltr')
                } else {
                    if (document.location.href.indexOf('&') > 0) {
                        link = document.location.href + '&d=ltr';
                    } else {
                        link = document.location.href + '?d=ltr';
                    }
                }
                document.location.href = link;
            }
        });
    }

    function panelAddOverlay() {
        if ($('.button-command-layout.active').hasClass('boxed')) {
            $('.overlay-setting').removeClass('disabled');
            $('body').addClass('body-boxed');
        } else {
            $('.overlay-setting').addClass('disabled');
            $('body').removeClass('body-boxed');
        }
    }

    function panelLoadSetting() {
        // remember default setting
        defaultSetting = getCookie('layoutsetting-default');
        if (defaultSetting) {
            defaultSetting = JSON.parse(defaultSetting);
        } else {
            defaultSetting = {
                layout: $('.button-command-layout.active').val(),
                themeStyle: $('.button-command-style.active').val(),
                mainColor: $('.sample-setting button.active').val(),
                bgColor: $('.background-setting button.active').val()
            }
            setCookie('layoutsetting-default', JSON.stringify(defaultSetting), 0);
        }
    }

    function panelApplySetting(setting) {
        $('.button-command-layout').each(function () {
            if (setting.layout == this.value) {
                $(this).trigger('click');
            }
        });
        $('.button-command-style').each(function () {
            if (setting.themeStyle == this.value) {
                $(this).trigger('click');
            }
        });
        $('.sample-setting button').each(function () {
            if (setting.mainColor == this.value) {
                $(this).trigger('click');
            }
        });
        $('.background-setting button').each(function () {
            if (setting.bgColor == this.value) {
                $(this).trigger('click');
            }
        });
    }

    function panelWriteSetting() {
        var activeSetting = {
            layout: $('.button-command-layout.active').val(),
            themeStyle: $('.button-command-style.active').val(),
            mainColor: $('.sample-setting button.active').val(),
            bgColor: $('.background-setting button.active').val()
        }
        setCookie('layoutsetting', JSON.stringify(activeSetting), 0);
    }

    /** COOKIE FUNCTION */
    function setCookie(cname, cvalue, exdays) {
        var expires = "";
        if (exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            expires = " expires=" + d.toUTCString();
        }
        document.cookie = cname + "=" + cvalue + ";" + expires + '; path=/';
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }

    window.iwOpenWindow = function (url) {
        window.open(url, 'sharer', 'toolbar=0,status=0,left=' + ((screen.width / 2) - 300) + ',top=' + ((screen.height / 2) - 200) + ',width=650,height=380');
        return false;
    }

    /** theme prepare data */
    function theme_init() {
        $('.ibutton span').each(function () {
            $(this).attr('data-hover', $(this).text());
        });
        $('.back-to-top a').click(function (event) {
            $('html, body').stop().animate({
                scrollTop: 0
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });

        /** hash link scroll */
        $('.wrapper').on('click', 'a', function (e) {
            var anchor = $(this).attr('href');
			if(anchor){
				anchor = anchor.substr(anchor.indexOf('#'));
				if (!$(this).hasClass('ui-tabs-anchor') && anchor.indexOf('#') >= 0 && $(anchor).length && !$(anchor).hasClass('vc_tta-panel')) {
					var top = $(anchor).offset().top;
					$('html, body').animate({
						scrollTop: top - 90
					}, 'slow');
					e.preventDefault();
				} else {
					if (anchor == '#') {
						e.preventDefault();
					}
				}
			}
        });
    }

    /**
     parallax effect */
    function parallax_init() {
        $('.iw-parallax').each(function () {
            $(this).css({
                'background-repeat': 'no-repeat',
                'background-attachment': 'fixed',
                'background-size': '100% auto',
                'overflow': 'hidden'
            }).parallax("50%", $(this).attr('data-iw-paraspeed'));
        });
        $('.iw-parallax-video').each(function () {
            $(this).parent().css({"height": $(this).attr('data-iw-paraheight'), 'overflow': 'hidden'});
            $(this).parallaxVideo("50%", $(this).attr('data-iw-paraspeed'));
        });
    };

    /**
     * Carousel
     */
    function carousel_init() {
        $(".owl-carousel").each(function () {
            var slider = $(this);
            var defaults = {
                direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr'
            }
            var config = $.extend({}, defaults, slider.data("plugin-options"));
            // Initialize Slider
            slider.owlCarousel(config).addClass("owl-carousel-init");
        });

        $('.featured-image .gallery,.post-text .gallery').each(function () {
            var galleryOwl = $(this);
            var classNames = this.className.toString().split(' ');
            var column = 1;
            $.each(classNames, function (i, className) {
                if (className.indexOf('gallery-columns-') != -1) {
                    column = parseInt(className.replace(/gallery-columns-/, ''));
                }
            });
            galleryOwl.owlCarousel({
                direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
                items: column,
                singleItem: column == 1,
                navigation: true,
                pagination: false,
                navigationText: ["<i class=\"fa fa-chevron-left\"></i>", "<i class=\"fa fa-chevron-right\"></i>"],
                autoHeight: true
            });
        });
    }


    /**
     * Woocommerce increase/decrease quantity function
     */
    function woocommerce_init() {


        window.increaseQty = function (el, count) {
            var $el = $(el).parent().find('.qty');
            $el.val(parseInt($el.val()) + count);
        }
        window.decreaseQty = function (el, count) {
            var $el = $(el).parent().find('.qty');
            var qtya = parseInt($el.val()) - count;
            if (qtya < 1) {
                qtya = 1;
            }
            $el.val(qtya);
        }

        /** Quick view product */
        var buttonHtml = '';
        $('.quickview').on('click', function (e) {
            var el = this;
            buttonHtml = $(el).html();
            $(el).html('<i class="quickviewloading fa fa-cog fa-spin"></i>');
            var effect = $(el).find('input').val();
            Custombox.open({
                target: woocommerce_params.ajax_url + '?action=load_product_quick_view&product_id=' + el.href.split('#')[1],
                effect: effect ? effect : 'fadein',
                complete: function () {
                    $(el).html(buttonHtml);
                    var owl = $(".quickview-body .owl-carousel");
                    owl.owlCarousel({
                        direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
                        items: 5,
                        pagination: false
                    });
                    $(".quickview-body .next").click(function () {
                        owl.trigger('owl.next');
                    })
                    $(".quickview-body .prev").click(function () {
                        owl.trigger('owl.prev');
                    });
                    $(".quickview-body .woocommerce-main-image").click(function (e) {
                        e.preventDefault();
                    })
                    $(".quickview-body .owl-carousel .owl-item a").click(function (e) {
                        e.preventDefault();
                        if ($(".quickview-body .woocommerce-main-image img").length == 2) {
                            $(".quickview-body .woocommerce-main-image img:first").remove();
                        }
                        $(".quickview-body .woocommerce-main-image img").fadeOut(function () {
                            $(".quickview-body .woocommerce-main-image img").stop().hide();
                            $(".quickview-body .woocommerce-main-image img:last").fadeIn();
                        });
                        $(".quickview-body .woocommerce-main-image").append('<img class="attachment-shop_single wp-post-image" style="display:none;" src="' + this.href + '" alt="">');

                    })
                },
                close: function () {
                    $(el).html(buttonHtml);
                }
            });
            e.preventDefault();

        });

        $('.my-cart').click(function () {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                $('.icon-cart .carts-store').show().animate({
                    'margin-right': 0
                }, 400, 'easeInOutExpo');
            } else {
                $(this).removeClass('active');
                $('.icon-cart .carts-store').animate({
                    'margin-right': '-280px'
                }, 400, 'easeInOutExpo', function () {
                    $('.icon-cart .carts-store').hide()
                });
            }
            clickOutSite = false;
            setTimeout(function () {
                clickOutSite = true;
            }, 100);
        });
        $('.icon-cart .carts-store').click(function () {
            clickOutSite = false;
            setTimeout(function () {
                clickOutSite = true;
            }, 100);
        });

        $('.head-login .cart-icon').hover(
            function () {
                $('.head-login .login-icon').addClass('login-icon-under');
            },
            function () {
                $('.head-login .login-icon').removeClass('login-icon-under');
            }
        )

        $(document).click(function () {
            if (clickOutSite && $('.my-cart').hasClass('active')) {
                $('.my-cart').trigger('click');
            }
        });

        $('.add_to_cart_button').on('click', function (e) {
            if ($(this).find('.fa-check').length) {
                e.preventDefault();
                return;
            }
            $(this).addClass('cart-adding');
            $(this).html(' <i class="fa fa-cog fa-spin"></i> ');

        })
        $('.add_to_wishlist').on('click', function (e) {
            if ($(this).find('.fa-check').length) {
                e.preventDefault();
                return;
            }
            $(this).addClass('wishlist-adding');
            $(this).find('i').removeClass('fa-star').addClass('fa-cog fa-spin');
        })
        $('.yith-wcwl-add-to-wishlist').appendTo('.add-to-box');
        $('.yith-wcwl-add-to-wishlist .link-wishlist').appendTo('.add-to-box form.cart');
        if ($('.variations_form .variations_button').length) {
            $('.yith-wcwl-add-to-wishlist .link-wishlist').appendTo('.variations_form .variations_button');
        }

        //trigger events add cart and wishlist
        $('body').on('added_to_wishlist', function () {
            $('.wishlist-adding').html('<i class="fa fa-check"></i>');
            $('.wishlist-adding').removeClass('wishlist-adding');
        });

        $('body').on('added_to_cart', function (e, f) {
            $('.added_to_cart.wc-forward').remove();
            // $('.cart-adding i').remove();
            //$('.cart-adding').removeClass('cart-adding');
            $('.cart-adding').html('<i class="fa fa-check"></i>');
            $('.cart-adding').removeClass('cart-adding');
        });

        /**
         * submitProductsLayout
         */
        window.submitProductsLayout = function (layout) {
            $('.product-category-layout').val(layout);
            $('.woocommerce-ordering').submit();
        }
    }


    function animation_init() {

        /** Function for transition
         */
        $('.iw-av-banner.style2').each(function () {
            $('.iw-av-desc li, .iw-av-desc .button,.iw-av-desc img', this).each(function (index) {
                var delay = (index + 1) * 0.15;
                $(this).css({
                    '-webkit-transition': 'all ' + delay + 's',
                    'transition': 'all ' + delay + 's'
                });
            });
        });
        $('.iw-av-banner.style3').each(function () {
            $('.iw-av-subtitle,.iw-av-title,.iw-av-desc,.button', this).each(function (index) {
                var delay = (index + 1) * 0.15;
                $(this).css({
                    '-webkit-transition': 'all ' + delay + 's',
                    'transition': 'all ' + delay + 's'
                });
            });
        });
        $('.iw-av-banner.style4').each(function () {
            $('.iw-av-subtitle,.iw-av-title,.iw-av-desc li', this).each(function (index) {
                var delay = (index + 1) * 0.1;
                $(this).css({
                    '-webkit-transition': 'all ' + delay + 's',
                    'transition': 'all ' + delay + 's'
                });
            });
        });
        $('.iw-av-banner.style1').each(function () {
            $('.iw-av-price,.iw-av-subtitle,.iw-av-title,.iw-av-desc li,.button', this).each(function (index) {
                var delay = (index + 1) * 0.1;
                var duration = 0.5;
                $(this).css({
                    '-webkit-transition': 'all ' + duration + 's ease ' + delay + 's',
                    'transition': 'all ' + duration + 's ease ' + delay + 's'
                });
            });
        });

    };

    /**
     * WAYPOINT FUNCTION
     */
    function waypoint_init() {
        if (typeof $.fn.waypoint != 'function' || !$('body').hasClass('waypoints')) {
            return;
        }
        $.fn.iwAnimate = function (effect, delay) {
            var el = this;
            $(el).addClass('animate');
            setTimeout(function () {
                $(el).addClass(effect).addClass('animated');
            }, delay)
        }
        $('.numbers-effect').css('visibility', 'hidden').waypoint(function () {
            $('.numbers-effect .wpb_column').each(function (index) {
                var el = this;
                setTimeout(function () {
                    $(el).addClass('move_to_center').css('visibility', 'visible');
                }, 300 * index);
            });

            var counter = 0;
            $('.numbers-effect h3').each(function () {
                var el = this;
                counter++;
                var y = parseInt($(el).html());
                setTimeout(function () {
                    $({someValue: 0}).animate({someValue: y}, {
                        duration: 2000,
                        easing: 'swing', // can be anything
                        step: function () { // called on every step
                            $(el).html(Math.round(this.someValue));
                        },
                        complete: function () {
                            $(el).html(y);
                        }
                    });
                }, 300 * counter);
            });

        }, {
            offset: '70%',
            triggerOnce: true
        });

        $('.iw-av-banner.style1').waypoint(function () {
            $(this).iwAnimate('show-info', 10);
        }, {
            offset: '70%',
            triggerOnce: true
        });

        var init_delay = 0;
        $('.iw-heading').waypoint(function () {
            if (!$('.iwh-title', this).hasClass('animate')) {
                var delay = init_delay;
                $('.iwh-sub-title', this).iwAnimate('fadeInDown', delay);
                $('.iwh-title', this).iwAnimate('fadeInDown', delay + 100);
                $('.iwh-content', this).iwAnimate('fadeInDown', delay + 200);
            }
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** why-choose block */
        $('.why-choose').waypoint(function () {
            var delay = init_delay;
            $(this).find('.info-item,.cta-banner').each(function (index) {
                delay = delay + 300;
                $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInUp', delay + 100);
                $('.info-item-title', this).iwAnimate('fadeInUp', delay + 200);
                $('.info-item-desc', this).iwAnimate('fadeInUp', delay + 300);
            });
            $('.cta-desc', this).iwAnimate('fadeInUp', delay + 500);
            $('.cta-btn', this).iwAnimate('fadeInUp', delay + 700);
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** TAB BLOCK */
        $('.iw-tabs').waypoint(function () {
            var delay = init_delay + 500;

            $(this).find('.iw-accordion-item').each(function (index) {
                $(this).iwAnimate('fadeInUp', delay);
                delay = delay + 300;
            })

            $(this).find('.iw-tab-items').iwAnimate('fadeInDown', delay);
            $('.vc_single_image-img', this).iwAnimate('fadeInLeft', delay + 300);
            $('.contact-map', this).iwAnimate('fadeInDownShort', delay + 300);
            delay += 300;
            if (!$('.iwh-title', this).hasClass('animate')) {
                $('.iwh-sub-title', this).iwAnimate('fadeInLeft', delay);
                $('.iwh-title', this).iwAnimate('fadeInLeft', delay + 100);
                $('.iwh-content', this).iwAnimate('fadeInLeft', delay + 200);
            }

            $(this).find('.info-item').each(function (index) {
                delay = delay + 300;
                $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInUp', delay + 400);
                $('.info-item-title', this).iwAnimate('fadeInUp', delay + 500);
                $('.info-item-desc', this).iwAnimate('fadeInUp', delay + 600);
            });
            $('.tab-content-text', this).iwAnimate('fadeInUp', delay);


        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** our-client block */
        $('.our-pre-clients').waypoint(function () {
            var delay = init_delay;
            $(this).find('.client-images a').each(function (index) {
                delay = delay + 200;
                $(this).iwAnimate('bounceInUpShort', delay);
            });
            $(this).find('.testi-content').iwAnimate('fadeInUp', delay + 200);
            $(this).find('.testi-client').iwAnimate('zoomIn', delay + 400);

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** EXPERTISE IN */
        $('.expertise-in').waypoint(function () {
            var delay = init_delay;
            $(this).find('.left-column .info-item').each(function (index) {
                delay = delay + 200;
                $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInLeft', delay + 300);
                $('.info-item-title', this).iwAnimate('fadeInLeft', delay + 400);
                $('.info-item-desc', this).iwAnimate('fadeInLeft', delay + 500);
            });
            delay = init_delay;
            $(this).find('.right-column .info-item').each(function (index) {
                delay = delay + 200;
                $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInRight', delay + 300);
                $('.info-item-title', this).iwAnimate('fadeInRight', delay + 400);
                $('.info-item-desc', this).iwAnimate('fadeInRight', delay + 500);
            });
            $(this).find('.vc_single_image-img').iwAnimate('fadeInUp', delay);
            $(this).find('.see-plans').iwAnimate('fadeInUp', delay + 200);

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** PRICE BOX */
        $('.pricebox').closest('.vc_row').waypoint(function () {
            var delay = init_delay+200;
            $(this).find('.pricebox').each(function (index) {
                delay = delay + 200;
                $(this).iwAnimate('fadeInUp', delay);
            });
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** info item */
        $('.info-item').closest('.vc_row').waypoint(function () {
            if (!$('.info-item.animate,.info-item .animate', this).length) {
                var delay = init_delay+200;
                $(this).find('.info-item').each(function (index) {
                    delay = delay + 200;
                    if($(this).hasClass('style4')) {
                        $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInLeft', delay + 300);
                        $('.info-item-title', this).iwAnimate('fadeInLeft', delay + 400);
                        $('.info-item-desc', this).iwAnimate('fadeInLeft', delay + 500);
                    }else{
                        $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInUp', delay + 300);
                        $('.info-item-title', this).iwAnimate('fadeInUp', delay + 400);
                        $('.info-item-desc', this).iwAnimate('fadeInUp', delay + 500);
                    }
                });
            }
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** IW WORDPRESS POSTS */
        $('.iw-posts').closest('.vc_row').waypoint(function () {
            var delay = init_delay + 200;
            $(this).find('.iw-posts-item').each(function (index) {
                delay = delay + 200;
                $(this).iwAnimate('fadeInUp', delay);
            });

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** SEE PLANS */
        $('.see-plans,.plan-sub-text,.compare-plan').waypoint(function () {
            if (!$(this).hasClass('animate')) {
                var delay = init_delay + 200;
                $(this).iwAnimate('zoomIn', delay);
            }

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** Call to action */
        $('.cta-banner').waypoint(function () {
            if (!$('.cta-desc', this).hasClass('animate')) {
                var delay = init_delay + 200;
                $('.cta-desc', this).iwAnimate('zoomIn', delay);
                $('.cta-btn', this).iwAnimate('zoomIn', delay + 300);
            }

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** iw slider */
        $('.dg-container').waypoint(function () {
            var delay = init_delay + 200;
            $(this).iwAnimate('fadeInUp', delay);
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** testimonial */
        $('.iw-testimonial-item').waypoint(function () {
            if (!$('.testi-text-content,.testi-content', this).hasClass('animate')) {
                var delay = init_delay + 200;
                $('.testi-image-icon', this).iwAnimate('fadeInUp', delay+100);
                $('.testi-text-content,.testi-content', this).iwAnimate('fadeInUp', delay+200);
                $('.testi-client', this).iwAnimate('zoomIn', delay + 300);
            }
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** trusted loved block */
        $('.trusted-loved').waypoint(function () {
            var delay = init_delay + 200;
            $(this).find('img').each(function (index) {
                delay = delay + 200;
                $(this).iwAnimate('fadeInLeft', delay);
            });
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** simple list */
        $('.simple-list').waypoint(function () {
            if (!$('.li', this).hasClass('animate')) {
                var delay = init_delay + 500;
                $(this).find('li').each(function (index) {
                    delay = delay + 300;
                    $(this).iwAnimate('fadeInUp', delay);
                });
            }
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** block-image-right */
        $('.block-image-right').waypoint(function () {
            var delay = init_delay + 400;
            if (!$('.iwh-title', this).hasClass('animate')) {
                $('.iwh-sub-title', this).iwAnimate('fadeInLeft', delay);
                $('.iwh-title', this).iwAnimate('fadeInLeft', delay);
                $('.iwh-content', this).iwAnimate('fadeInLeft', delay);
            }
            $('.vc_single_image-img', this).iwAnimate('fadeInRight', delay);
            $(this).find('.simple-list li,.skillbar_wap').each(function (index) {
                delay = delay + 100;
                $(this).iwAnimate('fadeInUp', delay);
            });
            $(this).find('.info-item').each(function (index) {
                delay = delay + 100;
                $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInUp', delay + 200);
                $('.info-item-title', this).iwAnimate('fadeInUp', delay + 300);
                $('.info-item-desc', this).iwAnimate('fadeInUp', delay + 400);
            });
            $('.ibutton', this).iwAnimate('fadeInLeft', delay + 300);


        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** block-image-left */
        $('.block-image-left').waypoint(function () {
            var delay = init_delay + 400;
            if (!$('.iwh-title', this).hasClass('animate')) {
                $('.iwh-sub-title', this).iwAnimate('fadeInRight', delay);
                $('.iwh-title', this).iwAnimate('fadeInRight', delay);
                $('.iwh-content', this).iwAnimate('fadeInRight', delay);
            }
            $('.vc_single_image-img', this).iwAnimate('fadeInLeft', delay);
            $(this).find('.simple-list li,.skillbar_wap').each(function (index) {
                delay = delay + 100;
                $(this).iwAnimate('fadeInUp', delay);
            });
            $(this).find('.info-item').each(function (index) {
                delay = delay + 100;
                $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInUp', delay + 200);
                $('.info-item-title', this).iwAnimate('fadeInUp', delay + 300);
                $('.info-item-desc', this).iwAnimate('fadeInUp', delay + 400);
            });
            $('.ibutton', this).iwAnimate('fadeInRight', delay + 300);

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** Block content center*/
        $('.block-content-center').waypoint(function(){
            var delay = init_delay + 400;
            $('.vc_single_image-img', this).iwAnimate('fadeInUp', delay);
            $('h3', this).iwAnimate('fadeInUp', delay+200);
            $('p', this).iwAnimate('fadeInUp', delay+400);
            $('.right-text .ibutton', this).iwAnimate('fadeInLeft', delay+600);
            $('.left-text .ibutton', this).iwAnimate('fadeInRight', delay+600);
        }, {
            offset: '70%',
            triggerOnce: true
        });



        /** price-starting*/
        $('.price-starting').waypoint(function () {
            var delay = init_delay + 500;
            $('.filters', this).iwAnimate('zoomIn', delay);
            $(this).find('.element-item .item-info').each(function (index) {
                delay = delay + 300;
                $(this).iwAnimate('fadeInUp', delay);
            });

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** search domain */
        $('.inwave-domain-check.style2').waypoint(function () {
            var delay = init_delay + 200;
            $('.heading-block', this).iwAnimate('fadeInLeft', delay);
            $('.list-domain-check', this).iwAnimate('fadeInRight', delay + 200);
        }, {
            offset: '70%',
            triggerOnce: true
        });
        $('.inwave-domain-check.no-top.style1').waypoint(function () {
            var delay = init_delay + 200;
            $(this).iwAnimate('zoomIn', delay);
        }, {
            offset: '70%',
            triggerOnce: true
        });


        /** portfolio shortcodes*/
        $('.classes').waypoint(function () {
            var delay = init_delay + 500;
            $('.filters', this).iwAnimate('zoomIn', delay);
            $(this).find('.element-item .item-info').each(function (index) {
                delay = delay + 300;
                $(this).iwAnimate('fadeInUp', delay);
            });

        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** profile box*/
        $('.profile-box.style2,.profile-box.style3').closest('.vc_row').waypoint(function () {
            var delay = init_delay + 200;
            $(this).find('.profile-box').each(function (index) {
                delay = delay + 300;
                $(this).iwAnimate('fadeInUp', delay);
            });
        }, {
            offset: '70%',
            triggerOnce: true
        });
        /** mail chimp form */
        $('.iw-mailchimp-form.style2').waypoint(function () {
            var delay = init_delay + 200;
            $(this).iwAnimate('zoomIn', delay);
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /** contact shortcode */
        $('.iw-contact').waypoint(function () {
            var delay = init_delay + 200;
            $('.control', this).each(function (index) {
                delay = delay + 100;
                $(this).iwAnimate('fadeInUp', delay);
            });
            $('.btn-submit.theme-bg', this).iwAnimate('fadeInLeft', delay + 300);
            $('.btn-submit.btn-cancel', this).iwAnimate('fadeInRight', delay + 300);
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /* video shortcode */
        $('.iw-video').waypoint(function () {
            var delay = init_delay + 200;
            $('.play-button i', this).iwAnimate('zoomIn', delay + 300);
            $('.iw-video-content', this).iwAnimate('fadeInUp', delay + 300);
        }, {
            offset: '70%',
            triggerOnce: true
        });

        /* Services provided block */
        $('.service-provided').waypoint(function () {
            var delay = init_delay + 200;
            $('.wpb_text_column', this).each(function (index) {
                delay = delay + 300;
                $('h4', this).iwAnimate('fadeInUp', delay);
                $('p', this).iwAnimate('fadeInUp', delay+200);
            })
        }, {
            offset: '70%',
            triggerOnce: true
        });
        /* Our services block */
        $('.our-services').waypoint(function () {
            var delay = init_delay + 200;
            if (!$('.iwh-title', this).hasClass('animate')) {
                $('.iwh-sub-title', this).iwAnimate('fadeInLeft', delay+100);
                $('.iwh-title', this).iwAnimate('fadeInLeft', delay+200);
                $('.iwh-content', this).iwAnimate('fadeInLeft', delay+300);
            }
            $('.ibutton', this).iwAnimate('zoomIn', delay+400);
            $('.info-item', this).each(function (index) {
                delay = delay + 300;
                $('.icon,.info-item-icon,.icon_img', this).iwAnimate('fadeInUp', delay + 200);
                $('.info-item-title', this).iwAnimate('fadeInUp', delay + 300);
                $('.info-item-desc', this).iwAnimate('fadeInUp', delay + 400);
            })
        }, {
            offset: '70%',
            triggerOnce: true
        });
    }

    /** Quick access function */
	function loadQuickAccess(){
		if($('.quick-access').length){
			$.ajax({
				type: "GET",
				url: inwaveCfg.ajaxUrl + '?action=inwave_quick_access',
				dataType: "html",
				success: function (result) {
					$('.quick-access').html(result);
					loginForm();
				}
			});	
		}		 
	}
	
    function loginForm(){
        $('.head-login').on('click', '.login-icon', function (e) {
            if($(this).find('.fa-unlock').length){
                Custombox.open({
                    target: '#iw-login-form',
                    effect: 'fadein',
                    overlaySpeed:'100',
                    speed:'200',
                    width: '300'
                });
                e.preventDefault();
            }
        });
        $('body').on('click', '.login-close-btn', function () {
            Custombox.close();
        });
    }
	/* megamenu sticky */
	if (document.location.href.indexOf('sticky=1') > 0) {
		$('#mega_main_menu .menu_holder').attr('data-stickyoffset', 340).attr('data-sticky', 1);
	}

    /*** RUN ALL FUNCTION */
	
    $(document).ready(function () {
        theme_init();
        panel_setting();
        waypoint_init();
        animation_init();
        parallax_init();
        woocommerce_init();
        carousel_init();
        loginForm();
		loadQuickAccess();

        /*** fit video */
        $(".fit-video").fitVids();
        /** bootstrap tooltip */
        $('[data-toggle="tooltip"]').tooltip();
    });

	$(window).load(function(){
		$('.page-loading').addClass('page-loaded');
		
	})
})(jQuery);
