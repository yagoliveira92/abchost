/* 
 * @package Inwave Inhost
 * @version 1.0.0
 * @created Apr 22, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of iw-main
 *
 * @developer duongca
 */

(function ($) {
    $(document).ready(function () {
        var shortcodeTag = null;
        $('body').on('click', '#insert-iw-shortcode', function () {
            $('body').css('overflow', 'hidden');
            $('#iw-list-shortcode.iw-hidden').appendTo('body').fadeIn(500, function () {
                $(this).removeClass('iw-hidden');
                if ($('.iw-shortcode.list-shortcode').length > 1) {
                    $('.iw-shortcode.list-shortcode:last-child').remove();
                }
            });
        });

        $('.shortcode-control').on('click', '.close-btn', function () {
            closeIwBox($(this), true);
        });

        $('body').on('click', '.shortcode-item', function () {
            shortcodeTag = $(this).data('shortcodetag');
            $('#iw-shortcode .shortcode-content').html('<div class="ajax-loading"><i class="fa fa-spin fa-circle-o-notch fa-4x"></i></div>');
            sendAjax(shortcodeTag);
            closeIwBox($(this), false);
            $('#iw-shortcode.iw-hidden').appendTo('body').fadeIn(500, function () {
                $(this).removeClass('iw-hidden');
                if ($('.iw-shortcode.shortcode-item-view').length > 1) {
                    $('.iw-shortcode.shortcode-item-view:last-child').remove();
                }
            });
        });

        $('.shortcode-save-settin').on('click', '.cancel-settings', function () {
            closeIwBox($(this), true);
        });

        $(window).resize(function () {
            setHeightShortcodeContent();
        });

        function closeIwBox(e, showBody) {
            if (showBody === true) {
                e.parents('.iw-shortcode').fadeOut(500, function () {
                    $(this).addClass('iw-hidden');
                    $('body').css('overflow', 'auto');
                });
            } else {
                e.parents('.iw-shortcode').fadeOut(500, function () {
                    $(this).addClass('iw-hidden');
                });
            }
            e.parents('.iw-shortcode').find('.shortcode-preview').html('');
        }

        function setHeightShortcodeContent() {
            var wrapHeght = $('#iw-shortcode .shortcode-contain').outerHeight(),
                    controlHeight = $('#iw-shortcode .shortcode-control').outerHeight(),
                    buttonHeight = $('#iw-shortcode .shortcode-save-setting').outerHeight(),
                    height = wrapHeght - (controlHeight + buttonHeight);
            if (height <= 100) {
                height = 100;
            }
            $('#iw-shortcode .shortcode-content').height(height);
        }

        function sendAjax(tag, callback) {
            $.ajax({
                url: iwConfig.ajaxUrl,
                data: {action: 'loadShortCodeSettings', shortcode: tag},
                type: "post",
                success: function (data) {
                    $('#iw-shortcode .shortcode-content').html(data);
                },
                complete: function () {
                    setHeightShortcodeContent();
                }
            });
        }

        var frame;

        // ADD IMAGE LINK
        $('.iw-image-field').on('click', 'div.image-add-image', function (event) {
            var e_target = $(this);

            event.preventDefault();

            // Create a new media frame
            frame = wp.media({
                state: 'insert',
                frame: 'post',
                library: {
                    type: 'image'
                },
                multiple: false  // Set to true to allow multiple files to be selected
            }).open();

            frame.menu.get('view').unset('featured-image');

            frame.toolbar.get('view').set({
                insert: {
                    style: 'primary',
                    text: 'Insert',
                    click: function () {
                        // Get media attachment details from the frame state
                        var attachment = frame.state().get('selection').first().toJSON();

                        // Send the attachment URL to our custom image input field.
                        e_target.parent().find('div.image-preview').html('<div class="close-overlay"><span class="image-delete"><i class="fa fa-times"></i></span></div><img src="' + attachment.url + '" alt=""/>').removeClass('hidden');
                        var imgElement = e_target.parent().find('div.image-preview img');
                        if (imgElement.height() > imgElement.width()) {
                            imgElement.css('width', '100%');
                        } else {
                            imgElement.css('height', '100%');
                        }

                        // Send the attachment id to our hidden input
                        e_target.parents('.field-input').find('.iw-field.iw-image-field-data').val(attachment.id);
                        frame.close();
                    }
                } // end insert
            });
        });


        // DELETE IMAGE LINK
        $('.iw-image-field').on('click', '.image-delete', function (event) {
            var e_target = $(this);

            event.preventDefault();

            // Clear out the preview image
            e_target.parents('.iw-image-field').find('div.image-preview').addClass('iw-hidden').html('');

            // Delete the image id from the hidden input
            e_target.parents('.field-input').find('.iw-field.iw-image-field-data').val('');

        });

        //Save shortcode
        $('.shortcode-save-setting').on('click', '.save-settings', function () {
            window.wp.media.editor.insert(getShortcodeText());
            closeIwBox($(this), true);
        });

        //Preview Shortcode
        $('.shortcode-save-setting').on('click', '.preview-settings', function () {
            var shortcode = getShortcodeText();
            $('#iw-shortcode .shortcode-preview').html('<iframe onload="jQuery(\'#iframe-shortcode-preview\').height(jQuery(\'#iframe-shortcode-preview\').contents().height() + 50);" src="' + iwConfig.ajaxUrl + '?action=loadShortCodePreview&shortcode=' + escape(shortcode) + '" style="width:100%;" scrolling="no" id="iframe-shortcode-preview"></iframe>');
        });


        //tabs style change
        $('.field-group.iw-tabs-style').on('change', 'select', function () {
            var val = $(this).val();
            if (val === 'layout8' || val === 'layout9') {
                $('.field-group.iw-tabs-image-heading').removeClass('iw-hidden');
            } else {
                $('.field-group.iw-tabs-image-heading').addClass('iw-hidden');
                $('.field-group.iw-tabs-image-heading input').val('');
                $('.field-group.iw-tabs-image-heading .image-preview').addClass('iw-hidden').html('');
            }
        });

        //Testimonials

        $('.field-group.iw-testimonials-style').on('change', 'select', function () {
            var val = $(this).val(), fields = $('.shortcode-content .iw-field');
            var title = fields.get(1),
                    date = fields.get(3),
                    pos = fields.get(4),
                    image = fields.get(5),
                    bg = fields.get(6),
                    rate = fields.get(7);

            switch (val) {
                case 'layout1':
                    showFiled([date, rate, image]);
                    hideFiled([title, pos, bg]);
                    break;
                case 'layout2':
                case 'layout3':
                    showFiled([title, rate, pos, image]);
                    hideFiled([date, bg]);
                    break;
                case 'layout4':
                case 'layout10':
                    showFiled([image, pos]);
                    hideFiled([title, rate, date, bg]);
                    break;
                case 'layout5':
                    showFiled([image, pos, bg]);
                    hideFiled([title, rate, date]);
                    break;
                case 'layout6':
                case 'layout7':
                case 'layout8':
                    showFiled([title, pos, image]);
                    hideFiled([rate, date, bg]);
                    break;
                case 'layout9':
                    showFiled([title, pos, bg]);
                    hideFiled([rate, date, image]);
                    break;
                default:
                    showFiled([title, pos, image, date, rate, bg]);
                    break;
            }
        });

        function getShortcodeText() {
            var inputWrap = $('#iw-shortcode .shortcode-content'),
                    inputs = inputWrap.find('.iw-field'),
                    //htmlInput = inputWrap.find('.iw-textarea-html'),
                    rs = '';
            if (inputs.length > 0) {
                var shortcodeTag = inputWrap.find('input[name="shortcode_tag"]').val(),
                        closeShortCode = inputWrap.find('input[name="shortcode_close_tag"]').val();
                rs += '[' + shortcodeTag;
                var content = '';
                inputs.each(function () {
                    var inputName = $(this).attr('name'), inputValue = $(this).val();
                    if (inputName == 'content') {
                        content = inputValue;
                    } else {
                        if (inputValue !== '' || inputValue > 0) {
                            rs += ' ' + inputName + '="' + inputValue + '"';
                        }
                    }
                });
                rs += ']';
                if (closeShortCode > 0 || content) {
                    rs += content;
                    rs += '[/' + shortcodeTag + ']';
                }
            }
            return rs;
        }

        function showFiled(e) {
            if ($.isArray(e)) {
                $(e).each(function () {
                    $(this).parents('.field-group').removeClass('iw-hidden');
                });
            } else {
                $(e).parents('.field-group').removeClass('iw-hidden');
            }
        }
        function hideFiled(e) {
            if ($.isArray(e)) {
                $(e).each(function () {
                    $(this).val('');
                    $(this).parents('.field-group').addClass('iw-hidden');
                });
            } else {
                $(e).val('');
                $(e).parents('.field-group').addClass('iw-hidden');
            }
        }


    });

    /**
     * Tabs
     */
    $.fn.iwTabs = function (type) {
        $(this).each(function () {
            var iwTabObj = this, $iwTab = $(this);
            if (type === 'tab') {
                iwTabObj.content_list = $iwTab.find('.iw-tab-content .iw-tab-item-content');
                iwTabObj.list = $iwTab.find('.iw-tab-items .iw-tab-item');
                iwTabObj.item_click_index = 0;
                $('.iw-tab-items .iw-tab-item', this).click(function () {
                    if ($(this).hasClass('active')) {
                        return;
                    }
                    var itemclick = this, item_active = $iwTab.find('.iw-tab-items .iw-tab-item.active');
                    iwTabObj.item_click_index = iwTabObj.list.index(itemclick);
                    $(itemclick).addClass('active');
                    iwTabObj.list.each(function () {
                        if (iwTabObj.list.index(this) !== iwTabObj.list.index(itemclick) && $(this).hasClass('active')) {
                            $(this).removeClass('active');
                        }
                    });
                    iwTabObj.loadTabContent();
                });
                this.loadTabContent = function () {
                    var item_click = $(iwTabObj.content_list.get(iwTabObj.item_click_index));
                    iwTabObj.content_list.each(function () {
                        if (iwTabObj.content_list.index(this) < iwTabObj.content_list.index(item_click)) {
                            $(this).addClass('prev').removeClass('active next');
                        } else if (iwTabObj.content_list.index(this) === iwTabObj.content_list.index(item_click)) {
                            $(this).addClass('active').removeClass('prev next');
                            //                            $(".map-contain",this).iwMap();
                        } else {
                            $(this).addClass('next').removeClass('prev active');
                        }
                    });
                };
            } else {
                this.accordion_list = $iwTab.find('.iw-accordion-item');
                $('.iw-accordion-header', this).click(function () {
                    var itemClick = $(this);
                    var item_target = itemClick.parent();
                    if (itemClick.hasClass('active')) {
                        itemClick.removeClass('active');
                        item_target.find('.iw-accordion-content').slideUp({easing: 'easeOutQuad'});
                        item_target.find('.iw-accordion-header-icon .expand').hide();
                        item_target.find('.iw-accordion-header-icon .no-expand').show();
                        return;
                    }
                    itemClick.addClass('active');
                    item_target.find('.iw-accordion-content').slideDown({easing: 'easeOutQuad'});
                    item_target.find('.iw-accordion-header-icon .expand').show();
                    item_target.find('.iw-accordion-header-icon .no-expand').hide();
                    iwTabObj.accordion_list.each(function () {
                        if (iwTabObj.accordion_list.index(this) !== iwTabObj.accordion_list.index(item_target) && $(this).find('.iw-accordion-header').hasClass('active')) {
                            $(this).find('.iw-accordion-header').removeClass('active');
                            $(this).find('.iw-accordion-content').slideUp({easing: 'easeOutQuad'});
                            $(this).find('.iw-accordion-header-icon .expand').hide();
                            $(this).find('.iw-accordion-header-icon .no-expand').show();
                        }
                    });
                });

                $('.iw-accordion-header', this).hover(function () {
                    var item = $(this), item_target = item.parent();
                    if (item.hasClass('active')) {
                        return;
                    }
                    item_target.find('.iw-accordion-header-icon .expand').show();
                    item_target.find('.iw-accordion-header-icon .no-expand').hide();
                }, function () {
                    var item = $(this), item_target = item.parent();
                    if (item.hasClass('active')) {
                        return;
                    }
                    item_target.find('.iw-accordion-header-icon .expand').hide();
                    item_target.find('.iw-accordion-header-icon .no-expand').show();
                });
            }

        });
    };

    /**
     * Video
     */
    $('.iw-video .play-button').click(function () {
        if (!$(this).parents('.iw-video').hasClass('playing')) {
            $(this).parents('.iw-video').find('video').get(0).play();
            $(this).parents('.iw-video').addClass('playing');
            return false;
        }
    });
    $('.iw-video').click(function () {
        $(this).find('video').get(0).pause();
    });
    $('.iw-video video').on('pause', function (e) {
        $(this).parents('.iw-video').removeClass('playing');
    });

    /** CONTACT FORM **/
    $('.iw-contact form').submit(function (e) {
        $.ajax({
            type: "POST",
            url: inwaveCfg.ajaxUrl,
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function (xhr) {
                $('.iw-contact .ajax-overlay').show();
            },
            success: function (result) {
                if (result.success) {
                    $('.iw-contact form').get(0).reset();
                } else {
                    $('.iw-contact .form-message').addClass('error');
                }
                $('.iw-contact .ajax-overlay').hide();
                $('.iw-contact .form-message').html(result.message);
            }
        });
        e.preventDefault();
    });
    $('.iw-contact .btn-cancel').click(function () {
        $('.iw-contact form').get(0).reset();
        $('.iw-contact .form-message').removeClass('error');
        $('.iw-contact .form-message').html('');
        return false;
    })

    /** price box hover */
    $('.pricebox.style3').hover(function () {
        if (!$(this).hasClass('no-price')) {
            $('.pricebox.style3').removeClass('featured');
            $(this).addClass('featured');
        }
    });
    $('.pricebox.style2').hover(function () {
        if (!$(this).hasClass('no-price')) {
            $('.pricebox.style2').removeClass('featured');
            $(this).addClass('featured');
        }
    });
    $('.pricebox.style3').css('min-height', $('.pricebox.style3.featured').height());

})(jQuery);