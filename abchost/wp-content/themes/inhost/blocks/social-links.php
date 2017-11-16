<?php
/**
 * The template part for displaying social links
 * @package inhost
 */

?>
<ul class="social-links">
    <?php if (isset($smof_data['social-links-all']) || $smof_data['facebook_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['facebook_link']); ?>" class="ttip" target="_blank" 
               title="Facebook"><i class="fa fa-facebook"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['twitter_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['twitter_link']); ?>" class="ttip" target="_blank" 
               title="Twitter"><i class="fa fa-twitter"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['linkedin_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['linkedin_link']); ?>" class="ttip" target="_blank" 
               title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['rss_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['rss_link']); ?>" class="ttip" target="_blank" 
               title="RSS"><i class="fa fa-rss"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['dribbble_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['dribbble_link']); ?>" class="ttip" target="_blank" 
               title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['youtube_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['youtube_link']); ?>" class="ttip" target="_blank" 
               title="Youtube"><i class="fa fa-youtube"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['pinterest_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['pinterest_link']); ?>" class="ttip" target="_blank" 
               title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['flickr_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['flickr_link']); ?>" class="ttip" target="_blank" 
               title="Flickr"><i class="fa fa-flickr"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['vimeo_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['vimeo_link']); ?>" class="ttip" target="_blank" 
               title="Vimeo"><i class="fa fa-vimeo-square"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['tumblr_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['tumblr_link']); ?>" class="ttip" target="_blank" 
               title="Tumblr"><i class="fa fa-tumblr"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['google_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['google_link']); ?>" class="ttip" target="_blank" 
               title="Google+"><i class="fa fa-google-plus"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['weibo_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['weibo_link']); ?>" class="ttip" target="_blank" 
               title="Weibo"><i class="fa fa-weibo"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['dropbox_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['dropbox_link']); ?>" class="ttip" target="_blank" 
               title="Dropbox"><i class="fa fa-dropbox"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['skype_link']): ?>
        <li><a href="skype:<?php echo esc_attr($smof_data['skype_link']); ?>" class="ttip" target="_blank" 
               title="Skype"><i class="fa fa-skype"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['instagram_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['instagram_link']); ?>" class="ttip" target="_blank" 
               title="Instagram"><i class="fa fa-instagram"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['email_link']): ?>
               <li><a href="mailto:<?php echo esc_attr($smof_data['email_link']); ?>" class="ttip" target="_blank" 
               title="Email"><i class="fa fa-envelope"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['github_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['github_link']); ?>" class="ttip" target="_blank" 
               title="Github"><i class="fa fa-github"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['appstore_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['appstore_link']); ?>" class="ttip" target="_blank" 
               title="Appstore"><i class="fa fa-apple"></i></a></li>
    <?php endif; ?>
    <?php if (isset($smof_data['social-links-all']) || $smof_data['android_link']): ?>
        <li><a href="<?php echo esc_url($smof_data['android_link']); ?>" class="ttip" target="_blank" 
               title="Playstore"><i class="fa fa-android"></i></a></li>
    <?php endif; ?>
</ul>

