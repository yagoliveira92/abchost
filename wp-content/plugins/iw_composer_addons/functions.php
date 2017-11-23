<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of functions
 *
 * @developer duongca
 */
if (!function_exists('get_list_iw_shortcode')) {

    function get_list_iw_shortcode() {
        return array(
            'athlete_map',
            'adv_banner',
            'button',
            'call_to_action',
            //'courses_list',
            //'countdown',
            //'courses',
            //'events',
            //'ethlete_facts',
            'faq',
            'heading',
            //'history',
            'info_list',
            //'info_banner',
            'iw_contact',
            'inhost_checkdomain',
            'location_map',
            //'layers_effect',
            //'navigation',
            'mailchimp',
            //'opening_hours',
            'price_box',
            //'product_list',
            'profile',
            'simple_list',
            'tabs',
            'testimonials',
            'iw_slider',
            'server_locations',
            'video',
            'wp_posts',
            'skillbar',
            'iw_portfolio_listing'
        );
    }

}

if (!function_exists('iw_shortcode_add_button')) {

    function iw_shortcode_add_button() {
        global $iw_shortcodes;
        echo '<a href="javascript:void(0);" id="insert-iw-shortcode" class="button">' . __('Insert IW Shortcode', 'inwavethemes') . '</a>';
        ?>
        <div id='iw-list-shortcode' class="iw-shortcode list-shortcode iw-hidden">
            <div class="shortcode-contain">
                <div class="shortcode-control">
                    <div class="title"><?php _e('List Shortcode', 'inwavethemes'); ?></div>
                    <div class="close-btn"><i class="fa fa-times"></i></div>
                    <div class="filter-box"><input placeholder="<?php echo __('Shortcode filter', 'inwavethemes'); ?>" class="shortcode-filter" name="shortcode-filter"/></div>
                    <div style="clear: both;"></div>
                </div>
                <div class="shortcode-list-content">
                    <div class="shortcode-items">
                        <?php
                        foreach ($iw_shortcodes as $shortcode) {
                            if ($shortcode['base']) {
                                echo '<div class="shortcode-item" data-shortcodetag="' . $shortcode['base'] . '">';
                                echo '<div class="icon">';
                                if ($shortcode['icon']) {
                                    if ($shortcode['icon'] == 'iw-default') {
                                        echo '<span class="' . $shortcode['icon'] . '"></span>';
                                    } else {
                                        echo '<i class="fa fa-2x fa-' . $shortcode['icon'] . '"></i>';
                                    }
                                } else {
                                    echo '<i class="iw-shortcode-dficon"></i>';
                                }
                                echo '</div>';
                                echo '<div class="short-info">';
                                echo '<div class="s_name">' . $shortcode['name'] . '</div>';
                                echo '<div class="s_des">' . $shortcode['description'] . '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
        <div id="iw-shortcode" class="iw-hidden iw-shortcode shortcode-item-view">
            <div class="shortcode-contain">
                <div class="shortcode-control">
                    <div class="title"><?php _e('Shortcode settings', 'inwavethemes'); ?></div>
                    <div class="close-btn"><i class="fa fa-times"></i></div>
                    <div style="clear: both;"></div>
                </div>
                <div class="shortcode-content">
                </div>
                <div class="shortcode-preview">
                </div>
                <div class="shortcode-save-setting">
                    <div class="save-settings"><?php _e('Insert Shortcode'); ?></div>
                    <div class="cancel-settings"><?php _e('Cancel'); ?></div>
                    <div class="preview-settings"><?php _e('Preview'); ?></div>
                    <div style="clear: both; padding: 0;"></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    var $shortcodeItems = $('.shortcode-items .shortcode-item');
                    $('.shortcode-control .shortcode-filter').on('input', function () {
                        var filterVal = $(this).val();
                        $shortcodeItems.each(function () {
                            var text = $(this).text();
                            if (text.toLowerCase().indexOf(filterVal.toLowerCase()) >= 0) {
                                $(this).fadeIn();
                            } else {
                                $(this).fadeOut();
                            }
                        });
                    });
                });
            })(jQuery);
        </script>
        <?php
    }

    function getFieldHtml($params) {
        $shortcode = $params['base'];
        $content_e = $params['content_element'] ? 1 : 0;
        $fields = $params['params'];
        ob_start();
        foreach ($fields as $field):
            ?>
            <div class="field-group <?php echo $field['class'] ? $field['class'] : ''; ?>">
                <div class="field-label"><?php echo $field['heading']; ?></div>
                <div class="field-input">
                    <?php
                    switch ($field['type']) {
                        case 'textfield':
                            echo getTextfield($field['param_name'], $field['value']);
                            break;
                        case 'inwave_select':
                            echo getInwaveSelect($field['param_name'], $field['value'], $field['data'], $field['multiple'] ? $field['multiple'] : 0);
                            break;
                        case 'textarea':
                            echo getTextAreaField($field['param_name'], $field['value']);
                            break;
                        case 'dropdown':
                            echo getDropdownField($field['param_name'], $field['value']);
                            break;
                        case 'textarea_html':
                            echo getTextAreaHtmlField($field['param_name'], $field['value']);
                            break;
                        case 'attach_image':
                            echo getAttachImage($field['param_name'], $field['value']);
                            break;
                        case 'iconpicker':
                        case 'iwicon':
                            echo getIwIconField($field['param_name'], $field['value']);
                            break;
                        case 'colorpicker':
                            echo getColorPickerField($field['param_name'], $field['value']);
                            break;
                        case 'courses_categories':
                            echo getIwCourseCategories($field['param_name'], $field['value']);
                            break;
                        case 'iw_range_skillbar':
                            echo getIwRangeSkillbar($field['param_name'], $field['value'], $field['class'] ? $field['class'] : '');
                            break;
                        default:
                            break;
                    }
                    ?>
                </div>
                <?php if ($field['description']): ?>
                    <div class="field-description"><?php echo $field['description']; ?></div>
                <?php endif; ?>
            </div>
            <?php
        endforeach;
        echo '<input type="hidden" name="shortcode_tag" value="' . $shortcode . '"/>';
        echo '<input type="hidden" name="shortcode_close_tag" value="' . $content_e . '"/>';
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getAttachImage($fname, $fvalue) {
        if (!is_numeric($fvalue)) {
            $fvalue = null;
        }
        ob_start();
        ?>
        <div class="iw-image-field">
            <div class="image-preview iw-hidden"></div>
            <div class="image-add-image"><span><i class="fa fa-plus"></i></span></div>
        </div>
        <input type="hidden" value="<?php echo $fvalue; ?>" name="<?php echo $fname; ?>" class="iw-field iw-image-field-data"/>
        <div style="clear: both;"></div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getTextAreaHtmlField($fname, $fvalue) {
        ob_start();
        ?>
        <div class="textarea_html">
            <textarea class="iw-field iw-textarea-html" name="<?php echo $fname; ?>" id="iw-tinymce-<?php echo $fname; ?>"><?php echo $fvalue; ?></textarea>
        </div>
        <script type="text/javascript">
            (function ($) {
                $('.shortcode-content .field-group').ready(function () {
                    var ed = new tinymce.Editor('iw-tinymce-<?php echo $fname; ?>', {
                    }, tinymce.EditorManager);

                    ed.on('change', function (e) {
                        var content = ed.getContent();
                        $('#iw-tinymce-<?php echo $fname; ?>').text(content);
                    });
                    ed.render();
                });
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getIwCourseCategories($param_name, $value) {
        $product_categories = get_terms('iw_courses_class');
        $output = $selected = $ids = '';
        if ($value !== '') {
            $ids = explode(',', $value);
            $ids = array_map('trim', $ids);
        } else {
            $ids = array();
        }
        ob_start();
        ?>
        <select id="sel2_cat" multiple="multiple" style="min-width:200px;">
            <?php
            foreach ($product_categories as $cat) {
                if (in_array($cat->term_id, $ids)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                echo '<option ' . $selected . ' value="' . $cat->term_id . '">' . $cat->name . '</option>';
            }
            ?>
        </select>

        <input type='hidden' name='<?php echo $param_name; ?>' value='<?php echo $value; ?>' class='iw-field' id='sel_cat'>

        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $("#sel2_cat").on("change", function () {
                        $("#sel_cat").val($(this).val());
                    });
                });
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getIwServerLoactionHtml($param_name, $value, $class) {
        $markers = json_decode(base64_decode($value));
        $posts = get_posts(array('posts_per_page' => -1));
        ob_start();
        ?>
        <div class="iw-server-location-wrap">
            <div class="controls">
                <span class="button load-image"><?php _e('Load map image', 'inwavethemes'); ?></span>
                <span class="button add-location"><?php _e('Add location', 'inwavethemes'); ?></span>
                <span class="button remove-location disabled"><?php _e('Remove location', 'inwavethemes'); ?></span>
            </div>
            <div class="image-map-preview">
                <div class="image">
                    <?php
                    if ($markers[0]) {
                        $mapimg = wp_get_attachment_image_src($markers[0], 'large');
                        $map_img_src = $mapimg[0];
                    } else {
                        $map_img_src = plugins_url('iw_composer_addons/assets/images/map.png');
                    }
                    ?>
                    <img src="<?php echo $map_img_src; ?>"/>
                    <input type="hidden" value="<?php echo $markers[0] ? $markers[0] : ''; ?>" name="map_image"/>
                </div>
                <div class="map-pickers">
                    <?php
                    if (!empty($markers[1]) && $markers[1]) {
                        foreach ($markers[1] as $marker) {
                            $style = '';
                            $pos = explode('x', $marker[1]);
                            $style = 'left:' . $pos[0] * 100 . '%; top:' . $pos[1] * 100 . '%;';
                            echo '<span data-post="' . $marker[0] . '" data-position="' . $marker[1] . '" class="map-picker" style="' . $style . '"></span>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="iw-tabs accordion location-list iw-hidden">
                <div class="iw-accordion-content">
                    <div class="field-group">
                        <div class="label"><?php _e('Select marker Post', 'inwavethemes'); ?></div>
                        <div class="field">
                            <select id="sel_post" class="sel_post" style="min-width:200px;">
                                <?php
                                echo '<option value="">' . __('Select post', 'inwavethemes') . '</option>';
                                foreach ($posts as $post) {
                                    echo '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <input type='hidden' name='<?php echo $param_name; ?>' value='<?php echo $value; ?>' class='marker-location-data iw-field <?php echo $class; ?>'>

        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getIwIconField($fname, $fvalue) {
        $class = $settings['class'] ? $settings['class'] : '';
        $class .= ' wpb_vc_param_value ' . $name . " " . $type;
        ob_start();
        ?>
        <div class="control-icon">
            <div class="icon-preview" onclick="jQuery('.iw-list-icon-wrap').slideToggle();">
                <span><i class="<?php echo $fvalue; ?>"></i></span>
            </div>
            <div class="icon-filter">
                <input class="filter-input" style="width:49%" onclick="jQuery('.iw-list-icon-wrap').slideDown();" placeholder="<?php echo __('Click to select new or search...', 'inwavethemes'); ?>" type="text"/>
                <select class="filter-input-type" style="width:49%">
                    <option value="">All</option>
                    <option value="fa">FontAwesome</option>
                    <option value="whhg">WebHostingHub</option>
                    <option value="glyphicons">Glyphicons</option>
                </select>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="iw-list-icon-wrap" style="display:none;">
            <input name="<?php echo $fname; ?>" type="hidden" value="<?php echo $fvalue; ?>" class="iw-icon-input-cs iw-field iw-iwicon-field <?php echo $class; ?>">
            <div class="list-icon-wrap">
                <ul id="iw-list-icon" class="list-icon">
                    <?php
                    echo getSearchIconsHtml('', '', $fvalue);
                    ?>
                </ul>
                <div class="ajax-overlay">
                    <span class="ajax-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                </div>
            </div>

        </div>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    var xhr = '';
                    var timeout = '';
                    $('.icon-filter .filter-input').on('input', function () {
                        var filterVal = $(this).val();
                        var type = $(this).parent().find('.filter-input-type').val();
                        $('.list-icon-wrap .ajax-overlay').fadeIn();
                        jQuery('.iw-list-icon-wrap').slideDown();
                        if (xhr) {
                            xhr.abort();
                        }
                        clearTimeout(timeout);
                        timeout = setTimeout(function () {
                            xhr = $.ajax({
                                url: iwConfig.ajaxUrl,
                                data: {action: 'searchIcons', 'key': filterVal, 'type': type},
                                type: "post",
                                success: function (data) {
                                    $('#iw-list-icon').html(data);
                                    $('.list-icon-wrap .ajax-overlay').fadeOut();
                                }
                            });
                        }, 200);

                    });
                    $('.icon-filter .filter-input-type').on('change', function () {
                        $('.icon-filter .filter-input').trigger('input');
                    })
                    $('body').on('click', '.icon-item', function () {
                        var value = $(this).data('icon');
                        var html = '<span><i class="' + value + '"></i></span>';
                        $('.control-icon .icon-preview').html(html);
                        $('input[name="<?php echo $fname; ?>"]').val(value);
                        $('.icon-item').removeClass('selected');
                        $(this).addClass('selected');
                        $('.iw-list-icon-wrap').slideUp();
                    });
                });
                $('body').on('change', '.iw-icon-input-cs', function () {
                    var value = jQuery(this).val();
                    var html = '<i class="' + value + '"></i>';
                    $('.control-icon .icon-preview').html(html);
                })
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getSearchIconsHtml($type = 'fa', $key = '', $fvalue = '', $limit = 400) {
        $fonts = array();
        include_once('inc/font-data.php');
        $result = array();
        if ($type) {
            $types = array($type);
        } else {
            $types = array('fa', 'whhg', 'glyphicons');
        }
        $i = 0;
        foreach ($types as $type) {
            foreach ($fonts[$type] as $icon) {
                if ($key == '' || strpos($icon, $key) !== false) {
                    if ($type == 'fa') {
                        $icon = 'fa fa-' . $icon;
                    } else if ($type == 'whhg') {
                        $icon = 'iwf-' . $icon;
                    } else {
                        $icon = 'glyphicon glyphicon-' . $icon;
                    }
                    $result[] = $icon;
                    $i++;
                }
                if ($i == $limit)
                    break;
            }
            if ($i == $limit)
                break;
        }

        $html = '';
        if (count($result)) {
            $html .= '<li title="No icon" class="icon-item" data-icon=""><span class="icon"><i class=""></i></span></li>';
            foreach ($result as $icon) {

                $html .= '<li class="icon-item ' . ($icon == $fvalue ? 'selected' : '') . '" data-icon="' . $icon . '"><span class="icon"><i class="' . $icon . '"></i></span></li>';
            }
        } else {
            $html .= '<li>Not found</li>';
        }
        return $html;
    }

    function getColorPickerField($fname, $fvalue) {
        $html = '<div class="iwcolor-picker color-group"><input type="text" value="' . htmlspecialchars($fvalue) . '" name="' . $fname . '" class="vc_color-control iw-field input-field"></div>';
        $html .= "<script>if(typeof('vc') != undefined) vc.atts.colorpicker.init('','.iwcolor-picker')</script>";

        wp_enqueue_script('wpb_js_composer_js_atts');
        return $html;
    }

    function getTextfield($fname, $fvalue) {
        return '<input type="text" value="' . htmlspecialchars($fvalue) . '" name="' . $fname . '" class="iw-field input-field"/>';
    }

    function getTextAreaField($fname, $fvalue) {
        return '<textarea name="' . $fname . '" class="iw-field textarea-field">' . $fvalue . '</textarea>';
    }

    function getDropdownField($fname, $fvalue) {
        $html = '';
        $html .= '<select name="' . $fname . '" class="iw-field dropdown-field">';
        foreach ($fvalue as $text => $value) {
            $html .= '<option value="' . $value . '">' . $text . '</option>';
        }
        $html.='</select>';
        return $html;
    }

    function getIwRangeSkillbar($fname, $fvalue, $class) {
        $html = '<input class="skillbar_input iw-field ' . $class . '" value="' . $fvalue . '" type="range" min="0" max="100" step="1" name="' . $fname . '"/>
				<span class="value-view">' . ($fvalue ? $fvalue : 50) . '%</span>
					<script>
						jQuery("input.skillbar_input").on("input", function(){
							jQuery(this).parent().find(".value-view").text(jQuery(this).val() + "%");
						});
					</script>
				';
        return $html;
    }

    function getInwaveSelect($fname, $fvalue, $fdata, $fmulti) {
        $data_value = $fvalue ? explode(',', $fvalue) : array();
        ob_start();
        if ($fmulti) {
            $multiselect = 'multiple="multiple"';
            echo '<select id="iw_select" ' . $multiselect . ' style="min-width:200px;">';
        } else {
            echo '<select id="iw_select" style="min-width:200px;">';
        }

        //Duyet qua tung phan tu cua mang du lieu de tao option tuong ung
        foreach ($fdata as $option) {
            if (is_array($data_value)) {
                if (in_array($option['value'], $data_value)) {
                    echo '<option value="' . $option['value'] . '" selected="selected">' . htmlspecialchars($option['text']) . '</option>';
                } else {
                    echo '<option value="' . $option['value'] . '">' . htmlspecialchars($option['text']) . '</option>';
                }
            } else {
                echo '<option value="' . $option['value'] . '" ' . (($option['value'] == $fvalue) ? 'selected="selected"' : '') . '>' . $option['text'] . '</option>';
            }
        }
        echo '</select>';
        echo '<input type="hidden" name="' . $fname . '" id="' . $fname . '" value="' . $fvalue . '" class="iw-field"/>';
        ?>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $("#iw_select").on("change", function () {
                        $("#<?php echo $fname; ?>").val($(this).val());
                    });
                });
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    if (!function_exists('getShortcodeScript')) {

        function getShortcodeScript($scripts) {
            if ($scripts) {
                $theme_info = wp_get_theme();
                foreach ($scripts as $key => $scripts2) {
                    foreach ($scripts2 as $key2 => $script) {
                        if ($key == 'scripts') {
                            wp_enqueue_script($key2, $script, array('jquery'), $theme_info->get('Version'));
                        } else {
                            wp_enqueue_style($key2, $script, array(), $theme_info->get('Version'));
                        }
                    }
                }
            }
        }

    }
}
