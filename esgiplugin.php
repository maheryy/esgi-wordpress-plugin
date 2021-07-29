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

// Plugin activation
function panelCommunity_activation() {
	global $wpdb;
	//Create table
	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}panelCommunity_table (
		id INT AUTO_INCREMENT PRIMARY KEY, 
		nameKey VARCHAR(255) NOT NULL,
		valueKey VARCHAR(255)
		);");

	$keys = [
		//Twitch
		'twitch_account' => '',
		'twitch_chat_visible' => '1',  
		'twitch_allow_fullscreen' => '1',
		'twitch_autoplay' => '1',
		'twitch_muted' => '0',
		'twitch_activated' => '1',
		//Youtube
		'youtube_account' => '',
		'youtube_account_id' => '',
		'youtube_button_visible' => '1',
		'youtube_views_visible' => '1',
		'youtube_likes_visible' => '1',
		'youtube_dislikes_visible' => '1',
		'youtube_type_videos' => 'last',
		'youtube_nb_videos' => '2',
		'youtube_activated' => '1',
		//Dailymotion
		'dailymotion_account' => '',
		'dailymotion_title_visible' => '1',
		'dailymotion_button_visible' => '1',
		'dailymotion_nb_videos' => '2',
		'dailymotion_activated' => '1',
	];

	foreach ($keys as $key => $value) {
		$wpdb->insert(
			$wpdb->prefix . 'panelCommunity_table', 
			[
				'nameKey' => $key,
				'valueKey' => $value
			], 
			[
				'%s',
				'%s'
			]
		);
	}
}

register_deactivation_hook(__FILE__, 'panelCommunity_deactivation');

// Plugin desactivation
function panelCommunity_deactivation() {
	global $wpdb;
	//Delete table if user wants
	?>
	<script type="text/javascript">
		var message = "Vous venez de désactiver le plugin Panel Community.\n\nVoulez vous supprimer la table contenant les données liées au plugin ?";
		
		var confirmation = confirm(message);
		if (confirmation){
			<?php $wpdb->query("DROP TABLE {$wpdb->prefix}panelCommunity_table ;");?>
		}
	</script>
	<?php
}