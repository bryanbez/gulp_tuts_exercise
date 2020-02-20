<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Pages;
  
 use \IncludeFile\Api\SettingsApi;
 use \IncludeFile\Base\BaseController;
 use \IncludeFile\Api\Callbacks\AdminCallbacks;
 use \IncludeFile\Api\Callbacks\ManageCallbacks;

 class Dashboard extends BaseController {

    public $settings;
    public $pages = [];
   // public $subpages = [];
    public $callbacks;

    public function register() {

        $this->settings = new SettingsApi(); 
        $this->callbacks = new AdminCallbacks();
        $this->callbacks_mngr = new ManageCallbacks();
        $this->setPages();
        // $this->setSubPages();
        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->withSubpages('Dashboard')->register();
    }

    public function setSettings() {

        $args = [
            [
                'option_group' => 'bsardo_plugin_settings',
                'option_name' => 'bsardo_plugin',
                'callback' => [
                    $this->callbacks_mngr,
                    'checkBoxSanitize'
                ]
            ]
        ];

        $this->settings->setSettings($args);
    }


    public function setPages() {

        $this->pages = [
            [ 
                'page_title' => 'BSardo Plugin',
                'menu_title' => 'BSardoPlugin',
                'capability' => 'manage_options',
                'menu_slug' => 'bsardo_plugin',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-store',
                'position' => 110
            ],

        ];
    }

    public function setSections() {

        $args = [
            [
                'id' => 'bsardo_admin_section_id',
                'title' => 'Settings',
                'callback' => [
                    $this->callbacks_mngr,
                    'adminSectionManager'
                ],
                'page' => 'bsardo_plugin',
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields() {

        $args = [];
       
        foreach($this->managers as $key => $value) {
            $args[] = [
                'id' => $key,
                'title' => $value,
                'callback' => [
                    $this->callbacks_mngr,
                    'checkBoxField'
                ],
                'page' => 'bsardo_plugin',
                'section' => 'bsardo_admin_section_id',
                'args' => [
                    'passPageValue' => 'bsardo_plugin',
                    'label_for' => $key,
                    'class' => 'form-control'
                ]
            ];    

        }

        $this->settings->setFields($args);
    }

 }