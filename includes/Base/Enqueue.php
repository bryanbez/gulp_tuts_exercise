<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 use \IncludeFile\Base\BaseController;

 class Enqueue extends BaseController {

    function enqueue_styles_and_scripts() {
        wp_enqueue_script('custom_script', $this->plugin_url. 'assets/mycustomscript.js');
        wp_enqueue_style('custom_style', $this->plugin_url. 'assets/mycustomstyle.css');
    }

    function register() {
        add_action('admin_enqueue_scripts', array( $this, 'enqueue_styles_and_scripts'));
    }

 }