<?php

/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 class Activate {

    function activate() {
        flush_rewrite_rules();
    }
 }