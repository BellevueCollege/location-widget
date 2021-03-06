<?php
/*
Plugin Name:  Bellevue College Location Widget
Plugin URI:   https://github.com/BellevueCollege/location-widget/
Description:  Department/Unit Location Widget.
Version:      1.5
Author:       Bellevue College Information Technology Services
Author URI:   http://www.bellevuecollege.edu/
GitHub Plugin URI: bellevuecollege/location-widget
*/

add_action( 'after_setup_theme', 'location_widget_image_sizes', 10 );

/**
 * Add image size to use for images from media library
 */
function location_widget_image_sizes() {
	add_image_size( 'location-thumbnail', 300, 200, true );
}

/**
 * Main Widget Class
 */
class Bc_Location_Widget extends WP_Widget {

	//	Construct Widget	//
	function __construct() {

		// Add Widget scripts
		add_action('admin_enqueue_scripts', array($this, 'scripts'));

		parent::__construct(
			// Base ID of your widget
			'bc_location_widget',

			// Widget name will appear in UI
			__( 'Office Location', 'wp_widget_plugin' ),

			// Widget description
			array( 'description' => __( 'Show your Bellevue College location and office hours!', 'wp_widget_plugin' ), )
		);
	}

	// Scripts for media library uploader //
	public function scripts()
	{
	   wp_enqueue_script( 'media-upload' );
	   wp_enqueue_media();
	   wp_enqueue_script('upload-media', plugins_url( 'upload-media.js', __FILE__ ) , array('jquery'));
	}

