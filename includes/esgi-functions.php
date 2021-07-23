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

//WIDGETS ======================================================================================
add_action('widgets_init', 'panelCommunity_widget');

function panelCommunity_widget() {
	register_widget('panelCommunityWidget');
}
	
	
class panelCommunityWidget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
		// widget ID
		'hstngr_widget',
		// widget name
		__('Panel Community Widget', 'panelCommunityWidget_domain'),
		// widget description
		array( 'description' => __('Panel Community', 'panelCommunityWidget_domain' ), )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters('widget_title', $instance['title']);
		echo $args['before_widget'];

		//if title is present
		if ( ! empty( $title ) )
			echo $args['before_title'] 
				. $title 
				. $args['after_title'];
		//output
		echo __('Panel Community', 'panelCommunityWidget_domain');

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if (isset( $instance['title']))
			$title = $instance[ 'title' ];
		else
			$title = __('Panel Community', 'panelCommunityWidget_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

//SHORTCODES ===================================================================================
add_shortcode('fullPanel', 'panelCommunity_fullPannelShortcode');
add_shortcode('panelTwitch', 'panelCommunity_panelTwitchShortcode');
add_shortcode('panelYoutube', 'panelCommunity_panelYoutubeShortcode');
add_shortcode('panelInstagram', 'panelCommunity_panelInstagramShortcode');

function panelCommunity_fullPannelShortcode() {
	return "<div>
		" . panelCommunity_panelTwitchShortcode() . "
		" . panelCommunity_panelYoutubeShortcode() . "
		" . panelCommunity_panelInstagramShortcode() . "
	</div>";
}

function panelCommunity_panelTwitchShortcode() {
	$twitchAccount = 'monstercat';

	return "<section>
		<h1>Twitch</h1>
		<div id='twitch-embed'></div>

		<script src='https://embed.twitch.tv/embed/v1.js'></script>
		<script type='text/javascript'>
			new Twitch.Embed('twitch-embed', {
				width: '100%',
				height: 480,
				channel: '" . $twitchAccount . "',
				allowfullscreen: true
			});
		</script>
	</section>";
}

function panelCommunity_panelYoutubeShortcode() {
	return "<section>
		<h1>Youtube</h1>
	</section>";
}

function panelCommunity_panelInstagramShortcode() {
	$html = "<section>
		<h1>Instagram</h1>";

	$html .= "</section>";

	return $html;
}