<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 use \IncludeFile\Base\BaseController;
 use \IncludeFile\Api\SettingsApi;
 use \IncludeFile\Api\Callbacks\TestimonialShortCodeCallbacks;

 class TestimonialsCtrl extends BaseController {

 	public $settings;

 	public $callbacks;

    public function register() {

        if (!$this->activatedGetOption('testimonials')) return;

        $this->settings = new SettingsApi();

        $this->callbacks = new TestimonialShortCodeCallbacks();
        
        add_action('init', array( $this, 'testimonials_cpt'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes_function'));
   		add_action('save_post', array($this, 'save_post_function') );
   		add_action('manage_testimonial_posts_columns', array($this, 'set_custom_columns')); // set column header
   		add_action('manage_testimonial_posts_custom_column', array($this, 'set_custom_columns_data'), 10, 2); // set column data
   		add_filter('manage_edit-testimonial_sortable_columns', array($this, 'sortable_column_headers'));

   		$this->setPageOfShortCode();

   		add_shortcode( 'testimonial-form', array($this, 'testimonial_form') );

   		add_action('wp_ajax_submit_contact_form', array($this, 'submit_testimonial'));

   		add_action('wp_ajax_nopriv_submit_contact_form', array($this, 'submit_testimonial'));

    }

    public function submit_testimonial() {

    	if (! DOING_AJAX || ! check_ajax_referer('testimonial_nonce', 'nonce')) {

    		$this->return_json('zero');

    	}

    	$name = sanitize_text_field($_POST['name']);
    	$email = sanitize_email($_POST['email']);
    	$message = sanitize_textarea_field($_POST['message']);

    	$data = [

    		'name' => $name,
    		'email' => $email,
    		'approved' => 0,
    		'featured' => 0,

    	];

    	$args = [
    		'post_title' => 'Testimonial from '.$name,
    		'post_content' => $message,
    		'post_author' => 1, // admin
    		'post_status' => 'publish',
    		'post_type' => 'testimonial',
    		'meta_input' => [
    			'_bsardo_testimonial_author_key' => $data
    		]
    	];

    	$postID = wp_insert_post($args, false);

    	if ($postID) {
    		$this->return_json($postID);
    	}

    	$this-> return_json('zero');

    }

    public function return_json($status) {

    		$return = [
		    	'status' => $status,
		    ];

		    wp_send_json( $return );

	    	wp_die();

    }

    public function testimonial_form() {

    	ob_start();
    	echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/sass/form.min.css\">";
    	require_once("$this->plugin_path/templates/contactForm.php");
    	echo "<script src=\"$this->plugin_url/assets/js/form.min.js\"></script>";
    	return ob_get_clean();
    }

    public function setPageOfShortCode() {

    	$subpage = [
    		[
    			'parent_slug' => 'edit.php?post_type=testimonial',
    			'page_title' => 'Testimonial ShortCodes',
    			'menu_title' => 'Testimonial ShortCodes',
    			'capability' => 'manage_options',
    			'menu_slug' => 'bsardo_testimonial_shortcodes',
    			'callback' => [
    				$this->callbacks, 'shortCodePage' 
    			]
    		]
    	];

    	$this->settings->addSubPages($subpage)->register();
    }

    public function testimonials_cpt() {

    	$labels = [
    		'name' => 'Testimonials Manager',
    		'singular_name' => 'Testimonial Manager'
    	];

    	$args = [

    		'labels' => $labels,
    		'public' => true,
    		'has_archive' => false, 
    		'menu_icon' => 'dashicons-testimonial',
    		'exclude_from_search' => true,
    		'plublicly_queryable' => false,
    		'supports' => ['title', 'editor']

    	];

    	register_post_type( 'testimonial', $args);

    }

    public function add_meta_boxes_function() {

    	add_meta_box(

    		'testimonial_author',
    		'Testimonial Author',
    		array($this, 'render_featured_box'),
    		'testimonial', // unique id
    		'side', // position of testimonial manager
    		'default'

    	);


    }

    public function render_featured_box($post) {

    	wp_nonce_field( 'bsardo_testimonial', 'bsardo_testimonial_nonce' );

    	$data = get_post_meta( $post->ID, '_bsardo_testimonial_author_key', true );

    	$name = isset($data['name']) ? $data['name'] : '';
    	$email = isset($data['email']) ? $data['email'] : '';
    	$approved = isset($data['approved']) ? $data['approved'] : false;
    	$featured = isset($data['featured']) ? $data['featured'] : false;

    	 ?>
	
		<p>
			<label for="bsardo_testimonial_author">Author</label>
			<input type="text" id="bsardo_testimonial_author" name="bsardo_testimonial_author" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label for="bsardo_testimonial_author_email">Author Email</label>
			<input type="text" id="bsardo_testimonial_author_email" name="bsardo_testimonial_author_email" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<p>
			<input type="checkbox" id="bsardo_testimonial_is_approved" name="bsardo_testimonial_is_approved" value="1" <?php echo $approved ? 'checked' : ''; ?> ><label for="bsardo_testimonial_is_approved">Is Approved</label>
		</p>
		<p>
			<input type="checkbox" id="bsardo_testimonial_author_featured" name="bsardo_testimonial_author_featured" value="1" class="" <?php echo $featured ? 'checked' : ''; ?> ><label for="bsardo_testimonial_author_featured">Is Featured</label>
		</p>

    	<?php


    }

    public function save_post_function($post_id) {

    	if (!isset($_POST['bsardo_testimonial_nonce'])) {

    		return $post_id;

    	}

    	$nonce = $_POST['bsardo_testimonial_nonce'];

    	if (! wp_verify_nonce( $nonce, 'bsardo_testimonial' )) {

    		return $post_id;

    	}

    	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

    		return $post_id;
    	}

    	if (!current_user_can( 'edit_post', $post_id )) {

    		return $post_id;
    	}

    	$data = [

    		'name' => sanitize_text_field($_POST['bsardo_testimonial_author']),
    		'email' => sanitize_email($_POST['bsardo_testimonial_author_email']),
    		'approved' => isset($_POST['bsardo_testimonial_is_approved']) ? 1 : 0,
    		'featured' => isset($_POST['bsardo_testimonial_author_featured']) ? 1 : 0

    	];

    	// var_dump( $post_id );
    	// die();

    	update_post_meta( $post_id, '_bsardo_testimonial_author_key', $data );

    }

    public function set_custom_columns($columns) {

    		
    	$title = $columns['title'];
    	$date = $columns['date'];

    	unset($columns['title'], $columns['date']);

    	$columns['name'] = 'Author';
    	$columns['title'] = $title;
    	$columns['approved'] = 'Is Approved';
    	$columns['featured'] = 'Is Featured';
    	$columns['date'] = $date;


    	return $columns;

    }

    public function set_custom_columns_data($column, $post_id) {


    	$data = get_post_meta( $post_id, '_bsardo_testimonial_author_key', true );

    	$name = isset($data['name']) ? $data['name'] : '';
    	$email = isset($data['email']) ? $data['email'] : '';
    	$approved = isset($data['approved']) && $data['approved'] === 1 ? '<b> YES </b>' : 'NO';
    	$featured = isset($data['featured']) && $data['featured'] === 1 ? '<b> YES </b>' : 'NO';


    	switch($column) {

    		case 'name':
    			echo '<strong>'. $name .'</strong><br /><a href="mailto:' .$email.'">' . $email . '</a>';
    			break;

    		case 'approved':
    			echo $approved;
    			break;

    		case 'featured': 
    			echo $featured;
    			break;
    	}


    }

    public function sortable_column_headers($columns) {

    	$columns['name'] = 'name';
    	$columns['approved'] = 'approved';
    	$columns['featured'] = 'featured';

    	return $columns;

    }


 }