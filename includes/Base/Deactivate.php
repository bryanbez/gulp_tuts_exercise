<?php
/**
 * @package BSardoPlugin
 */

namespace IncludeFile\Base;

class Deactivate {

    public static function deactivate() {

        // global $wpdb;

        // $wpdb->query("DELETE FROM wp_options WHERE option_name = 'bsardo_plugin'");
        // $wpdb->query("DELETE FROM wp_options WHERE option_name = 'bsardo_plugin_cpt'");


        flush_rewrite_rules();

    
    }
 }