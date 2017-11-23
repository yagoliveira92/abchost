<!--Menu desktop-->
<?php
if(!has_nav_menu($inwave_cfg['theme-menu'])){
    return;
}
?>
<?php wp_nav_menu(array(
    //"container"         => "",
    'menu' => $inwave_cfg['theme-menu-id'],
    'theme_location'  => $inwave_cfg['theme-menu'],
   // "menu_class"         => "nav-menu",
   // "walker"            => new Inwave_Nav_Walker(),
)); ?>