<?php
/**
 * Add portfolio custom post type.
 *
 * @since 1.0.0
 */
require_once 'utility.php';
require_once 'classes/portfolioBox.php';


if (!function_exists('iw_portfolio_add_post_types_portfolio')) {

// Register Custom Post Type
    function iw_portfolio_add_post_types_portfolio() {
        $utility = new iwcUtility();
        $slug = $utility->getPortfolioOption('portfolio_slug', 'portfolio');

        $support = array('title', 'editor', 'thumbnail', 'page-attributes');
        if (get_option('enable_voting') && get_option('enable_voting') == 1) {
            array_push($support, 'comments');
        }
        $labels = array(
            'name' => _x('Portfolios', 'Post Type General Name', 'inwavethemes'),
            'singular_name' => _x('Portfolio', 'Post Type Singular Name', 'inwavethemes'),
            'menu_name' => __('Portfolios', 'inwavethemes'),
            'parent_item_colon' => __('Parent Item:', 'inwavethemes'),
            'all_items' => __('All Portfolios', 'inwavethemes'),
            'view_item' => __('View Item', 'inwavethemes'),
            'add_new_item' => __('Add new', 'inwavethemes'),
            'add_new' => __('Add New', 'inwavethemes'),
            'edit_item' => __('Edit Item', 'inwavethemes'),
            'update_item' => __('Update Item', 'inwavethemes'),
            'search_items' => __('Search Item', 'inwavethemes'),
            'not_found' => __('Not found', 'inwavethemes'),
            'not_found_in_trash' => __('Not found in Trash', 'inwavethemes'),
        );
        $args = array(
            'label' => __('iw_portfolio', 'inwavethemes'),
            'description' => __('Post Type Description', 'inwavethemes'),
            'labels' => $labels,
            'supports' => $support,
            'hierarchical' => true,
            'query_var' => 'iw_portfolio',
            'menu_icon' => 'dashicons-welcome-learn-more',
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'rewrite' => array('slug' => $slug),
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
        );
        register_post_type('iw_portfolio', $args);
    }

}



/**
 * Add portfolio taxonomy.
 *
 * @since 1.0.0
 */
if (!function_exists('iw_portfolio_add_taxonomy_class')) {

    function iw_portfolio_add_taxonomy_class() {

        $singular = 'Portfolio Category';
        $plural = 'Portfolio Categories';
        $utility = new iwcUtility();
        $slug = $utility->getPortfolioOption('category_slug', 'portfolio-category');
        $labels = array(
            'name' => _x($plural, 'taxonomy general name', 'inwavethemes'),
            'singular_name' => _x($singular, 'taxonomy singular name', 'inwavethemes'),
            'search_items' => sprintf(__('Search %s', 'inwavethemes'), $plural),
//            'popular_items' => sprintf(__('Popular %s', 'inwavethemes'), $plural),
            'all_items' => sprintf(__('All %s', 'inwavethemes'), $plural),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => sprintf(__('Edit %s', 'inwavethemes'), $singular),
            'update_item' => sprintf(__('Update %s', 'inwavethemes'), $singular),
            'add_new_item' => sprintf(__('Add New %s', 'inwavethemes'), $singular),
            'new_item_name' => sprintf(__('New %s Name', 'inwavethemes'), $singular),
            'separate_items_with_commas' => sprintf(__('Separate %s with commas', 'inwavethemes'), $plural),
            'add_or_remove_items' => sprintf(__('Add or remove %s', 'inwavethemes'), $plural),
            'choose_from_most_used' => sprintf(__('Choose from the most used %s', 'inwavethemes'), $plural)
        );

        register_taxonomy(
                'iwp_category', array('iw_portfolio'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'rewrite' => array(
                'slug' => $slug,
                'hierarchical' => true,
            )
                )
        );
    }

}


/* * *********************************************************
 * *********** FUNCTION PROCESS TAXONOMY TYPE CLASS *********
 * ******************************************************** */

