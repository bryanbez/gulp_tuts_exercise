<?php

/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 class Activate {

    function activate() {
        flush_rewrite_rules();

        if (get_option('bsardo_plugin')) {
            return;
        }

        $default = array();
        update_option('bsardo_plugin', $default);

    }
 }