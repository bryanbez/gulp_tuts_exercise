<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Api\Widgets;

 use WP_Widget;

 class MediaWidgets extends WP_Widget {

 	public $widget_ID = '';

 	public $widget_name = '';

 	public $widget_options = [];

 	public $control_options = [];

    public function __construct() {

    	$this->widget_ID = 'bsardo_custom_widget';

    	$this->widget_name = 'BSardo Custom Widget';

    	$this->widget_options = [

    		'classname' => $this->widget_ID,

    		'description' => $this->widget_name,

    		'customize_select_refresh' => true // no reload of page if set to true

    	];

    	$this->control_options = [ // width and height of widget

    		'width' => 400,

    		'height' => 400

    	];

    }

    public function register() {

    	parent::__construct($this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options);

    	add_action( 'widgets_init', [ $this, 'registerWidget' ]);

    }

    public function registerWidget() {

    	register_widget( $this );
    }

    public function widget( $args, $instance) { // do not change the function name

    	echo $args['before_widget']; // ::before

    		if (!empty($instance['title'])) {
    			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title']) . $args['after_title']; 
    		}
    		if (!empty($instance['image'])) { // can use custom html and css to print the image

    			echo '<img src="'.esc_url($instance['image']).'" alt="">';
    			 
    		}

    	echo $args['after_widget']; // ::after
    }

    public function form($instance) { // do not change the function name

    	$title = !empty( $instance['title']) ? $instance['title'] : esc_html__('Insert Text', 'bsardo_plugin'); // esc_html filters the text input by the user.
    	$image = !empty( $instance['image']) ? $instance['image'] : '';

    	$titleID = esc_attr( $this->get_field_id('title') );

    	?>
			<p>
				<label for="<?php echo $titleID; ?>">Title</label>
				<input type="text" class="widefat" id="<?php echo $titleID; ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
			</p>
			<p>
				
				<label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_attr_e( 'Image', 'awps' ); ?></label>
				<input type="text" class="widefat image-upload" id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_url($image); ?>">
				<button class="button button-primary js-image-upload">Select Image</button>
			</p>

    	<?php

    }

    public function update($new_instance, $old_instance) { // do not change the function name

    	$instance = $old_instance;

    	$instance['title'] = sanitize_text_field( $new_instance['title'] );

    	$instance['image'] = !empty( $new_instance['image']) ? $new_instance['image'] : '';

    	return $instance;

    }

}