function class_metabox_add($tag) {
    ?>
    <script>
        jQuery(function ($) {
            var frame;

            $('#portfolio_cat_add_button').on('click', function (e) {
                e.preventDefault();

                // Set options
                var options = {
                    state: 'insert',
                    frame: 'post'
                };

                frame = wp.media(options).open();

                // Tweak views
                frame.menu.get('view').unset('gallery');
                frame.menu.get('view').unset('featured-image');

                frame.toolbar.get('view').set({
                    insert: {
                        style: 'primary',
                        text: '<?php _e('Insert', 'inwavethemes'); ?>',
                        click: function () {
                            var models = frame.state().get('selection'),
                                    url = models.first().attributes.url;

                            $('#iw_portfolio_cat_image').val(url);

                            frame.close();
                        }
                    } // end insert
                });
            });
        });
    </script>
    <div class="form-field">
        <label for="image-url"><?php _e("Image URL") ?></label>
        <input type="text" name="iw_portfolio_cat_image" id='iw_portfolio_cat_image' value='' class='file' />
        <input type='button' class='button' name='portfolio_cat_add_button' id='portfolio_cat_add_button' value='Browse' />
        <p class="description"><?php _e('This image will be the thumbnail shown on the category page.'); ?></p>

    </div>
    <?php
}

function class_metabox_edit($tag) {
    $iw_portfolio_cat_image = get_option("iw_portfolio_cat_image_" . $tag->term_id); // Do the check
    ?>
    <script>
        jQuery(function ($) {
            var frame;

            $('#portfolio_cat_add_button').on('click', function (e) {
                e.preventDefault();

                // Set options
                var options = {
                    state: 'insert',
                    frame: 'post'
                };

                frame = wp.media(options).open();

                // Tweak views
                frame.menu.get('view').unset('gallery');
                frame.menu.get('view').unset('featured-image');

                frame.toolbar.get('view').set({
                    insert: {
                        style: 'primary',
                        text: '<?php _e('Insert', 'inwavethemes'); ?>',
                        click: function () {
                            var models = frame.state().get('selection'),
                                    url = models.first().attributes.url;

                            $('#iw_portfolio_cat_image').val(url);

                            frame.close();
                        }
                    } // end insert
                });
            });
        });
    </script>
    <tr class="form-field">
        <th scope="row"><label for="image-url"><?php _e("Image URL") ?></label></th>
        <td>
            <img src="<?php echo $iw_portfolio_cat_image; ?>" width="200px"/>
            <input style="width: 80%;" type="text" name="iw_portfolio_cat_image" id='iw_portfolio_cat_image' value='<?php echo $iw_portfolio_cat_image; ?>' class='file' />
            <input style="width: 14%;" type='button' class='button' name='portfolio_cat_add_button' id='portfolio_cat_add_button' value='<?php echo __('Browse'); ?>' />
            <br/>
            <span class="description"><?php _e('This image will be the thumbnail shown on the category page.'); ?></span></td>
    </tr>
    <?php
}

// A callback function to save our extra taxonomy field(s)
function save_class_taxonomy_iw_portfolio($term_id) {
    if (isset($_POST['iw_portfolio_cat_image'])) {
        update_option("iw_portfolio_cat_image_" . $term_id, $_POST['iw_portfolio_cat_image']);
    }
}

/* * *************** END FUNCTION PROCESS TAXONOMY TEACHER ****************** */

/* * *********************************************************
 * ******** FUNCTION ADD METABOX FOR IW PORTFOLIO POST ********
 * ******************************************************** */

function addPortfoliosBox() {
    new portfolioBox();
}

/**
 * Register and enqueue scripts and styles for admin.
 *
 * @since 1.0.0
 */
