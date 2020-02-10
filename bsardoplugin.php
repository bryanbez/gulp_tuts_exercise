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

if (class_exists('IncludeFile\\Init')) {
    IncludeFile\Init::register_services();
}




