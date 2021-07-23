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
	//Create table
	$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}panelCommunity_table (
		id INT AUTO_INCREMENT PRIMARY KEY, 
		nameKey VARCHAR(255) NOT NULL,
		valueKey VARCHAR(255)
		);");

	$keys = [
		//Twitch
		'twitch_account' => '', 
		'twitch_button_visible' => 'true',  
		'twitch_tchat_visible' => 'true',  
		'twitch_activated' => 'true',
		//Youtube
		'youtube_account' => '',
		'youtube_button_visible' => 'true',
		'youtube_views_visible' => 'true',
		'youtube_likes_visible' => 'true',
		'youtube_dislikes_visible' => 'true',
		'youtube_type_videos' => 'last',
		'youtube_nb_videos' => '3',
		'youtube_activated' => 'true',
		//Instagram
		'instagram_account' => '',
		'instagram_button_visible' => 'true',
		'instagram_description_visible' => 'true',
		'instagram_likes_visible' => 'true',
		'instagram_type_posts' => 'last',
		'instagram_nb_posts' => '3',
		'instagram_activated' => 'true',
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

function panelCommunity_deactivation() {
	global $wpdb;
	//Delete table if user wants
	?>
	<script type="text/javascript">
		var message = "Vous venez de désactiver le plugin Panel Community.\n\nVoulez vous supprimer la table contenant les données liées au plugin ?";
		
		var confirmation = confirm(message);
		if (confirmation){
			<?php $wpdb->query("DROP TABLE IF NOT EXISTS {$wpdb->prefix}panelCommunity_table ;");?>
		}
	</script>
	<?php
}