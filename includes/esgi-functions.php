<?php
//Add style
add_action('admin_init','panelCommunity_addStyle');
function panelCommunity_addStyle() {
	wp_register_style('panelCommunityStyle', plugins_url('/css/style.css', __FILE__));
	wp_enqueue_style('panelCommunityStyle');
}

add_action('admin_menu', 'panelCommunity_addAdminLink');

function panelCommunity_addAdminLink() {
	add_menu_page(
		'Panel Community Page',
		'Panel Community',
		'manage_options',
		'esgi-wordpress-plugin/includes/esgi-acp.php'
	);
}