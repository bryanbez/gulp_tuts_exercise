<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;
 use \IncludeFile\Api\SettingsApi;
 use \IncludeFile\Api\Callbacks\AdminCallbacks;

 class CustomPostTypeCtrl extends BaseController {

    public $subpages = [];
    public $callbacks;

    public function register() {

        $option_name = get_option('bsardo_plugin');
        $checked_option = isset($option_name['custom_post_type_mngr']) ? $option_name['custom_post_type_mngr'] : false;

        if (!$checked_option) { 
            return ; 
        }
        
        $this->settings = new SettingsApi(); 
        $this->callbacks = new AdminCallbacks();
        $this->setSubPages();
        $this->settings->addSubPages($this->subpages)->register();
        add_action('init', array($this, 'activateCustomPostTypeCtrl'));

    }

    public function activateCustomPostTypeCtrl() {

        register_post_type('bsardo_custom_type', [
            'labels' => [
                'name' => 'Your Own Post Types',
                'singular_name' => 'Your Own Post Type'
            ],
            'public' => true,
            'has_archive' => true
        ]);
 
    }

    public function setSubPages() {

        $this->subpages = [
            [
                'parent_slug' => 'bsardo_plugin',
                'page_title' => 'Custom Post Types',
                'menu_title' => 'CPT',
                'capability' => 'manage_options',
                'menu_slug' => 'bsardo_cpt',
                'callback' => array($this->callbacks, 'cptManager'),
            ],
        ];

    }

 }