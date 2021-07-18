<?php
/* 
* Plugin Name: Panel Community
* Author: Maxime Carluer, Prado Rasoanirahina, Julien Arbellini
* Version: 0.1
* Description: Plugin créé dans le cadre du projet de Panorama des CMS.
*/

//Include functions file
require_once plugin_dir_path(__FILE__).'includes/esgi-functions.php';

register_activation_hook(__FILE__, 'panelCommunity_activation');

function panelCommunity_activation() {
	global $wpdb;
}