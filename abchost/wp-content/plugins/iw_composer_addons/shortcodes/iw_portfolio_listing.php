<?php

/*
 * Inwave_Portfolio_Listing for Visual Composer
 */
if (!class_exists('Inwave_Portfolio_Listing')) {

    class Inwave_Portfolio_Listing {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('iw_portfolio_listing', array($this, 'iwe_portfolio_listing_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'IW Portfolio Listing',
                'description' => __('Create a list of portfolios', 'inwavethemes'),
                'base' => 'iw_portfolio_listing',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Portfolio Category",
                        "param_name" => "category",
                        "value" => $this->getIwpCategories()
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Order By",
                        "param_name" => "order_by",
                        "value" => array(
                            "Date" => "date",
                            "Title" => "title",
                            "Portfolio ID" => "ID",
                            "Name" => "name",
                            "menu_order" => "Ordering",
                            "Random" => "rand"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Order Direction",
                        "param_name" => "order_dir",
                        "value" => array(
                            "Descending" => "desc",
                            "Ascending" => "asc"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of portfolio per page", "inwavethemes"),
                        "param_name" => "limit",
                        "value" => 12
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Number of column",
                        "param_name" => "number_column",
                        "value" => array(
                            "1" => "1",
                            "2" => "2",
                            "3" => "3",
                            "4" => "4"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Show filter bar",
                        "param_name" => "show_filter_bar",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['iw_portfolio_listing'] = $this->params;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function iwe_portfolio_listing_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                "category" => "0",
                "order_by" => "date",
                "order_dir" => "desc",
                "limit" => 12,
                "show_filter_bar" => '1',
                "number_column" => '3',
                "class" => ""
                            ), $atts));

            ob_start();
            echo do_shortcode('[iw_portfolio_list cats="' . $category . '" show_filter_bar="' . $show_filter_bar . '" item_per_page="' . $limit . '" order_by="' . $order_by . '" order_dir="' . $order_dir . '" number_column="'.$number_column.'"]');
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        function getIwpCategories() {
            global $wpdb;
            $categories = $wpdb->get_results('SELECT a.term_id,a.name, a.slug FROM ' . $wpdb->prefix . 'terms AS a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy AS b ON a.term_id = b.term_id WHERE b.taxonomy=\'iwp_category\'');
            $newCategories = array();
            $newCategories[__("All", "inwavethemes")] = '0';
            foreach ($categories as $cat) {
                $newCategories[$cat->name] = $cat->term_id;
            }
            return $newCategories;
        }

    }

}

new Inwave_Portfolio_Listing();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Portfolio_Listing extends WPBakeryShortCode {
        
    }

}