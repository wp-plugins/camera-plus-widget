<?php
/**
 * Plugin Name: Camera+ Widget
 * Plugin URI: http://austin.passy.co/wordpress-plugins/camera-plus-widget
 * Description: Showcase your iPhone <a href="http://frosty.me/camera-plusAPP">camera+</a> photos in a widget.
 * Version: 0.2
 * Author: Austin Passy
 * Author URI: http://austin.passy.co
 *
 * @copyright 2012 - 2014
 * @author Austin Passy
 * @link http://frostywebdesigns.com/
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package camera_plus_widget
 */
 
if ( !class_exists( 'camera_plus_widget' ) ) {

	add_action( 'widgets_init', 'register_camera_plus_widget' );

	function register_camera_plus_widget() {
		register_widget( 'camera_plus_widget' );
	}

	class camera_plus_widget extends WP_Widget {
	
		var $prefix,
			$textdomain,
			$shortlink;
	
		/**
		 * Set up the widget's unique name, ID, class, description, and other options.
		 */
		function camera_plus_widget() {
			$this->prefix		= 'camera-plus-widget';
			$this->textdomain	= 'camera-plus';
			$this->shortlink	= 'http://frosty.me/camera-plusAPP';
	
			$widget_ops = array( 'classname' => 'cameraplus', 'description' => __( 'An advanced widget that showcases your camera+ photos.', $this->textdomain ) );
			$control_ops = array( 'width' => 525, 'height' => 350, 'id_base' => "{$this->prefix}-cameraplus" );
			$this->WP_Widget( "{$this->prefix}-cameraplus", __( 'Camera+', $this->textdomain ), $widget_ops, $control_ops );
		}
	
		/**
		 * Outputs the widget based on the arguments input through the widget controls.
		 */
		function widget( $args, $instance ) {
			extract( $args );
	
			$args = array();
	
			$args['iframe'] = isset( $instance['iframe'] ) ? $instance['iframe'] : false;
			$args['width'] = !empty( $instance['width'] ) ? intval( $instance['width'] ) : '300';
			$args['height'] = !empty( $instance['height'] ) ? intval( $instance['height'] ) : '450';
			
			$args['user'] = $instance['user'];
			$args['rows'] = !empty( $instance['rows'] ) ? intval( $instance['rows'] ) : '3';
			$args['columns'] = !empty( $instance['columns'] ) ? intval( $instance['columns'] ) : '3';
			$args['thumbsize'] = !empty( $instance['thumbsize'] ) ? intval( $instance['thumbsize'] ) : '120';
			$args['color'] = $instance['color'];
			$args['background'] = !empty( $instance['background'] ) ? $instance['background'] : 'transparent';
			$args['logo'] = $instance['logo'];
			
			$args['thumbstyle'] = $instance['thumbstyle'];
			$args['heading'] = $instance['heading'];
			$args['animated'] = $instance['animated'];
			$args['iframe'] = isset( $instance['iframe'] ) ? $instance['iframe'] : false;
			$args['recent'] = !empty( $instance['recent'] ) ? intval( $instance['recent'] ) : '9';
			$args['love'] = isset( $instance['love'] ) ? $instance['love'] : true;
			
			$link_love = ( $args['love'] ) ? sprintf( __( '<p><a href="%s">Camera+</a> widget built by <a href="%s">Frosty</a>.</p>', $this->textdomain ), $this->shortlink, 'http://austinpassy.com/wordpress-plugins/camera-plus-widget/' ) : null;
			
			echo $before_widget;
	
			if ( $instance['title'] )
				echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;
			
			if ( $instance['iframe'] ) {
				
				echo "<iframe style=\"width: {$args['width']}px; height: {$args['height']}px;\" allowtransparency=\"true\" scrolling=\"no\" frameborder=\"0\" src=\"http://campl.us/user/{$args['user']}:widget?rows={$args['rows']}&amp;columns={$args['columns']}&amp;thumbnailsize={$args['thumbsize']}&amp;color={$args['color']}&amp;backgroundcolor={$args['background']}&amp;logostyle={$args['logo']}&amp;thumbnailstyle={$args['thumbstyle']}&amp;heading={$args['heading']}&amp;animated={$args['animated']}\"></iframe>";
				
				if ( !is_null( $link_love ) ) echo $link_love;
			
			} else {
				
				echo "<script type=\"text/javascript\" src=\"http://campl.us/photog/{$args['user']}/recent.js?num_pics={$args['recent']}\"></script>";
				
				if ( !is_null( $link_love ) ) echo $link_love;
				
			}
	
			echo $after_widget;
		}
	
		/**
		 * Updates the widget control options for the particular instance of the widget.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			$instance = $new_instance;
	
			$instance['width'] = intval( $new_instance['width'] );
			$instance['height'] = intval( $new_instance['height'] );
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['user'] = strip_tags( $new_instance['user'] );
			$instance['rows'] = $new_instance['rows'];
			$instance['columns'] = $new_instance['columns'];
			$instance['thumbsize'] = intval( $new_instance['thumbsize'] );
			$instance['color'] = strip_tags( $new_instance['color'] );
			/* ***/
			$instance['logo'] = $new_instance['logo'];
			$instance['background'] = $new_instance['background'];
			$instance['heading'] = $new_instance['heading'];
			$instance['thumbstyle'] = $new_instance['thumbstyle'];
			$instance['animated'] = $new_instance['animated'];
			$instance['iframe'] = isset( $new_instance['iframe'] ) ? true : false;
			$instance['recent'] = !empty( $new_instance['recent'] ) ? intval( $new_instance['recent'] ) : '9';
			$instance['love'] = isset( $new_instance['love'] ) ? true : false;
	
			return $instance;
		}
	
		/**
		 * Displays the widget control options in the Widgets admin screen.
		 */
		function form( $instance ) {
	
			//Defaults
			$defaults = array(
				'title' 	=> __( 'My Camera+ Photos', $this->textdomain ),
				'width' 	=> '300',
				'height'	=> '400',
				/* *******************/
				'user' 		=> '',
				'rows' 		=> '3',
				'columns' 	=> '3',
				'thumbsize'	=> '120',
				'color' 	=> 'light',
				/* ********************/
				'logo'		=> 'small',
				'background'=> 'transparent',
				'heading'	=> 'yes',
				'thumbstyle'=> 'skewed',
				'animated'	=> 'yes',
				'iframe'	=> true,
				'recent'	=> '9',
				'love'		=> true,
			);
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$numbers = array( '1' => __( '1', $this->textdomain ), '2' => __( '2', $this->textdomain ), '3' => __( '3', $this->textdomain ), '4' => __( '4', $this->textdomain ), '5' => __( '5', $this->textdomain ), '6' => __( '6', $this->textdomain ), '7' => __( '7', $this->textdomain ), '8' => __( '8', $this->textdomain ), '9' => __( '9', $this->textdomain ), '10' => __( '10', $this->textdomain ) );
			$style = array( 'dark' => __( 'Dark', $this->textdomain ), 'light' => __( 'Light', $this->textdomain ) );
			$camera = array( 'small' => __( 'Small', $this->textdomain ), 'medium' => __( 'Medium', $this->textdomain ), 'large' => __( 'Large', $this->textdomain ), 'none' => __( 'None', $this->textdomain ) );
			$thumb = array( 'straight' => __( 'Straight', $this->textdomain ), 'skewed' => __( 'Skewed', $this->textdomain ) );
			$yesno = array( 'yes' => __( 'Yes', $this->textdomain ), 'no' => __( 'No', $this->textdomain ) );
	
			?>
            
			<div class="camera-plus-widget-controls">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', $this->textdomain ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p style="float:left; width:47%;">
				<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'widget width:', $this->textdomain ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" />
			</p>
			<p style="float:right; width:47%;">
				<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'widget height:', $this->textdomain ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo esc_attr( $instance['height'] ); ?>" />
			</p>
            </div>
	
			<div class="camera-plus-widget-controls" style="clear: both; float:left; width:47%;">
			<p>
				<label for="<?php echo $this->get_field_id( 'user' ); ?>"><code><?php _e( 'user name', $this->textdomain ); ?></code></label>
				<input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" value="<?php echo esc_attr( $instance['user'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'rows' ); ?>"><code><?php _e( 'rows', $this->textdomain ); ?></code></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'rows' ); ?>" name="<?php echo $this->get_field_name( 'rows' ); ?>">
					<?php foreach ( $numbers as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['rows'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'columns' ); ?>"><code><?php _e( 'columns', $this->textdomain ); ?></code></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'columns' ); ?>" name="<?php echo $this->get_field_name( 'columns' ); ?>">
					<?php foreach ( $numbers as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['columns'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'thumbsize' ); ?>"><code><?php _e( 'thumbnail size', $this->textdomain ); ?></code></label>
				<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'thumbsize' ); ?>" name="<?php echo $this->get_field_name( 'thumbsize' ); ?>" value="<?php echo esc_attr( $instance['thumbsize'] ); ?>" maxlength="3" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'color' ); ?>"><code><?php _e( 'color', $this->textdomain ); ?></code></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>">
					<?php foreach ( $style as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['color'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'logo' ); ?>"><code><?php _e( 'camera+ logo', $this->textdomain ); ?></code></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'logo' ); ?>" name="<?php echo $this->get_field_name( 'logo' ); ?>">
					<?php foreach ( $camera as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['logo'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			</div>
	
			<div class="camera-plus-widget-controls" style="float:right; width:47%;">
			<p>
				<label for="<?php echo $this->get_field_id( 'background' ); ?>"><code><?php _e( 'background color', $this->textdomain ); ?></code></label>
				<input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'background' ); ?>" name="<?php echo $this->get_field_name( 'background' ); ?>" value="<?php echo esc_attr( $instance['background'] ); ?>" /><br />
                <span class="description"><?php _e( 'Use CSS value.', $this->textdomain ); ?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'heading' ); ?>"><code><?php _e( 'heading', $this->textdomain ); ?></code></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'heading' ); ?>" name="<?php echo $this->get_field_name( 'heading' ); ?>">
					<?php foreach ( $yesno as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['heading'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'thumbstyle' ); ?>"><code><?php _e( 'thumbnail style', $this->textdomain ); ?></code></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'thumbstyle' ); ?>" name="<?php echo $this->get_field_name( 'thumbstyle' ); ?>">
					<?php foreach ( $thumb as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['thumbstyle'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'animated' ); ?>"><code><?php _e( 'animated', $this->textdomain ); ?></code></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'animated' ); ?>" name="<?php echo $this->get_field_name( 'animated' ); ?>">
					<?php foreach ( $yesno as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['animated'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
            <p>
                <label for="<?php echo $this->get_field_id( 'love' ); ?>">
                <input class="checkbox" type="checkbox" <?php checked( $instance['love'], true ); ?> id="<?php echo $this->get_field_id( 'love' ); ?>" name="<?php echo $this->get_field_name( 'love' ); ?>" />
                <span class="description"><?php _e( 'Show some author love.', $this->textdomain ); ?></span></label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'iframe' ); ?>"><code><?php _e( 'iframe', $this->textdomain ); ?></code>
                <input class="checkbox" type="checkbox" <?php checked( $instance['iframe'], true ); ?> id="<?php echo $this->get_field_id( 'iframe' ); ?>" name="<?php echo $this->get_field_name( 'iframe' ); ?>" />
                <span class="description"><?php _e( 'Check the box to output your images in the camera+ iframe. Leaving the box unchecked with use javascript.', $this->textdomain ); ?></span></label>
            </p>
            <?php if ( !$instance['iframe'] ) { ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'recent' ); ?>"><code><?php _e( 'image count:', $this->textdomain ); ?></code></label>
                <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'recent' ); ?>" name="<?php echo $this->get_field_name( 'recent' ); ?>" value="<?php echo esc_attr( $instance['recent'] ); ?>" maxlength="2" />
            </p>
            <?php } ?>
            <p><?php sprintf( __( 'Don\'t have a <a href="%1$s">Camera+</a> account? Get the iPhone <a href="%1$s">app</a>.', $this->textdomain ), $this->shortlink ); ?></p>
			</div>
			<div style="clear:both;">&nbsp;</div>
		<?php
		}
	}
	
};