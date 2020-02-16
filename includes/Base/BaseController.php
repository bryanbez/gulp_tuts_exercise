<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 class BaseController {

     public $plugin_path;
     public $plugin_url;
     public $plugin;
     public $managers = [];

     public function __construct() {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin = plugin_basename(dirname(__FILE__, 3)) . '/bsardoplugin.php';

        $this->managers = [
            'custom_post_type_mngr' => 'CPT Manager',
            'gallery_options' => 'Gallery Options',
            'testimonials' => 'Manage Testimonials'
        ];

     }

     public function activatedGetOption (string $key) {
         
        $option = get_option('bsardo_plugin');
        return isset($option[$key]) ? $option[$key] : false; 
     }


 }