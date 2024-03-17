<?php
/**
 * Aparat Feed Widget Class
 * 
 * @package Aparat_Feed_Widget
 */

declare(strict_types=1);

namespace AparatFeedWidget;

/**
 * Class Aparat_Feed_Widget
 */
final class Aparat_Feed_Widget extends \WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_backend_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_frontend_scripts' ) );
		$control_options = array();
		$widget_options  = array(
			'classname'                   => 'aparat-feed-widget',
			'description'                 => esc_html__( 'Display videos from an Aparat channels', 'aparat-feed' ),
			'customize_selective_refresh' => true,
		);

		parent::__construct(
			'aparat-feed-widget',
			esc_html__( 'Aparat Feed', 'aparat-feed' ),
			$widget_options,
			$control_options
		);
	}

	/**
	 * Include Shortcode Builder scripts and styles
	 *
	 * @param string $hook Hook Name.
	 * @return void
	 * @SuppressWarnings(PHPMD.Superglobals)
	 */
	public function load_backend_scripts( string $hook ) {
		// phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
		$pagenow = $GLOBALS['pagenow'];
		// phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
		$plugin_url     = APARAT_FEED()->get( 'plugin_url' );
		$plugin_version = APARAT_FEED()->get( 'plugin_version' );

		// Check if we are in widget pages in the dashboard
		if ( ! ( 'customize.php' === $pagenow || 'widgets.php' === $pagenow || 'widgets.php' === $hook ) ) {
			return;
		}

		// now load admin scripts
		if ( ! is_rtl() ) {
			wp_register_style(
				'aparat-feed-widget',
				$plugin_url . '/includes/AparatFeedWidget/assets/admin/css/style.css',
				array(),
				$plugin_version
			);
			wp_enqueue_style( 'aparat-feed-widget' );
		}

		if ( is_rtl() ) {
			wp_register_style(
				'aparat-feed-widget-rtl',
				$plugin_url . '/includes/AparatFeedWidget/assets/admin/css/style-rtl.css',
				array(),
				$plugin_version
			);
			wp_enqueue_style( 'aparat-feed-widget-rtl' );
		}

		wp_register_script(
			'aparat-feed-widget',
			$plugin_url . '/includes/AparatFeedWidget/assets/admin/js/script.js',
			array( 'jquery' ),
			$plugin_version,
			true
		);
		wp_enqueue_script( 'aparat-feed-widget' );
	}

	/**
	 * The function "load_frontend_scripts" checks if a specific widget is active and enqueues the
	 * corresponding CSS file based on the website's text direction.
	 * 
	 * @return void
	 */
	public function load_frontend_scripts() {
		$plugin_url     = APARAT_FEED()->get( 'plugin_url' );
		$plugin_version = APARAT_FEED()->get( 'plugin_version' );
		// var_dump(wp_get_sidebars_widgets());

		if ( ! is_active_widget( false, false, 'aparat-feed-widget' ) ) {
			return;
		}

		if ( ! is_rtl() ) {
			wp_register_style(
				'aparat-feed-widget',
				$plugin_url . '/includes/AparatFeedWidget/assets/public/css/style.css',
				array(),
				$plugin_version
			);
			wp_enqueue_style( 'aparat-feed-widget' );
		}

		if ( ! is_rtl() ) {
			return;
		}

		wp_register_style(
			'aparat-feed-widget-rtl',
			$plugin_url . '/includes/AparatFeedWidget/assets/public/css/style-rtl.css',
			array(),
			$plugin_version
		);
		wp_enqueue_style( 'aparat-feed-widget-rtl' );
	}

	// phpcs:ignore MySource.Commenting.FunctionComment.TypeHintMissing
	/**
	 * Back-end widget form.
	 *
	 * @param array<string> $instance Previously saved values from database.
	 * @return string
	 * @see    WP_Widget::form()
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		// Note : You must use get_field_name() and get_field_id() function to generate form element name and id.
		// Set database values or default values
		$title           = $instance['title'] ?? '';
		$display_mode    = $instance['display-mode'] ?? 'horizontal';
		$posts_number    = $instance['posts-number'] ?? '4';
		$channel_address = $instance['channel-address'] ?? 'ahangdownload';
		$cache_time      = $instance['cache-time'] ?? '21600';
		?>
		<div class="ddaf-widget-form">
			<div class="ddaf-section">
				<div class="ddaf-section-top" data-fieldset="general">
					<div class="ddaf-top-action">
						<a class="ddaf-action-indicator hide-if-no-js" data-fieldset="general" href="#"></a>
					</div>
					<div class="ddaf-section-title">
						<h4 class="ddaf-section-heading" data-fieldset="general"><?php esc_html_e( 'General Settings', 'aparat-feed' ); ?></h4>
					</div>
				</div>
				<fieldset data-fieldset-id="general" class="ddaf-settings ddaf-fieldset settings-general">
					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'aparat-feed' ); ?></label>
						<input class="title-field" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" type="text"/>
					</p>
				</fieldset>
			</div>
			<div class="ddaf-section">
				<div class="ddaf-section-top" data-fieldset="display-options">
					<div class="ddaf-top-action">
						<a class="ddaf-action-indicator hide-if-no-js" data-fieldset="display-options" href="#"></a>
					</div>
					<div class="ddaf-section-title">
						<h4 class="ddaf-section-heading"
							data-fieldset="display-options">
							<?php esc_html_e( 'Display Options', 'aparat-feed' ); ?>
						</h4>
					</div>
				</div>
				<fieldset data-fieldset-id="general" class="ddaf-settings ddaf-fieldset settings-channel-name">
					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'channel-address' ) ); ?>">
						<?php esc_html_e( 'Channel Address:', 'aparat-feed' ); ?>
						</label>
						<input dir="auto" class="channel-address-field" type="text" id="<?php echo esc_attr( $this->get_field_id( 'channel-address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'channel-address' ) ); ?>" value="<?php echo esc_attr( $channel_address ); ?>" />
					</p>
				</fieldset>
				<fieldset data-fieldset-id="display-options" class="ddaf-settings ddaf-fieldset settings-display-options">
					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'display-mode' ) ); ?>"><?php esc_html_e( 'Display Mode:', 'aparat-feed' ); ?></label>
						<select dir="auto" class="ddaf-display-mode" id="<?php echo esc_attr( $this->get_field_id( 'display-mode' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display-mode' ) ); ?>">
							<option dir="auto" <?php selected( $display_mode, 'horizontal' ); ?> value="horizontal"><?php esc_html_e( 'Horizontal', 'aparat-feed' ); ?></option>
							<option dir="auto" <?php selected( $display_mode, 'horizontal-big' ); ?> value="horizontal-big"><?php esc_html_e( 'Horizontal Big', 'aparat-feed' ); ?></option>
							<option dir="auto" <?php selected( $display_mode, 'horizontal-bigger' ); ?> value="horizontal-bigger"><?php esc_html_e( 'Horizontal Bigger', 'aparat-feed' ); ?></option>
							<option dir="auto" <?php selected( $display_mode, 'vertical' ); ?> value="vertical"><?php esc_html_e( 'Vertical', 'aparat-feed' ); ?></option>
							<option dir="auto" <?php selected( $display_mode, 'list' ); ?> value="list"><?php esc_html_e( 'List', 'aparat-feed' ); ?></option>
						</select>
					</p>
					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'posts-number' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'aparat-feed' ); ?></label>
						<select dir="auto" class="ddaf-posts-number" id="<?php echo esc_attr( $this->get_field_id( 'posts-number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts-number' ) ); ?>">
		<?php
		for ( $i = 1; $i <= 15; $i++ ) {
			?>
			<option dir="auto" value="<?php echo intval( $i ); ?>" <?php selected( $posts_number, $i ); ?>><?php echo intval( $i ); ?></option>
			<?php
		}
		?>
						</select>
					</p>
					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'cache-time' ) ); ?>"><?php esc_html_e( 'Cache Time in seconds (Default 6 Hours):', 'aparat-feed' ); ?></label>
						<input dir="auto" class="cache-time-field" id="<?php echo esc_attr( $this->get_field_id( 'cache-time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cache-time' ) ); ?>" value="<?php echo esc_attr( $cache_time ); ?>" type="text"/>
					</p>
				</fieldset>
			</div>
		</div>
		<?php

		return 'noform';
	}

	// phpcs:ignore MySource.Commenting.FunctionComment.TypeHintMissing
	/**
	 * Processing widget options on save & Sanitize widget form values as they are saved.
	 *
	 * @param array<string> $new_instance Values just sent to be saved.
	 * @param array<string> $old_instance Previously saved values from database.
	 * @return array<string>
	 * @see    WP_Widget::update()
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = wp_strip_all_tags( $new_instance['title'] );

		$modes_array              = array(
			'horizontal',
			'horizontal-big',
			'horizontal-bigger',
			'list',
			'vertical',
		);
		$instance['display-mode'] = 'horizontal';
		if ( in_array( $new_instance['display-mode'], $modes_array, true ) ) {
			$instance['display-mode'] = $new_instance['display-mode'];
		}

		$instance['posts-number'] = '4';
		if ( $new_instance['posts-number'] > 0 && $new_instance['posts-number'] < 16 ) {
			$instance['posts-number'] = strval( absint( $new_instance['posts-number'] ) );
		}

		$instance['channel-address'] = wp_strip_all_tags( $new_instance['channel-address'] );
		$instance['cache-time']      = strval( intval( $new_instance['cache-time'] ) );
		delete_transient( strval( $this->id ) );
		wp_cache_delete( 'Aparat_Feed_Widget', 'widget' );
		delete_option( 'aparat_feed_widget' );

		return $instance;
	}

	/**
	 * The function "print_title" is used to display the title of a widget, with a default value of
	 * "Aparat Feed".
	 * 
	 * @param array<string> $args     Is an array that contains various arguments for the widget title.
	 * @param array<string> $instance The "instance" parameter is an array that contains the settings and data for the widget instance.
	 * @return void
	 */
	public function print_title( array $args, array $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Aparat Feed', 'aparat-feed' );
		}

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( ! isset( $title ) ) {
			return;
		}

		echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
	}

	// phpcs:ignore MySource.Commenting.FunctionComment.TypeHintMissing
	/**
	 * Front-end display of widget.
	 *
	 * @param array<string> $args     Widget arguments.
	 * @param array<string> $instance Saved values from database.
	 * @see WP_Widget::widget()
	 * @return void
	 * @SuppressWarnings(PHPMD.ElseExpression)
	 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
	 */
	public function widget( $args, $instance ) {
		$this->print_title( $args, $instance );
		echo wp_kses_post( $args['before_widget'] );
		$resp_object = $this->get_response( $instance );

		// Check for success
		if (
			isset( $resp_object ) &&
			is_object( $resp_object ) &&
			property_exists( $resp_object, 'videobyuser' ) &&
			is_array( $resp_object->videobyuser )
		) {
			?>
			<div style="width: 100%; display: inline-block;">
			<?php

			$modes_array  = array(
				'horizontal',
				'horizontal-big',
				'horizontal-bigger',
				'list',
				'vertical',
			);
			$display_mode = 'horizontal';
			if ( isset( $instance['display-mode'] ) && in_array( $instance['display-mode'], $modes_array, true ) ) {
				$display_mode = $instance['display-mode'];
			}

			// phpcs:ignore SlevomatCodingStandard.Variables.UnusedVariable.UnusedVariable
			foreach ( $resp_object->videobyuser as $videokey => $videoobject ) {
				require APARAT_FEED()->get( 'plugin_folder' ) . 'includes/AparatFeedWidget/display-modes/' . $display_mode . '.php';
			}

			?>
			</div>
			<?php
		} else {
			esc_html_e( 'no response from the Aparat server or invalid type occurred', 'aparat-feed' );
		}//end if

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Get response of Aparat
	 *
	 * @param array<string> $instance Saved values from database.
	 * @return mixed
	 * @SuppressWarnings(PHPMD.Superglobals)
	 */
	private function get_response( array $instance ) {

		$body = get_transient( strval( $this->id ) );
		if ( is_string( $body ) ) {
			return json_decode( $body );
		}

		$posts_number = '4';
		if ( $instance['posts-number'] > 0 && $instance['posts-number'] < 16 ) {
			$posts_number = absint( $instance['posts-number'] );
		}

		$channel_address = 'ahangdownload';
		if ( isset( $instance['channel-address'] ) ) {
			$channel_address = wp_strip_all_tags( $instance['channel-address'] );
		}

		$endpoint = 'https://www.aparat.com/etc/api/videoByUser/username/' . $channel_address . '/perpage/' . $posts_number;
		$response = wp_remote_request( $endpoint );
		$body     = wp_remote_retrieve_body( $response );

		if ( is_wp_error( $response ) || ! is_array( $response ) ) {
			return false;
		}

		if ( in_array( $response['response']['code'], array( 200, 201 ), true ) ) {
			$cache_time = 21600;
			if ( isset( $instance['cache-time'] ) ) {
				$cache_time = intval( $instance['cache-time'] );
			}
			set_transient( strval( $this->id ), $body, $cache_time );

			return json_decode( $body );
		}

		return false;
	}
}
