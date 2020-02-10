<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Pages;
  
 use \IncludeFile\Base\BaseController;
 use \IncludeFile\Api\SettingsApi;

 class Admin extends BaseController {

    public $settings;
    public $pages;
    public $subpages;

    public function register() {

        $this->settings = new SettingsApi(); 

        $this->setPages();
        $this->setSubPages();

        $this->settings->addPages($this->pages)->withSubpages('Dashboard')->addSubPages($this->subpages)->register();
    }

    public function setPages() {

        $this->pages = [
            [ 
                'page_title' => 'BSardo Plugin',
                'menu_title' => 'BSardoPlugin',
                'capability' => 'manage_options',
                'menu_slug' => 'bsardo_plugin',
                'callback' => function() { echo '<h1> Callback </h1>'; },
                'icon_url' => 'dashicons-store',
                'position' => 110
            ],

        ];
    }

    public function setSubPages() {

        $this->subpages = [
            [
                'parent_slug' => 'bsardo_plugin',
                'page_title' => 'Items',
                'menu_title' => 'Manage Items',
                'capability' => 'manage_options',
                'menu_slug' => 'manage_items',
                'callback' => function() { echo '<h1> Manage Items </h1>'; },
            ],
            [
                'parent_slug' => 'bsardo_plugin',
                'page_title' => 'Customers',
                'menu_title' => 'Manage Customers',
                'capability' => 'manage_options',
                'menu_slug' => 'manage_customers',
                'callback' => function() { echo '<h1> Manage Customers </h1>'; },
            ]
        ];


    }

 }