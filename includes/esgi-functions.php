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
		global $wpdb;
		//Get the title, and if buttons are visible or not
		$title = apply_filters('widget_title', $instance['title']);
		$twitch_widget = apply_filters('twitch_widget', $instance['twitch_widget']);
		$youtube_widget = apply_filters('youtube_widget', $instance['youtube_widget']);
		$dailymotion_widget = apply_filters('dailymotion_widget', $instance['dailymotion_widget']);
		echo $args['before_widget'];

		//if title is present
		if (!empty($title))
			echo $args['before_title']
				. $title
				. $args['after_title'];
		//output

		if ($twitch_widget === 'on') {
			$twitchAccount = json_decode(json_encode(
				$wpdb->get_results(
					$wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='twitch_account'")
				)
			), true)[0]['valueKey'] ?? '';

			if (!empty($twitchAccount)) {
				echo '<a href="https://www.twitch.tv/' . $twitchAccount . '" target="_blank">
					<button style="background-color: blueviolet;">
						Twitch
					</button>
				</a>';
			}
		}

		if ($youtube_widget === 'on') {
			$youtubeAccount = json_decode(json_encode(
				$wpdb->get_results(
					$wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='youtube_account'")
				)
			), true)[0]['valueKey'] ?? '';
			if (!empty($youtubeAccount)) {
				echo '<a href="https://www.youtube.com/c/' . $youtubeAccount . '" target="_blank">
					<button style="background-color: red;">
						Youtube
					</button>
				</a>';
			}
		}


		if ($dailymotion_widget === 'on') {
			$dailymotionAccount = json_decode(json_encode(
				$wpdb->get_results(
					$wpdb->prepare("SELECT valueKey FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey='dailymotion_account'")
				)
			), true)[0]['valueKey'] ?? '';
			if (!empty($dailymotionAccount)) {
				echo '<a href="https://www.dailymotion.com/' . $dailymotionAccount . '" target="_blank">
					<button>
						Dailymotion
					</button>
				</a>';
			}
		}

		echo $args['after_widget'];
	}

	public function form($instance)
	{
		if (isset($instance['title'])) {

			$title = $instance['title'];
			$twitch_widget = $instance['twitch_widget'];
			$youtube_widget = $instance['youtube_widget'];
			$dailymotion_widget = $instance['dailymotion_widget'];
		} else {
			$title = __('Panel Community', 'panelCommunityWidget_domain');
			$twitch_widget = __('Panel Community', 'panelCommunityWidget_domain');
			$youtube_widget = __('Panel Community', 'panelCommunityWidget_domain');
			$dailymotion_widget = __('Panel Community', 'panelCommunityWidget_domain');
		}
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('twitch_widget'); ?>" name="<?php echo $this->get_field_name('twitch_widget'); ?>" type="checkbox" <?php echo esc_attr($twitch_widget) === 'on' ? 'checked' : ''; ?> />
			<label for="<?php echo $this->get_field_id('twitch_widget'); ?>">Twitch</label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('youtube_widget'); ?>" name="<?php echo $this->get_field_name('youtube_widget'); ?>" type="checkbox" <?php echo esc_attr($youtube_widget) === 'on' ? 'checked' : ''; ?> />
			<label for="<?php echo $this->get_field_id('youtube_widget'); ?>">Youtube</label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('dailymotion_widget'); ?>" name="<?php echo $this->get_field_name('dailymotion_widget'); ?>" type="checkbox" <?php echo esc_attr($dailymotion_widget) === 'on' ? 'checked' : ''; ?> />
			<label for="<?php echo $this->get_field_id('dailymotion_widget'); ?>">Dailymotion</label>
		</p>
<?php
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['twitch_widget'] = (!empty($new_instance['twitch_widget'])) ? strip_tags($new_instance['twitch_widget']) : '';
		$instance['youtube_widget'] = (!empty($new_instance['youtube_widget'])) ? strip_tags($new_instance['youtube_widget']) : '';
		$instance['dailymotion_widget'] = (!empty($new_instance['dailymotion_widget'])) ? strip_tags($new_instance['dailymotion_widget']) : '';
		return $instance;
	}
}

//SHORTCODES ===================================================================================
add_shortcode('fullPanel', 'panelCommunity_fullPannelShortcode');
add_shortcode('panelTwitch', 'panelCommunity_panelTwitchShortcode');
add_shortcode('panelYoutube', 'panelCommunity_panelYoutubeShortcode');
add_shortcode('panelDailymotion', 'panelCommunity_panelDailymotionShortcode');

