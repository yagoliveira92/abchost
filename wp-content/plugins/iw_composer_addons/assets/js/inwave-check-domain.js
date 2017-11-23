/* 
 * @package Inwave Inhost
 * @version 1.0.0
 * @created Apr 13, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of inwave-check-domain
 *
 * @developer duongca
 */
(function ($) {
    "use strict";
    var domain_check = false, xhrlist = Array(), checkDomains = 0;
    $(document).ready(function () {
        $('.inwave-domain-check.style1 .domain-list input').removeAttr('checked');
        $('.inwave-domain-check .ibutton').click(function (e) {
            submitCheckDomain(this);
            e.preventDefault();
        });

        $('.inwave-domain-check.style1 input[name="input_domain"]').focus(function () {
            hideMsg($(this).parents('.inwave-domain-check'));
        });

        $('.inwave-domain-check input[name="input_domain"]').keypress(function (e) {
            if (e.keyCode === 13) {
                submitCheckDomain(this);
            } else {
                hideMsg($(this).parents('.inwave-domain-check'));
            }
        });

        $('.inwave-domain-check.style1 .inwave-checkbox i').click(function () {
            if ($(this).hasClass('fa-square-o')) {
                $(this).removeClass('fa-square-o').addClass('fa-check-square');
                $(this).parents('li').find('input').attr('checked', 'checked');
            } else {
                $(this).removeClass('fa-check-square').addClass('fa-square-o');
                $(this).parents('li').find('input').removeAttr('checked');
            }
        });

        $('.list-domain-checked').on('click', 'a.loading', function (e) {
            e.preventDefault();
        });

        $('.list-domain-checked a.unavailable').unbind('click');
        $('.list-domain-checked').on('click', 'a.unavailable', function (e) {
            hideTip($(this));
            var target = $(this).attr('href');
            Custombox.open({
                target: target,
                effect: 'fadein',
                overlaySpeed: '100',
                speed: '200',
                width: '700'
            });
            return  false;
        });
        $('body').on('click', '.whois-box-close', function () {
            Custombox.close();
        });

//        $('.list-domain-checked').on('click', 'a.available', function (e) {
//			$('.inwave-domain-check .ajax-spinner.hidden').appendTo('body').fadeIn(500, function () {
//				$(this).removeClass('hidden');
//			});
//            var domain = $(this).data('domain');
//            hideTip($(this));
//            $.ajax({
//                url: iwConfig.homeUrl + '?page_id=' + iwConfig.whmcs_pageid,
//                data: 'ccce=cart&a=add&domain=register&domainoption=register&domains[]='+domain+'&domainsregperiod['+domain+']=1',
//                type: "GET",
//                success: function (data) {
//					$('.ajax-spinner').fadeOut(500, function () {
//						$(this).addClass('hidden');
//					});
//                    location.href = iwConfig.homeUrl + '?page_id=' + iwConfig.whmcs_pageid + '&ccce=cart&a=view';
//                }
//            });
//            e.preventDefault();
//        });

        $('.list-domain-checked').on('mouseenter', 'a.ttip', function () {
            showTip($(this));
        }).on('mouseleave', 'a.ttip', function () {
            hideTip($(this));
        });

//Style 2 script
        $('.inwave-domain-check.style2 .select-domain').click(function () {
            $(this).parent().find('.domain-list').slideDown();
        });

        $('.inwave-domain-check.style2 .domain-list li').click(function () {
            var itemClick = $(this), items = $('.inwave-domain-check.style2 .domain-list li');
            itemClick.find('input').attr('checked', 'checked');
            $('.inwave-domain-check.style2 .select-domain').html('<i class="fa fa-check"></i>' + itemClick.find('input').val())
            $(this).parent().slideToggle();

            items.each(function () {
                if (items.index(itemClick) !== items.index($(this))) {
                    $(this).find('input').removeAttr('checked');
                }
            });

        });

        $('body').click(function (event) {
            if ($(event.target).closest('.inwave-domain-check.style2 .domain-select-list').length === 0) {
                $('.inwave-domain-check.style2 .domain-list').slideUp();
            }
        });

    });

    function showTip(e) {
        e.parent().find('.tooltip').css('opacity', 1).show();
    }
    function hideTip(e) {
        e.parent().find('.tooltip').hide();
    }

    function submitCheckDomain(e) {
        var parent = $(e).parents('.inwave-domain-check');
        var submit_button = $('.ibutton', parent);
        iwConfig.cart_link = submit_button.data('cartlink');
        iwConfig.more_link = submit_button.data('morelink');
        if ($('.checking', parent).length && $('.list-domain-checked', parent).is(':visible')) {
            return;
        }
        var domains = $('.domain-list input:checked', parent);
		if(!domains.length){
			domains = $('.domain-list input[checked=checked]', parent);		
		}
        if (parent.hasClass('style3')) {
            domains = [parent.find('select[name="domains[]"]').val()];
        }
        var domainName = $('input[name="input_domain"]', parent).val();
        xhrlist = Array();

        hideMsg(parent);
        $('.list-domain-checked', parent).html('').show();
        if (!domainName) {
            showMsg(iwConfig.msg_suggest, parent);
            return;
        }
        if (domains.length == 0) {
            domains = $('.domain-list input');
        }

        var dindex = 0;
        $('.output-search-box', parent).animate({'min-height': '123px', 'padding-top': '10px'});

        checkDomains = setInterval(function () {
            checkDomain(domainName, domains, dindex, parent);
            dindex++;
            if (dindex === domains.length) {
                clearInterval(checkDomains);
                $('.list-domain-checked', parent).append('<div class="domain-item"><a href="#more" onclick="javascript: location.href=\'' + iwConfig.more_link + '\'; return;" class="more theme-bg"><i class="fa fa-plus"></i></div>');
            }
        }, 300);
    }

    function showMsg(text, e) {
        if ($('.inwave-domain-check', e).hasClass('style1')) {
            $('.list-domain-check .domain-list', e).hide();
        }
        $('.list-domain-check .output-error-msg', e).html(text).show();
    }
    function hideMsg(e) {
        $('.list-domain-check .output-error-msg', e).hide().text('');
        if ($('.inwave-domain-check', e).hasClass('style1')) {
            $('.list-domain-check .domain-list', e).show();
        }
    }

    function checkDomain(dn, dts, index, e) {
        if (e.hasClass('style3')) {
            var dt = dts[index];
        } else {
            var dt = $(dts[index]).val();
        }
        var domain = dn + dt;
        var css = 'style="animation: 1.5s ease-in-out -' + (0.3 * index) + 's normal none infinite running fa-spin;"';
        var htmlitem = '<div class="domain-item"><a href="#" class="ttip"><span class="item-icon"></span><span class="item-text">' + dt + '</span></a><div ' + css + ' class="checking fa fa-spin"></div></div>';
        var xhr = $.ajax({
            url: iwConfig.ajaxUrl,
            data: {action: 'domainLookup', domain: domain},
            type: "post",
            beforeSend: function () {
                $('.list-domain-checked', e).append(htmlitem);
                htmlitem = $('.list-domain-checked', e).find('.domain-item:last-child a');
            },
            success: function (data) {
                var a = jQuery.parseJSON(data);
                if (a.success) {
                    $(htmlitem).addClass(a.msg).parent().find('.checking.fa.fa-spin').fadeOut(function () {
                        $(this).remove();
                    });
                    if (a.msg === 'available') {
                        if (!domain_check) {
                            showMsg('<span class="available inwave-checkbox"><i class="fa fa-check-square"></i></span>' + iwConfig.msg_available.replace(/%d/, domain), e);
                            domain_check = true;
                        }

                        $(htmlitem).attr('href', iwConfig.cart_link + '&domains[]=' + domain + '&domainsregperiod[' + domain + ']=1').attr('data-domain', domain).parent().append('<span class="tooltip">Order</span>');
                        $(htmlitem).find('span.item-icon').html('<i class="fa fa-check"></i>');
                    } else {
                        var whois = '<div class="whois-box" style="display:none;" id="whois-' + dn + '-' + dt.replace(/./, '') + '"><div class="whois-title"><h3>WHOIS: <a target="_blank" href="http://' + domain + '">' + domain + '</a></h3><div class="whois-box-close"><span><i class="fa fa-times"></i></span></div></div><div class="whois-content"><div class="whois-content-inner">' + a.data + '</div></div></div>';
                        $(htmlitem).attr('href', '#whois-' + dn + '-' + dt.replace(/./, '')).parent().append(whois).append('<span class="tooltip">Whois</span>');
                        $(htmlitem).find('span.item-icon').html('<i class="fa fa-times"></i>');
                    }
                    if (index === dts.length - 1) {
                        if (!domain_check) {
                            showMsg(iwConfig.msg_unavailable.replace(/%d/, dn), e);
                        } else {
                            domain_check = false;
                        }
                    }
                } else {
                    showMsg(a.msg, e);
                    clearInterval(checkDomains);
                    $('.list-domain-checked', e).html('').hide();
                    for (var i = 0; i < xhrlist.length; i++) {
                        xhrlist[i].abort();
                    }

                }

            }
        });
        xhrlist.push(xhr);
    }

})(jQuery);

