<?php

class socialMediaButtonWidget extends WP_Widget
{

	// Register widget with WordPress.
	public function __construct() {
		parent::__construct( 'socialMediaButtonWidget', // Base ID
			'Social Media Buttons', // Name
			array( 'description' => 'Displays social media icons for the networks set under Theme Options &gt; Branding.' ) // Args
		);
	}

	// Front-end display of widget.
	public function widget( $widget, $instance ) {
		extract( $widget );

		$title = !empty( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$text = !empty( $instance['text'] ) ? wpautop( $instance['text'] ) : '';

		echo $widget['before_widget'];

		if ( $title ) {
			echo $widget['before_title'], esc_html( $title ), $widget['after_title'];
		}

		if ( $text ) {
			echo '<div class="text-widget-content widgettext">', wpautop( $text ), '</div>';
		}

		// SOCIAL MEDIA
		// developer: edit the $socialsites array below and/or the Social Media ACF field group to prevent the client adding sites that haven't been styled
		// this code also appears in includes/widgets/socialMediaButtons.php
		$socialsites = array(
			"facebook"    => 'Facebook',
			"twitter"     => 'Twitter',
			"tumblr"      => 'Tumblr',
			"linkedin"    => 'LinkedIn',
			"youtube"     => 'YouTube',
			"googleplus" => 'Google+',
			"pinterest"   => 'Pinterest',
			"instagram"   => 'Instagram',
		);
		$socialoutput = '';
		$svg = file_get_contents( get_template_directory() . '/includes/images/social_icons.svg' );

		foreach ( $socialsites as $site => $sitename ) {
			if ( $url = get_field( $site . '_url', 'options' ) ) {
				$socialoutput .= '<li class="social-' . $site . '"><a href="' . $url . '" target="_blank" rel="external"><span class="screen-reader-text">' . $sitename . '</span>' . $svg . '</a></li>';
			}
		}
		if ( $socialoutput ) {
			echo '<ul class="nav-menu nav-social social-links">', $socialoutput, '</ul>';
		}

		echo $widget['after_widget'];

	}

	// Sanitize widget form values as they are saved.
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = $new_instance['text'];
		return $instance;
	}


	public function form( $instance ) {
		// Retrieve all of our fields from the $instance variable
		$fields = array(
			'title',
			'text'
		);

		// Format each field into ID/Name/Value array
		foreach ( $fields as $name ) {
			$fields[$name] = array(
				'id'    => $this->get_field_id( $name ),
				'name'  => $this->get_field_name( $name ),
				'value' => null,
			);

			if ( isset( $instance[$name] ) ) {
				$fields[$name]['value'] = $instance[$name];
			}
		}

		// Display the widget in admin dashboard:
		?>

		<p>
			<label for="<?php echo esc_attr( $fields['title']['id'] ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" type="text"
			       id="<?php echo esc_attr( $fields['title']['id'] ); ?>"
			       name="<?php echo esc_attr( $fields['title']['name'] ); ?>"
			       value="<?php echo esc_attr( $fields['title']['value'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $fields['text']['id'] ); ?>"><?php _e( 'Text:' ); ?></label>
			<textarea class="widefat"
			          id="<?php echo esc_attr( $fields['text']['id'] ); ?>"
			          name="<?php echo esc_attr( $fields['text']['name'] ); ?>"
			          rows="5" cols="80"><?php echo esc_textarea( $fields['text']['value'] ); ?></textarea>
		</p>

		<?php
	}

} // class socialMediaButtonWidget

function socialMediaButtonWidget_register_widget() {
	register_widget( 'socialMediaButtonWidget' );
}

add_action( 'widgets_init', 'socialMediaButtonWidget_register_widget' );