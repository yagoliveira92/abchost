<?php
/**
 * The template part for displaying breadcrumbs
 * @package inhost
 */
global $post;
if (!$smof_data['breadcrumb']) {
    return;
}
?>
<div class="breadcrumbs">
    <ul>
        <?php
        //if (!is_home()) {
        echo '<li class="home"><a href="';
        echo home_url();
        echo '">';
        echo __('Home','inwavethemes');
        echo "</a></li>";
        echo '<li><span>/</span></li>';
        if (is_category()) {

            // Category
            echo '<li class="category-1">';
            single_cat_title('');
            echo '</li>';
        } elseif (is_single()) {

            // Single post
            echo '<li  class="category-1">';
            if (get_the_category()) {
                the_category(' </li><li class="category-1"> ');
                echo '</li><li><span>/</span></li>';
                echo '<li class="category-2">';
            }
            the_title('');
            echo '</li>';
        } elseif (is_page()) {

            // Page
            if ($post->post_parent) {
                echo '<li class="category-1"><a href="' . get_permalink($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a></li>';
                echo '<li><span>/</span></li>';
            }
            echo '<li class="category-2">';
            echo the_title();
            echo '</li>';
        } elseif (is_tag()) {
            // Tag
            echo '<li class="category-2">';
            single_tag_title();
            echo '</li>';
        } elseif (is_day()) {
            // Archive
            echo "<li>".__('Archive for ','inwavethemes');
            the_time('F jS, Y');
            echo '</li>';
        } elseif (is_month()) {
            echo "<li>".__('Archive for ','inwavethemes');
            the_time('F, Y');
            echo '</li>';
        } elseif (is_year()) {
            echo "<li>".__('Archive for ','inwavethemes');
            the_time('Y');
            echo '</li>';
        } elseif (is_author()) {
            echo "<li>".__('Author Archive','inwavethemes');
            echo '</li>';
        } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
            echo "<li>".__('Blog Archives','inwavethemes');
            echo '</li>';
        } elseif (is_search()) {
            echo "<li>".__('Search Results','inwavethemes');
            echo '</li>';
        }
        ?>
    </ul>
</div>
