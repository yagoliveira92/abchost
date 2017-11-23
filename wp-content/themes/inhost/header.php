<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package inhost
 */
global $smof_data, $inwave_cfg;
include(get_template_directory() . '/inc/initvars.php');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php esc_attr(bloginfo('charset')); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
        <?php if (!function_exists('wp_site_icon') || !has_site_icon()) { ?>
            <?php if ($smof_data['favicon']) { ?>
                <link rel="shortcut icon" href="<?php echo esc_url($smof_data['favicon']); ?>" type="image/x-icon"/>
            <?php } else { ?>
                <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico"
                      type="image/x-icon"/>
                      <?php
                  }
              }
              if ($smof_data['gf_body'])
                  $gfont[urlencode($smof_data['gf_body'])] = '' . urlencode($smof_data['gf_body']);
              if ($smof_data['gf_nav'] && $smof_data['gf_nav'] != '' && $smof_data['gf_nav'] != $smof_data['gf_body'])
                  $gfont[urlencode($smof_data['gf_nav'])] = '' . urlencode($smof_data['gf_nav']);
              if ($smof_data['f_headings'] && $smof_data['f_headings'] != '' && $smof_data['f_headings'] != $smof_data['gf_body'] && $smof_data['f_headings'] != $smof_data['gf_nav'])
                  $gfont[urlencode($smof_data['f_headings'])] = '' . urlencode($smof_data['f_headings']);
              if (isset($gfont) && $gfont) {
                  foreach ($gfont as $g_font) {
                      echo "<link href='http" . ((is_ssl()) ? 's' : '') . "://fonts.googleapis.com/css?family={$g_font}:" . $smof_data['gf_settings'] . "' rel='stylesheet' type='text/css' />";
                  }
              }
              if ($inwave_cfg['pageheading_bg']) {
                  echo '<style>.page-heading{background-image:url(\'' . esc_url($inwave_cfg['pageheading_bg']) . '\')!important;}</style>';
              }
              ?>
              <?php wp_head(); ?>
    </head>
    <body id="page-top" <?php body_class(); ?>>
        <div class="wrapper">
            <?php
            $viewinvoice = strpos($_SERVER['REQUEST_URI'], 'viewinvoice');
            if (!$viewinvoice) {
                include(get_template_directory() . '/headers/header-' . $inwave_cfg['header-option'] . '.php');
            } else {
                $inwave_cfg['show-pageheading'] = 0;
            }