if (!function_exists('portfolioAdminAddScript')) {

    function portfolioAdminAddScript() {
        $screen = get_current_screen();
        wp_enqueue_style('iw-portfolio-admin-style', plugins_url('iw_portfolio/assets/css/iw_portfolio_admin.css'));
        if ($screen->id == 'iw_portfolio_page_settings') {
            wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
        }
        /* Enqueue JS files */
        wp_register_script('iwc-admin', plugins_url() . '/iw_portfolio/assets/js/iw_portfolio_js.js', array('jquery'), '1.0.0', true);
        wp_localize_script('iwc-admin', 'iwcCfg', array('siteUrl' => admin_url(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php')));
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('iwc-admin');

        global $post;
// Check to load only on adding page
        if (isset($post)) {
// Localize script to use when saving portfolio images
            wp_localize_script('iwc-admin', 'iw_portfolio_ajax', array(
                'post_id' => $post->ID,
                'nonce' => wp_create_nonce('iw_portfolio_ajax_nonce'),
            ));
        }


        wp_enqueue_style('iwc-jquery-ui');
    }

}


if (!function_exists('optionRenderPage')) {

    function optionRenderPage() {
        include_once 'html.settings.php';
    }

}
if (!function_exists('iwcExtrafieldRenderPage')) {

    function iwcExtrafieldRenderPage() {
        include_once 'html.extrafield.list.php';
    }

}
if (!function_exists('iwcAddExtrafieldRenderPage')) {

    function iwcAddExtrafieldRenderPage() {
        include_once 'html.extrafield.edit.php';
    }

}
if (!function_exists('saveSetting')) {

    function saveSetting() {
        $utility = new iwcUtility();
        if (isset($_POST) && !empty($_POST)) {
            if (!get_option('iw_portfolio_settings')) {
                if (add_option('iw_portfolio_settings', $_POST)) {
                    $_SESSION['bt_message'] = $utility->getMessage(__('Setting has been saved successfully'));
                } else {
                    $_SESSION['bt_message'] = $utility->getMessage(__('Error'), 'error');
                }
            } else {
                if (update_option('iw_portfolio_settings', $_POST)) {
                    $_SESSION['bt_message'] = $utility->getMessage(__('Setting has been updated successfully'));
                } else {
                    $_SESSION['bt_message'] = $utility->getMessage(__('No change has been made'));
                }
            }
            if ($_POST['enable_review'] == '1') {
                $utility->updatePostCommentStatus(true);
            } else {
                $utility->updatePostCommentStatus();
            }
        } else {
            $_SESSION['bt_message'] = $utility->getMessage(__('No data send'), 'error');
        }

        wp_redirect(admin_url('options-general.php?page=iw_portfolio_settings'));
    }

}
if (!function_exists('saveIwPortfolioExtraField')) {

    function saveIwPortfolioExtraField() {
        $utility = new iwcUtility();
        if (isset($_POST)) {
            global $wpdb;
            $title = '';
            $field_type = '';
            $port_category = '';
            $text_value = '';
            $link_value_text = '';
            $link_value_link = '';
            $link_value_target = '';
            $measurement_value = '';
            $measurement_unit = '';
            $string_value = '';
            $drop_value = '';
            $image_text = '';
            $date_value = '';
            $check_value = '';
            $description = '';
            $status = '';
            $default_value = '';
            $datacheck = FALSE;
            $msg = '';
            if ($_POST['title'] != '') {
                $title = $_POST['title'];
            } else {
                $msg .= __('- Please input name of field<br/>');
            }
            $_SESSION['extrafield']['name'] = stripslashes($title);
            if ($_POST['field_type'] != '') {
                $field_type = $_POST['field_type'];
            } else {
                $msg .= __('- Please select a field type<br/>');
            }
            $_SESSION['extrafield']['fieldtype'] = $field_type;
            if ($_POST['port_category'] != '') {
                $port_category = $_POST['port_category'];
            }
            $_SESSION['extrafield']['categories'] = $port_category;

            if ($_POST['link_value_link'] != '') {
                $link_value_link = $_POST['link_value_link'];
            }
            $_SESSION['extrafield']['link_value_link'] = stripslashes($link_value_link);
//
            if ($_POST['link_value_text'] != '') {
                $link_value_text = $_POST['link_value_text'];
            } else {
                $link_value_text = stripslashes($link_value_link);
            }
            $_SESSION['extrafield']['link_value_text'] = stripslashes($link_value_text);
//
            if ($_POST['text_value'] != '') {
                $text_value = stripslashes($_POST['text_value']);
            }
            $_SESSION['extrafield']['text_value'] = $text_value;
//
            if ($_POST['link_value_target'] != '') {
                $link_value_target = $_POST['link_value_target'];
            }
            $_SESSION['extrafield']['link_value_target'] = $link_value_target;
//
            if ($_POST['measurement_value'] != '') {
                $measurement_value = stripslashes($_POST['measurement_value']);
            }
            $_SESSION['extrafield']['measurement_value'] = $measurement_value;
//
            if ($_POST['measurement_unit'] != '') {
                $measurement_unit = stripslashes($_POST['measurement_unit']);
            }
            $_SESSION['extrafield']['measurement_unit'] = $measurement_unit;
//
            if ($_POST['string_value'] != '') {
                $string_value = stripslashes($_POST['string_value']);
            }
            $_SESSION['extrafield']['string_value'] = $string_value;
//
            if ($_POST['drop_value'] != '') {
                $drop_value = stripslashes($_POST['drop_value']);
            }
            $_SESSION['extrafield']['drop_value'] = $drop_value;
//
            if ($_POST['drop_multiselect'] != '') {
                $check_value = $_POST['drop_multiselect'];
            }
            $_SESSION['extrafield']['drop_multiselect'] = $check_value;
//
            if ($_POST['image_text'] != '') {
                $image_text = $_POST['image_text'];
            }
            $_SESSION['extrafield']['image_text'] = $image_text;
//
            if ($_POST['date_value'] != '') {
                $date_value = $_POST['date_value'];
            }
            $_SESSION['extrafield']['date_value'] = $date_value;
//
            if ($_POST['description'] != '') {
                $description = stripslashes($_POST['description']);
            }
            $_SESSION['extrafield']['description'] = $description;
//
            if ($_POST['status'] != '') {
                $status = $_POST['status'];
            }
            $_SESSION['extrafield']['status'] = $status;
//
            if ($field_type == 'textarea') {
                $default_value = $text_value;
            }
            if ($field_type == 'link') {
                $default_value = serialize(array('link_value_link' => $link_value_link, 'link_value_text' => $link_value_text, 'link_value_target' => $link_value_target));
            }
            if ($field_type == 'image') {
                $default_value = $image_text;
            }
            if ($field_type == 'text') {
                $default_value = $string_value;
            }
            if ($field_type == 'dropdown_list') {
                $default_value = serialize(array($drop_value, $check_value));
            }
            if ($field_type == 'date') {
                $default_value = $date_value;
            }
            if ($field_type == 'measurement') {
                $default_value = serialize(array('measurement_value' => $measurement_value, 'measurement_unit' => $measurement_unit));
            }
            if ($msg == '') {
                $data = array(
                    'name' => $title,
                    'type' => $field_type,
                    'default_value' => $default_value,
                    'description' => $description,
                    'published' => $status
                );
                if ($_POST['id']) {
                    $wpdb->update($wpdb->prefix . "iw_portfolio_extrafields", $data, array('id' => $_POST['id']));
                    $wpdb->delete($wpdb->prefix . "iw_portfolio_extrafields_category", array('extrafields_id' => $_POST['id']));
                    if ($port_category[0] == '') {
                        $wpdb->insert($wpdb->prefix . "iw_portfolio_extrafields_category", array('category_id' => 0, 'extrafields_id' => $_POST['id']));
                    } else {
                        foreach ($port_category as $value) {
                            $wpdb->insert($wpdb->prefix . "iw_portfolio_extrafields_category", array('category_id' => $value, 'extrafields_id' => $_POST['id']));
                        }
                    }
                    $_SESSION['bt_message'] = $utility->getMessage(__('Extrafield had been updated'));
                    unset($_SESSION['extrafield']);
                    wp_redirect(admin_url('edit.php?post_type=iw_portfolio&page=add-extra-field&id=' . $_POST['id']));
                    return;
                } else {
                    $ins = $wpdb->insert($wpdb->prefix . "iw_portfolio_extrafields", $data);
                    if ($ins) {
                        $id = $wpdb->insert_id;
                        if ($port_category[0] == '') {
                            $wpdb->insert($wpdb->prefix . "iw_portfolio_extrafields_category", array('category_id' => 0, 'extrafields_id' => $id));
                        } else {
                            foreach ($port_category as $value) {
                                $wpdb->insert($wpdb->prefix . "iw_portfolio_extrafields_category", array('category_id' => $value, 'extrafields_id' => $id));
                            }
                        }
                        $_SESSION['bt_message'] = $utility->getMessage(__('Extrafield had been created'));
                        unset($_SESSION['extrafield']);
                        wp_redirect(admin_url('edit.php?post_type=iw_portfolio&page=iwp-add-extra-field&id=' . $id));
                        return;
                    }
                }
            } else {
                $_SESSION['bt_message'] = $utility->getMessage($msg, 'error');
            }
        } else {
            $_SESSION['bt_message'] = $utility->getMessage(__('No data send'), 'error');
        }
        wp_redirect(admin_url('edit.php?post_type=iw_portfolio&page=iwp-add-extra-field'));
    }

}


global $iw_portfolio_db_version;
$iw_portfolio_db_version = '1.0.0';

if (!function_exists('iw_portfolio_install')) {

    function iw_portfolio_install() {
        global $wpdb;
        global $iw_portfolio_db_version;

        /*
         * We'll set the default character set and collation for this table.
         * If we don't do this, some characters could end up being converted
         * to just ?'s when saved in our table.
         */
        $charset_collate = '';
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        if (!empty($wpdb->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        }

        if (!empty($wpdb->collate)) {
            $charset_collate .= " COLLATE {$wpdb->collate}";
        }
//Add table iw_portfolio_extrafields
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "iw_portfolio_extrafields (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(255),
                    `type` varchar(20),
                    `default_value` text,
                    `description` text,
                    `ordering` int(11),
                    `published` int(11),
                    PRIMARY KEY (`id`)
	) $charset_collate;";
        dbDelta($sql);
//Add table iw_portfolio_extrafields_values
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "iw_portfolio_extrafields_value (
		`portfolio_id` int(11),
		`extrafields_id` int(11),
		`value` text
	) " . $charset_collate . ";";
        dbDelta($sql);

//Add table iw_portfolio_extrafields_values
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "iw_portfolio_extrafields_category (
		category_id int(11),
		extrafields_id int(11)
	) " . $charset_collate . ";";
        dbDelta($sql);

//Add table vote
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "iw_portfolio_vote (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11),
                `item_id` int(11),
                `vote` int(2),
                `ip` varchar(255),
                `created` datetime,
                PRIMARY KEY (`id`)
	) " . $charset_collate . ";";

        dbDelta($sql);
        add_option('iw_portfolio_db_version', $iw_portfolio_db_version);
//Add Single portfolio theme
        $files = array('single-iw_portfolio.php', 'taxonomy-iwp_category.php');
        $template_path = get_template_directory();
        foreach ($files as $file) {
            if (!file_exists($template_path . '/' . $file)) {
                $theme_plugin_path = WP_PLUGIN_DIR . '/iw_portfolio/themes/';
                copy($theme_plugin_path . $file, $template_path . '/' . $file);
            }
        }
        flush_rewrite_rules();
    }

}

