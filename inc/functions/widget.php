<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * widget
 */
if ( ! class_exists( 'CTSettingsWidget') ) :
class CTSettingsWidget extends WP_Widget {

	function CTSettingsWidget() {
		// Instantiate the parent object
		parent::__construct( false, 'CityTours Currency&Language Widget' );
	}

	function widget( $args, $instance ) {
		// add custom class contact box
		extract( $args );
		if ( strpos( $before_widget, 'class' ) === false ) {
			$before_widget = str_replace( '>', 'class="'. 'contact-box' . '"', $before_widget );
		}
		else {
			$before_widget = str_replace( 'class="', 'class="'. 'contact-box' . ' ', $before_widget );
		}

		global $ct_options;

		echo wp_kses_post( $before_widget );
		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title );
		} ?>

		<?php if ( ct_get_lang_count() > 1 ) { ?>

			<div class="styled-select">
			<select class="form-control cl-switcher" name="lang" id="lang">
				<?php
				$languages = icl_get_languages('skip_missing=1');
				foreach ( $languages as $l ) {
					$selected = ( $l['active'] ) ? 'selected' : '';
					echo '<option ' . $selected . ' data-url="' . esc_url( $l['url'] ) . '">' . esc_html( $l['translated_name'] ) . '</option>';
				} ?>
			</select>
			</div>

		<?php } ?>

		<?php if ( ct_is_multi_currency() ) { ?>
			<div class="styled-select">
			<select class="form-control cl-switcher" name="currency" id="currency">
				<?php
					$all_currencies = ct_get_all_available_currencies();
					foreach ( array_filter( $ct_options['site_currencies'] ) as $key => $content) {
						$selected = ( ct_get_user_currency() == $key ) ? 'selected' : '';
						$params = $_GET;
						$params['selected_currency'] = $key;
						$paramString = http_build_query($params, '', '&amp;');
						echo '<option ' . $selected . ' data-url="' . esc_url( strtok( $_SERVER['REQUEST_URI'], '?' ) . '?' . $paramString ) . '">' . esc_html( strtoupper( $key ) ) . '</option>';
					}
				?>
			</select>
			</div>
		<?php }
		echo wp_kses_post( $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		$defaults = array( 'title' => 'Settings Title' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ) ?>" />
		</p>

	<?php }
}
endif;


function ct_register_widgets() {
	register_widget( 'CTSettingsWidget' );
}

add_action( 'widgets_init', 'ct_register_widgets' );