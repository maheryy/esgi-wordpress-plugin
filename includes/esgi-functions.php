<?php
require_once __DIR__ . '/../src/helpers/helpers.php';
loadDotEnv(__DIR__ . '/../.env');

//Add style
add_action('admin_init', 'panelCommunity_addStyle');
function panelCommunity_addStyle()
{
	wp_register_style('panelCommunityStyle', plugins_url('/css/style.css', __FILE__));
	wp_enqueue_style('panelCommunityStyle');
}

add_action('admin_menu', 'panelCommunity_addAdminLink');

function panelCommunity_addAdminLink()
{
	add_menu_page(
		'Panel Community Page',
		'Panel Community',
		'manage_options',
		'esgi-wordpress-plugin/includes/esgi-acp.php'
	);
}

//WIDGETS ======================================================================================
add_action('widgets_init', 'panelCommunity_widget');

function panelCommunity_widget()
{
	register_widget('panelCommunityWidget');
}


class panelCommunityWidget extends WP_Widget
{

	function __construct()
	{
		parent::__construct(
			// widget ID
			'hstngr_widget',
			// widget name
			__('Panel Community Widget', 'panelCommunityWidget_domain'),
			// widget description
			array('description' => __('Panel Community', 'panelCommunityWidget_domain'),)
		);
	}

	public function widget($args, $instance)
	{
		$title = apply_filters('widget_title', $instance['title']);
		echo $args['before_widget'];

		//if title is present
		if (!empty($title))
			echo $args['before_title']
				. $title
				. $args['after_title'];
		//output
		echo __('Panel Community', 'panelCommunityWidget_domain');

		echo $args['after_widget'];
	}

	public function form($instance)
	{
		if (isset($instance['title']))
			$title = $instance['title'];
		else
			$title = __('Panel Community', 'panelCommunityWidget_domain');
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
<?php
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		return $instance;
	}
}

//SHORTCODES ===================================================================================
add_shortcode('fullPanel', 'panelCommunity_fullPannelShortcode');
add_shortcode('panelTwitch', 'panelCommunity_panelTwitchShortcode');
add_shortcode('panelYoutube', 'panelCommunity_panelYoutubeShortcode');
add_shortcode('panelInstagram', 'panelCommunity_panelInstagramShortcode');

function panelCommunity_fullPannelShortcode()
{
	return "<div>
		" . panelCommunity_panelTwitchShortcode() . "
		" . panelCommunity_panelYoutubeShortcode() . "
		" . panelCommunity_panelInstagramShortcode() . "
	</div>";
}

function panelCommunity_panelTwitchShortcode()
{
	require __DIR__ . '/../src/providers/Twitch.php';
	global $wpdb;

	$template = '<section>
		<h3>Twitch</h3>
		<div class="twitch-frames">
		%content%
		</div>
		%button%
	</section>';

	$twitchFields = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT * FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey LIKE 'twitch%'"), ARRAY_A);
	$settings = [];
	foreach ($twitchFields as $row) {
		$settings[$row['nameKey']] = $row['valueKey'];
	}

	if (empty($settings['twitch_account']) || !$settings['twitch_activated']) {
		return '';
	}

	$twitchProvider = new Twitch($settings['twitch_account'], $settings['twitch_allow_fullscreen']);

	var_dump($settings);

	$content = '<div style="display: flex;">'
		. $twitchProvider->getCurrentLive()
		. ($settings['twitch_chat_visible']
			? $twitchProvider->getCurrentChat()
			: ''
		)
	.'</div>';

	$button = $settings['twitch_button_visible']
		? '<button></button>'
		: '';

	return str_replace(
		['%content%', '%button%'],
		[$content, $button],
		$template
	);
}

function panelCommunity_panelYoutubeShortcode()
{
	require __DIR__ . '/../src/providers/Youtube.php';
	global $wpdb;

	$template = '<section>
		<h3>Youtube</h3>
		<div class="youtube-frames">
		%content%
		</div>
		%button%
	</section>';

	$youtubeFields = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT * FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey LIKE 'youtube%'"), ARRAY_A);
	$settings = [];
	foreach ($youtubeFields as $row) {
		$settings[$row['nameKey']] = $row['valueKey'];
	}

	if (empty($settings['youtube_account_id'])) {
		return '';
	}

	/* Code fonctionnel : pas abuser sur les call API */
	/*
	$youtube = new Youtube($settings['youtube_account_id']);
	$with_details = $settings['youtube_views_visible'] === '1' || $settings['youtube_likes_visible'] === '1' || $settings['youtube_dislikes_visible'] === '1';

	switch ($settings['youtube_type_videos']) {
		case 'last':
		 	$videos = $youtube->getLatestVideos((int)$settings['youtube_nb_videos'], $with_details);
	 		break;
	 	case 'moreViews':
			$videos = $youtube->getMostViewedVideos((int)$settings['youtube_nb_videos'], $with_details);
			break;
		case 'moreLikes':
			$videos = $youtube->getMostLikedVideos((int)$settings['youtube_nb_videos'], $with_details);
			break;
	}
	*/

	/* Vrai données pour les tests d'affichage */
	$videos = [
		['id' => 'rew3qfQV6jU', 'views' => '5956148', 'likes' => '123539', 'dislikes' => '4691', 'favorites' => '0', 'comments' => '3305'],
		['id' => 'Nh7M8GqswZ4', 'views' => '4202170', 'likes' => '85755', 'dislikes' => '3020', 'favorites' => '0', 'comments' => '2929'],
		['id' => 'ylpuGUWGdSs', 'views' => '3957517', 'likes' => '66193', 'dislikes' => '2160', 'favorites' => '0', 'comments' => '4116'],
		['id' => 'V79ArW07JQM', 'views' => '3655563', 'likes' => '96963', 'dislikes' => '2567', 'favorites' => '0', 'comments' => '1676'],
		['id' => '9lcxzZcAFTE', 'views' => '3541963', 'likes' => '142262', 'dislikes' => '2968', 'favorites' => '0', 'comments' => '3559']
	];

	if (empty($videos)) {
		return "<section><h4> Aucune vidéo trouvée pour le compte {$settings['youtube_account']}</h4</section>";
	}

	$content = '';
	foreach ($videos as $video) {
		$content .=
			'<div class="youtube-frame">
				<iframe width="420" height="300" src="https://www.youtube.com/embed/' . $video['id'] . '"></iframe>
				<div class="youtube-stats">' .
			($settings['youtube_views_visible'] === '1' ? '<div class="youtube-stat">' . $video['views'] . ' vues</div>' : '') .
			($settings['youtube_likes_visible'] === '1' ? '<div class="youtube-stat">' . $video['likes'] . ' likes</div>' : '') .
			($settings['youtube_dislikes_visible'] === '1' ? '<div class="youtube-stat">' . $video['dislikes'] . ' dislikes</div>' : '') .
			'</div>
			</div>' . PHP_EOL;
	}
	$button = $settings['youtube_button_visible'] === '1'
		? '<script src="https://apis.google.com/js/platform.js"></script>
		<div class="g-ytsubscribe" data-channel="LeFatShow" data-layout="default" data-count="default"></div>'
		: '';

	return str_replace(
		['%content%', '%button%'],
		[$content, $button],
		$template
	);
}

function panelCommunity_panelInstagramShortcode()
{
	$html = "<section>
		<h1>Instagram</h1>";

	$html .= "</section>";

	return $html;
}
