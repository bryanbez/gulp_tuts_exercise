<?php

/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 class Activate {

    public static function activate() {
        
        flush_rewrite_rules();

        $default = array();

        if (! get_option('bsardo_plugin')) {
            update_option('bsardo_plugin', $default); // generate bsardo_plugin field in wp_option table in database
        }

        if (! get_option('bsardo_plugin_cpt')) {
            update_option('bsardo_plugin_cpt', $default); // generate bsardo_plugin_cpt field in wp_option table in database
        }

         if (! get_option('bsardo_plugin_tax')) {
            update_option('bsardo_plugin_tax', $default); // generate bsardo_plugin_tax field in wp_option table in database
        }


    }
 }