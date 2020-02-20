<?php


/**
 * @package BSardoPlugin
 */

 
if(!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;

$wpdb->query("DELETE FROM wp_options WHERE option_name = 'bsardo_plugin'");
$wpdb->query("DELETE FROM wp_options WHERE option_name = 'bsardo_plugin_cpt'");