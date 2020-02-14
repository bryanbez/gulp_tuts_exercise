<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;
 use \IncludeFile\Api\SettingsApi;
 use \IncludeFile\Api\Callbacks\AdminCallbacks;

 class GalleryController extends BaseController {

    public $subpages = [];
    public $callbacks;

    public function register() {

        $option_name = get_option('bsardo_plugin');
        $checked_option = isset($option_name['gallery_options']) ? $option_name['gallery_options'] : false;
        
        if (!$checked_option) { 
            return ; 
        }
        
        $this->settings = new SettingsApi(); 
        $this->callbacks = new AdminCallbacks();
        $this->setSubPages();
        $this->settings->addSubPages($this->subpages)->register();
        add_action('init', array($this, 'activateGalleryCtrl'));

    }

    public function activateGalleryCtrl() {

        register_post_type('bsardo_gallery', [
            'labels' => [
                'name' => 'Galleries',
                'singular_name' => 'Gallery'
            ],
            'public' => true,
            'has_archive' => true
        ]);
 
    }

    public function setSubPages() {

        $this->subpages = [
            [
                'parent_slug' => 'bsardo_plugin',
                'page_title' => 'Manage Gallery',
                'menu_title' => 'Manage Gallery',
                'capability' => 'manage_options',
                'menu_slug' => 'bsardo_gallery',
                'callback' => array($this->callbacks, 'galleryOptions'),
            ],
        ];

    }

 }