function panelCommunity_fullPannelShortcode()
{
	return "<div>
		" . panelCommunity_panelTwitchShortcode() . "
		" . panelCommunity_panelYoutubeShortcode() . "
		" . panelCommunity_panelDailymotionShortcode() . "
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
	</section>';

	$twitchFields = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT * FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey LIKE 'twitch%'"), ARRAY_A);
	$settings = [];
	foreach ($twitchFields as $row) {
		$settings[$row['nameKey']] = $row['valueKey'];
	}

	if (empty($settings['twitch_account']) || !$settings['twitch_activated']) {
		return '';
	}

	$twitchProvider = new Twitch($settings['twitch_account'], [
		'twitch_allow_fullscreen' => $settings['twitch_allow_fullscreen'],
		'twitch_autoplay' => $settings['twitch_autoplay'],
	]);

	$content = '<div style="display: flex;">'
		. $twitchProvider->getCurrentLive()
		. ($settings['twitch_chat_visible']
			? $twitchProvider->getCurrentChat()
			: '')
		. '</div>';

	return str_replace(
		['%content%'],
		[$content],
		$template
	);
}

function panelCommunity_panelYoutubeShortcode()
{
	require __DIR__ . '/../src/providers/Youtube.php';

	global $wpdb;

	$template = '<section>
		<div style="display: flex; justify-content: space-between; align-items: center">
		<h3>Youtube</h3>
		%button%
		</div>
		<div class="youtube-frames" style="width:100%; display: flex; flex-wrap: wrap; justify-content: space-evenly; align-items: center">
		%content%
		</div>
	</section>';


	$youtubeFields = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT * FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey LIKE 'youtube%'"), ARRAY_A);
	$settings = [];
	foreach ($youtubeFields as $row) {
		$settings[$row['nameKey']] = $row['valueKey'];
	}

	if (empty($settings['youtube_account_id']) || $settings['youtube_activated'] !== '1') {
		return '';
	}

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

	if (empty($videos)) {
		return "<section><h4> Aucune vidéo trouvée pour le compte {$settings['youtube_account']}</h4</section>";
	}

	$content = '';
	foreach ($videos as $video) {
		$content .=
			'<div class="youtube-frame" style="box-sizing: border-box; padding: 1em .5em;">
				<iframe width="280" height="170" src="https://www.youtube.com/embed/' . $video['id'] . '"></iframe>
				<div class="youtube-stats">' .
			($settings['youtube_views_visible'] === '1' ? '<div class="youtube-stat">' . $video['views'] . ' vues</div>' : '') .
			'<div style="font-size: medium;">' .
			($settings['youtube_likes_visible'] === '1' ? '<div class="youtube-stat">' . $video['likes'] . ' likes</div>' : '') .
			($settings['youtube_dislikes_visible'] === '1' ? '<div class="youtube-stat">' . $video['dislikes'] . ' dislikes</div>' : '') .
			'</div>' .
			'</div>
			</div>' . PHP_EOL;
	}

	$button = $settings['youtube_button_visible'] === '1'
		? '<script src="https://apis.google.com/js/platform.js"></script>
		<div class="g-ytsubscribe" data-channelid="' . $settings['youtube_account_id'] . '" data-layout="full" data-count="default"></div>'
		: '';

	return str_replace(
		['%content%', '%button%'],
		[$content, $button],
		$template
	);
}

function panelCommunity_panelDailymotionShortcode()
{
	require __DIR__ . '/../src/providers/Dailymotion.php';
	global $wpdb;

	$template = '<section>
		<div style="display: flex; justify-content: space-between; align-items: center">
			<h3>Dailymotion</h3>
			%button%
		</div>
		<div class="dailymotion-frames">
		%content%
		</div>
	</section>';

	$dailymotionFields = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT DISTINCT * FROM {$wpdb->prefix}panelCommunity_table WHERE nameKey LIKE 'dailymotion%'"
		),
		ARRAY_A
	);
	$settings = [];
	foreach ($dailymotionFields as $row) {
		$settings[$row['nameKey']] = $row['valueKey'];
	}

	if (empty($settings['dailymotion_account']) || !$settings['dailymotion_activated']) {
		return '';
	}

	$dailymotion = new Dailymotion($settings['dailymotion_account']);

	$content = $dailymotion->getContent(
		[
			'nb_videos' => $settings['dailymotion_nb_videos'],
			'title_visible' => $settings['dailymotion_title_visible'],
		]
	);

	$button = '';
	if ($settings['dailymotion_button_visible']) {
		$button = '<a href="https://www.dailymotion.com/' . $settings['dailymotion_account'] . '" target="_blank">
			<button>' . ucfirst($settings['dailymotion_account']) . '</button>
		</a>';
	}

	return str_replace(
		['%content%', '%button%'],
		[$content, $button],
		$template
	);
}
