<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 use \IncludeFile\Base\BaseController;

 class SettingsLinks {

    protected $plugin;

    public function register() {
       add_filter("plugin_action_links_$this->plugin", array ($this, 'settings_link'));
    }

    public function settings_link( $links ) {
        $setting_link = '<a href="admin.php?page=bsardo_plugin"> Settings </a>';
        array_push($links, $setting_link);
        return $links;
    }
 }