if (!function_exists('iw_portfolio_uninstall')) {

    function iw_portfolio_uninstall() {
        global $wpdb;
        /**
         * 1. delete all post by post_type
         * 2. Delete all taxonomy and term by post_type
         * 3. Delete all option
         * 4. Delete All table of plugin
         * 5. Delete single post template
         */
//Delete post
        $listPost = $wpdb->get_results("SELECT ID from " . $wpdb->prefix . "posts WHERE post_type='iw_portfolio'");
        if (!empty($listPost)) {
            foreach ($listPost as $post) {
                $wpdb->delete($wpdb->prefix . "posts", array('post_parent' => $post->ID));
                $wpdb->delete($wpdb->prefix . "term_relationships", array('object_id' => $post->ID));
            }
            $wpdb->delete($wpdb->prefix . "posts", array('post_type' => 'iw_portfolio'));
        }

//Delete taxonomy
        $listTaxonomy = $wpdb->get_results("SELECT term_id from " . $wpdb->prefix . "term_taxonomy WHERE taxonomy='iwp_category'");
        if (!empty($listTaxonomy)) {
            foreach ($listTaxonomy as $term) {
                $wpdb->delete($wpdb->prefix . "terms", array('term_id' => $term->term_id));
            }
            $wpdb->delete($wpdb->prefix . "term_taxonomy", array('taxonomy' => 'iwp_category'));
        }

//Delete Options
        delete_option('iwp_category_children');
        delete_option('iw_portfolio_settings');
        delete_option('iw_portfolio_db_version');

//Delete all table of module
        $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "iw_portfolio_extrafields");
        $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "iw_portfolio_extrafields_category");
        $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "iw_portfolio_extrafields_value");
        $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "iw_portfolio_vote");

