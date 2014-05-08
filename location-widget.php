<?php
/*
Plugin Name:  Bellevue College Location Widget
Plugin URI:   http://www.bellevuecollege.edu/
Description:  Department/Unit Location Widget.
Version:      0.1
Author:       BC DevCom
Author URI:   http://www.bellevuecollege.edu/
*/





class mayflower_location_plugin extends WP_Widget {

// constructor
    function mayflower_location_plugin() {
        parent::WP_Widget(false, $name = __('Locations', 'wp_widget_plugin') );
    }

// widget form creation
function form($instance) {

// Check values
if( $instance) {
     $location_widget_title = esc_attr($instance['location_widget_title']);
     $location_text = esc_attr($instance['location_text']);
     $hours_title = esc_attr($instance['hours_title']);
     $hours_text = esc_attr($instance['hours_text']);
     $select = esc_attr($instance['select']);
} else {
     $location_widget_title = 'Our Location';
     $location_text = '';
     $hours_title = '';
     $hours_text = '';
     $select = '';
}
?>

<p>
<label for="<?php echo $this->get_field_id('location_widget_title'); ?>"><?php _e('Location Widget Title:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('location_widget_title'); ?>" class="widefat" name="<?php echo $this->get_field_name('location_widget_title'); ?>" type="text" value="<?php echo $location_widget_title; ?>" />
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
<label for="<?php echo $this->get_field_id('hours_text'); ?>"><?php _e('Hours Description:', 'wp_widget_plugin'); ?></label>
<input id="<?php echo $this->get_field_id('hours_text'); ?>" class="widefat" name="<?php echo $this->get_field_name('hours_text'); ?>" type="text" value="<?php echo $hours_text; ?>" />
</p>


<p>
<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Select', 'wp_widget_plugin'); ?></label>
<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
<?php
$options = array("Generic Campus Pic", "A Building", "C Building", "D Building", "Early Childhood Center", "Eastern", "Gym", "IBIT", "ISP", "K Building", "KBCS", "L Building", "M Building", "N Building", "N216", "Planetarium", "R Building", "S Building", "Student Services");
foreach ($options as $option) {
echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
}
?>
</select>
</p>
<?php
}

// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['location_widget_title'] = strip_tags($new_instance['location_widget_title']);
      $instance['location_text'] = strip_tags($new_instance['location_text']);
      $instance['hours_title'] = strip_tags($new_instance['hours_title']);
      $instance['hours_text'] = strip_tags($new_instance['hours_text']);
      $instance['select'] = strip_tags($new_instance['select']);
     return $instance;
}
// display widget
function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $location_widget_title = apply_filters('widget_title', $instance['location_widget_title']);
   $location_text = $instance['location_text'];
   $hours_title = apply_filters('widget_title', $instance['hours_title']);
   $hours_text = $instance['hours_text'];
   $select = $instance['select'];

$buildingpic_url = WP_CONTENT_URL . '/themes/mayflower/inc/mayflower-location/buildings/';

   echo $before_widget;
   // Display the widget

   // Check if location title is set
   if ( $location_widget_title ) {
       //echo  "<h3>".$location_widget_title."</h3>" ;
       echo $before_title . $location_widget_title . $after_title;
   }
   //
	?>
	<div>
    
    <?php
	//Insert Image
   // Get $select value
	if ( $select == 'Generic Campus Pic' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic1.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'A Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-a-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'C Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-c-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'D Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-d-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'Early Childhood Center' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-e-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'Eastern' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-eastern.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'Gym' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-gym.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'IBIT' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-ibit.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'ISP' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-isp.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'K Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-k-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'KBCS' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-kbcs.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'L Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-l-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'M Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-m-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'N216' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-n216.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'Planetarium' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-planetarium.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'R Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-r-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'S Building' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-s-bldg.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
	<?php
		} else if ( $select == 'Student Services' ) { ?>
		<img src="<?php echo $buildingpic_url . "campus-pic-student-services.jpg";  ?>" title="<?php echo $instance['select']; ?>" alt="<?php echo $instance['select']; ?>" />
    
    
<?php 
   // Check if location text is set
   if( $location_text ) {
      echo '<div>'.$location_text.'</div>';
   }

   // Check if hours title is set
   if ( $hours_title ) {
      echo $before_title . $hours_title . $after_title;
   }

   // Check if hours text is set
   if( $hours_text ) {
      echo '<div>'.$hours_text.'</div>';
   }
?>




	<?php
		echo 'ipsum option is Selected';
		} else {
		echo 'dolorem option is Selected';
	}
?>
</div>

<?php
   echo $after_widget;
}} // mayflower_location_plugin Class

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "mayflower_location_plugin" );' ) );

?>
