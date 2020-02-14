<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;
 use \IncludeFile\Api\SettingsApi;
 use \IncludeFile\Api\Callbacks\AdminCallbacks;

 class TestimonialsCtrl extends BaseController {

    public $subpages = [];
    public $callbacks;

    public function register() {

        $option_name = get_option('bsardo_plugin');
        $checked_option = isset($option_name['testimonials']) ? $option_name['testimonials'] : false;

        if (!$checked_option) { 
            return ; 
        }
        
        $this->settings = new SettingsApi(); 
        $this->callbacks = new AdminCallbacks();
        $this->setSubPages();
        $this->settings->addSubPages($this->subpages)->register();
        add_action('init', array($this, 'activateTestimonialCtrl'));

    }

    public function activateTestimonialCtrl() {

        register_post_type('bsardo_testimonials', [
            'labels' => [
                'name' => 'Testimonials',
                'singular_name' => 'Testimonial'
            ],
            'public' => true,
            'has_archive' => true
        ]);
 
    }

    public function setSubPages() {

        $this->subpages = [
            [
                'parent_slug' => 'bsardo_plugin',
                'page_title' => 'Testimonials',
                'menu_title' => 'Testimonials',
                'capability' => 'manage_options',
                'menu_slug' => 'bsardo_testimonials',
                'callback' => array($this->callbacks, 'testimonials'),
            ],
        ];

    }

 }