//Delete single post template
        if (file_exists(get_template_directory() . '/single-iw_portfolio.php')) {
            unlink(get_template_directory() . '/single-iw_portfolio.php');
        }
    }

}

if (!function_exists('deleteExtraFields')) {

    function deleteExtraFields() {
        $utility = new iwcUtility();
        if (isset($_POST['fields']) && !empty($_POST['fields'])) {
            global $wpdb;
            $fielsd_selected = $_POST['fields'];
            foreach ($fielsd_selected as $id) {
                $wpdb->delete($wpdb->prefix . "iw_portfolio_extrafields_value", array('extrafields_id' => $id));
                $wpdb->delete($wpdb->prefix . "iw_portfolio_extrafields_category", array('extrafields_id' => $id));
                $wpdb->delete($wpdb->prefix . "iw_portfolio_extrafields", array('id' => $id));
            }
            $_SESSION['bt_message'] = $utility->getMessage(__('Delete row(s) success'));
        } else {
            $_SESSION['bt_message'] = $utility->getMessage(__('Please select row(s) to delete'), 'error');
        }
        wp_redirect(admin_url('edit.php?post_type=iw_portfolio&page=extra-field'));
    }

}

if (!function_exists('deleteExtraField')) {

    function deleteExtraField() {
        $utility = new iwcUtility();
        if (isset($_GET) && $_GET != '') {
            global $wpdb;
            $id = intval($_GET['id']);
            $wpdb->delete($wpdb->prefix . 'iw_portfolio_extrafields_value', array('extrafields_id' => $id));
            $wpdb->delete($wpdb->prefix . 'iw_portfolio_extrafields_category', array('extrafields_id' => $id));
            $wpdb->delete($wpdb->prefix . 'iw_portfolio_extrafields', array('id' => $id));
            $_SESSION['bt_message'] = $utility->getMessage(__('Deleted the row successfully'));
        } else {
            $_SESSION['bt_message'] = $utility->getMessage(__('Please select a row to delete'), 'error');
        }
        wp_redirect(admin_url('edit.php?post_type=iw_portfolio&page=extra-field'));
    }

}

