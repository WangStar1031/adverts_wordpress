<?php

/**
 * Class WP_Locale_Switch_Plugin_Widget
 */
class WP_Locale_Switch_Plugin_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'WP_Locale_Switch_Plugin_Widget',
			'description' => 'Widget for users to switch locale on the frontend',
		);
		parent::__construct( 'wp_locale_switch_plugin_widget', 'WP Locale Switch Plugin', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo self::get_selectbox();
		echo $args['after_widget'];
	}

	public static function get_selectbox() {
		$out     = '';
		$plugin  = WP_Locale_Switch_Plugin::get_instance();
		$options = $plugin->settings->get_locales_array();
		$saved   = $plugin::get_saved();
		if ( is_array( $options ) ) {
			$out .= '<select class="wlsp-language-switch language-switcher">';
			foreach ( $options as $index => $item ) {
				$selected = '';
				if ( $saved && $saved === $item ) {
					$selected = 'selected';
				}
				$out .= "<option value='$item' $selected>$item</option>>";
			}
			$out .= '</select>';
		} else {
			$out = 'No locales specified';
		}

		return $out;
	}


	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}