<?php
if (have_posts()) : while (have_posts()) : the_post();

        $themes_dir = get_template_directory();
        $bt_options = get_option('iw_portfolio_settings');
        $theme = 'default';
        if ($bt_options['theme']) {
            $theme = $bt_options['theme'];
        }
        $btport_theme = $themes_dir . '/iw_portfolio/' . $theme;
        $theme_path = '';
        if (file_exists($btport_theme) && is_dir($btport_theme)) {
            $theme_path = $btport_theme;
        } else {
            $theme_path = WP_PLUGIN_DIR . '/iw_portfolio/themes/' . $theme;
        }
        $portfolios_theme = $theme_path . '/portfolio.php';
        if (file_exists($portfolios_theme)) {
            require_once $portfolios_theme;
        } else {
            echo __("No theme was found", "inwavethemes");
        }
    endwhile;
        endif;