/**
 * Add a new image size.
 *
 * @since 1.0.0
 */
if (!function_exists('iwcAddImageSize')) {

    function iwcAddImageSize() {
        $utility = new iwcUtility();
        $large_crop = array();
        $crop_pos = $utility->getPortfolioOption('crop_position', 'center');
        switch ($crop_pos) {
            case 'top_left':
                $large_crop = array('top', 'left');
                break;
            case 'top_middle':
                $large_crop = array('top', 'center');
                break;
            case 'top_right':
                $large_crop = array('top', 'right');
                break;
            case 'buttom_left':
                $large_crop = array('buttom', 'left');
                break;
            case 'buttom_middle':
                $large_crop = array('buttom', 'center');
                break;
            case 'buttom_right':
                $large_crop = array('buttom', 'right');
                break;
            default:
                $large_crop = array('center', 'center');
                break;
        }

        if ($utility->getPortfolioOption('large_image_proc', 'crop') == 'crop') {
            add_image_size('iw_portfolio-large', $utility->getPortfolioOption('image_width', '770'), $utility->getPortfolioOption('image_height', '498'), $crop_pos);
        } else if ($utility->getPortfolioOption('large_image_proc', 'crop') == 'resize') {
            add_image_size('iw_portfolio-large', $utility->getPortfolioOption('image_width', '770'), $utility->getPortfolioOption('image_height', '498'));
        } else {
            add_image_size('iw_portfolio-large', $utility->getPortfolioOption('image_width', '770'), $utility->getPortfolioOption('image_height', '498'), false);
        }

        if ($utility->getPortfolioOption('thumb_image_proc', 'crop') == 'crop') {
            add_image_size('iw_portfolio-thumb', $utility->getPortfolioOption('thumb_width', '600'), $utility->getPortfolioOption('thumb_height', '388'), $crop_pos);
            //add_image_size('iw_portfolio-slideshow-thumb', $utility->getPortfolioOption('slideshow_thumb_width', '70'), $utility->getPortfolioOption('slideshow_thumb_height', '40'), $crop_pos);
        } else if ($utility->getPortfolioOption('thumb_image_proc', 'crop') == 'resize') {
            add_image_size('iw_portfolio-thumb', $utility->getPortfolioOption('thumb_width', '600'), $utility->getPortfolioOption('thumb_height', '388'));
            //add_image_size('iw_portfolio-slideshow-thumb', $utility->getPortfolioOption('slideshow_thumb_width', '70'), $utility->getPortfolioOption('slideshow_thumb_height', '40'));
        } else {
            add_image_size('iw_portfolio-thumb', $utility->getPortfolioOption('thumb_width', '600'), $utility->getPortfolioOption('thumb_height', '388'), false);
            //add_image_size('iw_portfolio-slideshow-thumb', $utility->getPortfolioOption('slideshow_thumb_width', '70'), $utility->getPortfolioOption('slideshow_thumb_height', '40'), false);
        }
    }

}

if (!function_exists('iwc_post_delete')) {

    function iwc_post_delete($pid) {
        global $wpdb;
        $wpdb->delete($wpdb->prefix . 'iw_portfolio_extrafields_value', array('portfolio_id' => $pid));
    }

}