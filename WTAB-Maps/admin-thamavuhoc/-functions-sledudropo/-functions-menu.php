<?php
function slogamowre_create_menu() {
    add_menu_page('WTAB Map', 'Map', 'administrator', __FILE__, 'slogamowre_settings_page' , plugins_url('/images/icon.png', __FILE__) );

    add_submenu_page(__FILE__, 'Map form', 'Map form', 'administrator', 'Map form', 'slogamowre_pnl_form_settings_page');
    add_action( 'admin_init', 'register_pnl_form_slogamowre_settings' );
}