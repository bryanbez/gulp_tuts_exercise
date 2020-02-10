<?php
/**
 * @package BSardoPlugin
 */

namespace IncludeFile\Base;

class Deactivate {

    function deactivate() {
        flush_rewrite_rules();
    }
 }