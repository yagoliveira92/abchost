<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package inhost
 */
global $inwave_cfg, $smof_data;
?>
</div> <!--end .content-wrapper -->
<?php
// default footer
$viewinvoice = strpos($_SERVER['REQUEST_URI'], 'viewinvoice');
if (!$viewinvoice):
    if (!$inwave_cfg['footer-option']):
        ?>
        <footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 footer-left">
                        <div class="footer-logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><img alt="logo" src="<?php echo esc_url($smof_data['footer-logo']); ?>"/>
                            </a>
                        </div>
                        <div class="footer-text">
                            <?php echo wp_kses_post($smof_data['footer-text']); ?>
                        </div>
                        <?php if (isset($smof_data['footer_social_links']) && $smof_data['footer_social_links']): ?>
                            <div class="footer-social-links">
                                <?php include(get_template_directory() . '/blocks/social-links.php'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($smof_data['footer_extra_links']) && $smof_data['footer_extra_links']): ?>
                            <div class="footer-extra-links">
                                <?php echo wp_kses_post($smof_data['footer_extra_links']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-9 footer-right">
                        <?php if (is_active_sidebar('sidebar-footer1')): ?>
                            <?php dynamic_sidebar('sidebar-footer1'); ?>
                        <?php else: ?>
                            <div class="col-md-12"><?php _e('This is the footer area. Please add more widgets in Appearance -> Widgets -> Sidebar Footer Default', 'inwavethemes'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </footer>

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <?php if ($smof_data['backtotop-button']): ?>
                            <div class="back-to-top"><a href="#top" title="Back to top" class="button-effect3"><i
                                        class="fa fa-angle-double-up"></i></a></div>
                            <?php endif; ?>
                    </div>
                    <div class="col-md-9 col-sm-9">
                        <?php echo wp_kses_post($smof_data['footer-copyright']) ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- .wrapper -->
        </div>
        <?php
    else:

        // one page footer
        ?>
        <footer class="page-footer onepage-footer">
            <div class="container">
                <div class="footer-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><img alt="logo" src="<?php echo esc_url($smof_data['footer-logo']); ?>"/></a>
                </div>
                <div class="footer-text">
                    <?php echo wp_kses_post($smof_data['footer-text']) ?>
                </div>
                <h3><?php echo __('CONNECT WITH US', 'inwavethemes') ?></h3>
                <?php
                $smof_data['social-links-all'] = true;
                include(get_template_directory() . '/blocks/social-links.php');
                ?>
            </div>
        </footer>
        <div class="copyright onepage-copyright">
            <div class="container">
                <?php echo wp_kses_post($smof_data['footer-copyright']) ?>
                <?php if ($smof_data['backtotop-button']): ?>
                    <div class="back-to-top"><a href="#top" title="Back to top" class="button-effect3"><i class="fa fa-arrow-up"></i></a></div>
                        <?php endif; ?>
            </div>
        </div>
        <!-- .wrapper -->
        </div>

    <?php endif; ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