	// widget form creation	//
	function form( $instance ) {
		// Check values
		if ( $instance) {
			$location_widget_title = isset( $instance['location_widget_title'] ) ? esc_attr( $instance['location_widget_title'] ) : "";
			$location_text = isset( $instance['location_text'] ) ? esc_attr( $instance['location_text'] ) : "";
			$image = ! empty( $instance['image'] ) ? $instance['image'] : '';
			$hours_title = isset($instance['hours_title']) ? esc_attr($instance['hours_title']):"";
			$hours_text = isset($instance['hours_text']) ? esc_attr($instance['hours_text']) : "";
			$select = isset($instance['select']) ? esc_attr($instance['select']) : "";
		} else {
			$location_widget_title = 'Our Location';
			$location_text = '';
			$image = '';
			$hours_title = 'Hours:';
			$hours_text = '';
			$select = '';
		}?>

		<p>
			<label for="<?php echo $this->get_field_id('location_widget_title'); ?>"><?php _e('Location Widget Title:', 'wp_widget_plugin'); ?></label>
			<input id="<?php echo $this->get_field_id('location_widget_title'); ?>" class="widefat" name="<?php echo $this->get_field_name('location_widget_title'); ?>" type="text" value="<?php echo $location_widget_title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Select Building Image', 'wp_widget_plugin'); ?></label>
			<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
				<?php $options = array(
					"None",
					"Generic Campus Pic",
					"A Building",
					"B Building Back",
					"C Building",
					"C Building Door",
					"D Building",
					"Faculty Commons",
					"Early Childhood Center",
					"Eastern",
					"Gym",
					"IBIT",
					"ISP",
					"K Building",
					"KBCS",
					"L Building",
					"M Building",
					"N Building",
					"N216",
					"Planetarium",
					"R Building",
					"S Building",
					"Student Services" );
				foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				} ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Or Upload An Image:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_textarea( $image ); ?>" />
			<button class="clear_image_button button">Clear</button>  <button class="upload_image_button button button-primary">Select/Upload Image</button>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('location_text'); ?>"><?php _e('Office Location:', 'wp_widget_plugin'); ?></label>
			<input id="<?php echo $this->get_field_id('location_text'); ?>" class="widefat" name="<?php echo $this->get_field_name('location_text'); ?>" type="text" value="<?php echo $location_text; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('hours_title'); ?>"><?php _e('Hours Title', 'wp_widget_plugin'); ?></label>
			<input id="<?php echo $this->get_field_id('hours_title'); ?>" class="widefat" name="<?php echo $this->get_field_name('hours_title'); ?>" type="text" value="<?php echo $hours_title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('hours_text'); ?>"><?php _e('Office Hours:', 'wp_widget_plugin'); ?></label>
			<input id="<?php echo $this->get_field_id('hours_text'); ?>" class="widefat" name="<?php echo $this->get_field_name('hours_text'); ?>" type="text" value="<?php echo $hours_text; ?>" />
		</p>
	<?php }

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		// Fields
		$instance['location_widget_title'] = strip_tags( $new_instance['location_widget_title'] );
		$instance['location_text'] = strip_tags( $new_instance['location_text'] );
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? $new_instance['image'] : '';
		$instance['hours_title'] = strip_tags( $new_instance['hours_title'] );
		$instance['hours_text'] = strip_tags( $new_instance['hours_text'] );
		$instance['select'] = strip_tags( $new_instance['select'] );
		
		return $instance;
	}
	// display widget
	function widget( $args, $instance ) {
		extract( $args );
		// these are the widget options
		$location_widget_title = ! empty( $instance['location_widget_title'] ) ? $instance['location_widget_title'] : '';
		$location_text = ! empty( $instance['location_text'] ) ? $instance['location_text'] : '';
		$image = ! empty( $instance['image'] ) ? $instance['image'] : '';
		$hours_title = ! empty( $instance['hours_title'] ) ? $instance['hours_title'] : '';
		$hours_text = ! empty( $instance['hours_text'] ) ? $instance['hours_text'] : '';
		$select = ! empty( $instance['select'] ) ? $instance['select'] : '';

		$buildingpic_url = plugins_url( 'buildings/' , __FILE__ );

		echo $before_widget;
		// Display the widget

		// Check if location title is set
		if ( $location_widget_title ) {
			//echo  "<h3>".$location_widget_title."</h3>" ;
			echo $before_title . $location_widget_title . $after_title;
		} 
		?>

		<?php
		//Insert Image
		// Get $select value
		if ( $image ){
			echo wp_get_attachment_image( $image, 'location-thumbnail', false, array( 'class' => 'img-responsive mw-100' ) );
		} else {
			if ( $select == 'None' ) { 
				// nothing here, blank option for no image!
				} else if ( $select == 'Generic Campus Pic' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic1.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'A Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-a-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'B Building Back' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-b-bldg-back.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'C Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-c-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'C Building Door' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-c-bldg-door.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'D Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-d-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'Early Childhood Center' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-e-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'Eastern' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-eastern.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'Faculty Commons' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-d-bldg-faculty-commons.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'Gym' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-gym.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'IBIT' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-ibit.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'ISP' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-isp.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'K Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-k-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'KBCS' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-kbcs.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'L Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-l-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'M Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-m-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'N Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-n-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'N216' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-n216.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'Planetarium' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-planetarium.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'R Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-r-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'S Building' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-s-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php
				} else if ( $select == 'Student Services' ) { ?>
				<img class="img-responsive mw-100" src="<?php echo $buildingpic_url . "campus-pic-student-services.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
			<?php } else {
				// nothing happens!
			}
		} ?>

		<?php 
		ob_start();
		echo $args['before_widget'];
		?>
		
		<?php
		echo $args['after_widget'];
		ob_end_flush();
		?>

		<ul id="location-widget-text">
		<?php
			// Check if location text is set
			if ( $location_text ) {
				echo '<li>'.$location_text.'</li>';
			}
			if ( $hours_text && $hours_title ) { ?>
			
				<li>
					<?php
						// Check if hours text is set
						if ( $hours_text ) {
							echo $hours_title.' ';
						}

						// Check if hours text is set
						if ( $hours_text ) {
							echo $hours_text;
						}
					?>
				</li>
			<?php } ?>
		</ul>

		<?php echo $after_widget;
	}
} // bc_location_widget Class

// register widget
add_action( 'widgets_init', function(){
	register_widget( 'bc_location_widget' ); 
} );
