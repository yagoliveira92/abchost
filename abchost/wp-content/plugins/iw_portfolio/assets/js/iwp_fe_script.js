/* 
 * @package Inwave Event
 * @version 1.0.0
 * @created Jun 24, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of iwp_fe_script
 *
 * @developer duongca
 */

(function ($) {
    $(document).ready(function () {
        $('.portfolio-relate .post_item').live('mouseover mouseout', function (event) {
            if (event.type == 'mouseover') {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });

        $(".portfolio-slider").owlCarousel({
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left fa-2x"></i>', '<i class="fa fa-angle-right fa-2x"></i>'],
            slideSpeed: 300,
            pagination: false,
            paginationSpeed: 400,
            singleItem: true

        });

        $('.item-info .info').live('click', function () {
            var id = $(this).data('id');console.log('sds--')
            Custombox.open({
                target: '#port-info-' + id,
                effect: 'fadein'
            });
        });
        $('.item-info .preview').live('click', function () {
            var item_target = $(this), id = item_target.data('id'),
                    parent = $('#port-images-'+id),
                    images = parent.find('img'),
                    length = images.length, count = 0;
            images.each(function () {
                var image = new Image();
                var el = this;
                $(image).load(function () {
                    count++;
                    $(el).css({height: this.height, width: this.width});
                    if (count == length) {
                        var popup_id = parent.attr('id');
                        Custombox.open({
                            target: '#' + popup_id,
                            effect: 'fadein',
                            open: function () {
                                item_target.find('.fa-search').fadeOut(200, function () {
                                    item_target.find('.fa-spin').fadeIn();
                                });
                            },
                            complete: function () {
                                item_target.find('.fa-spin').fadeOut(200, function () {
                                    item_target.find('.fa-search').fadeIn();
                                });
                            }
                        });
                    }


                }).attr('src', this.src);

            });
        });

        function rate(mediaId, rating) {
            $.ajax({
                url: iwcCfg.ajaxUrl,
                data: {action: 'iwcAthleteAjaxVote', id: mediaId, rating: rating},
                type: "post",
                success: function (responseJSON) {
                    var a = $.parseJSON(responseJSON);
                    if (a.success) {
                        $('.btp-rating-container-' + mediaId).each(function () {
                            $(this).find('.btp-rating-current').css({
                                width: a.rating_width + "px"
                            });
                            $('.btp-rating-container-' + mediaId + ' .btp-rating-notice').text(a.rating_text);
                        });
                    }
                    else {
                        alert(a.message);
                    }
                }, error: function () {
                    alert('Unknow Error!!!');
                }
            });
        }

        function rateAthlete(mediaId, rating) {
            $.ajax({
                url: iwcCfg.ajaxUrl,
                data: {action: 'iwcAthleteAjaxVote', id: mediaId, rating: rating},
                type: "post",
                success: function (responseJSON) {
                    var a = $.parseJSON(responseJSON);
                    if (a.success) {
                        $('.btp-rating-container-' + mediaId).each(function () {
                            $(this).find('.btp-rating-current').css({
                                width: a.rating_width + "%"
                            });
                            $('.btp-rating-container-' + mediaId + ' .btp-rating-notice').text(a.rating_text);
                        });
                    }
                    else {
                        alert(a.message);
                    }
                }, error: function () {
                    alert('Unknow Error!!!');
                }
            });
        }
    });
})(jQuery);