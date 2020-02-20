<?php

/**
 * @package BSardoPlugin
 */
 /**
  * Plugin Name: MyCustomPlugin
  * Description: My First Custom Plugin
  * Version: 1.0
  * Author: Bryan Sardo
  * Text Domain: bsardoplugin
  */

defined ('ABSPATH') or die ('Hoy wag mong galawin to ahahaha');

if (file_exists (dirname(__FILE__) .'/vendor/autoload.php')) {
    require_once dirname(__FILE__) .'/vendor/autoload.php';
}

// Plugin Activation
function activate_bsardo_plugin() {
    IncludeFile\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_bsardo_plugin');

// Plugin Deactivation
function deactivate_bsardo_plugin() {
    IncludeFile\Base\Activate::activate();
}

register_deactivation_hook(__FILE__, 'deactivate_bsardo_plugin');



// Initialize all classes of the plugin
if (class_exists('IncludeFile\\Init')) {
    IncludeFile\Init::register_services();
}




