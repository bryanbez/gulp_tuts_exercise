<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;
 use \IncludeFile\Api\SettingsApi;
 use \IncludeFile\Base\BaseController;
 use \IncludeFile\Api\Callbacks\AdminCallbacks;
 use \IncludeFile\Api\Callbacks\CustomPostTypeCallbacks;

 class CustomPostTypeCtrl extends BaseController {

    public $subpages = [];
    public $settings;
    public $callbacks;
    public $cpt_callbacks;
    public $custom_post_types = [];
    public $setSettings = array();
    public $setSections = array();
    public $setFields = array();


    public function register() {

        if (!$this->activatedGetOption('custom_post_type_mngr')) return;

        $this->settings = new SettingsApi(); 
        $this->callbacks = new AdminCallbacks();
        $this->cpt_callbacks = new CustomPostTypeCallbacks();
        $this->setSubPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addSubPages($this->subpages)->register();

        $this->storeCustomPostTypeContent();

        if (!empty($this->custom_post_types)) {
            add_action('init', array($this, 'activateCustomPostTypeCtrl'));
        }
      

    }

    public function setSettings() {

        $args = [
            [
                'option_group' => 'bsardo_plugin_cpt_settings',
                'option_name' => 'bsardo_plugin_cpt',
                'callback' => [
                    $this->cpt_callbacks,
                    'CPTSanitize'
                ]
            ]
        ];

        $this->settings->setSettings($args);
    } 

    public function setSections() {

        $args = [
            [
                'id' => 'bsardo_admin_cpt_index',
                'title' => 'Custom Post Type Manager',
                'callback' => [
                    $this->cpt_callbacks,
                    'cptSectionMessage'
                ],
                'page' => 'bsardo_cpt',
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields() {

        $args = [
            [
                'id' => 'post_type',
                'title' => 'CPT ID',
                'callback' => [
                    $this->cpt_callbacks,
                    'textBoxField'
                ],
                'page' => 'bsardo_cpt', 
                'section' => 'bsardo_admin_cpt_index',
                'args' => [
                    'passPageValue' => 'bsardo_cpt',
                    'label_for' => 'post_type',
                    'placeholder' => 'eg. post_type'
                ]
            ],
            [
                'id' => 'singular_name',
                'title' => 'Singular Name',
                'callback' => [
                    $this->cpt_callbacks,
                    'textBoxField'
                ],
                'page' => 'bsardo_cpt', 
                'section' => 'bsardo_admin_cpt_index',
                'args' => [
                    'passPageValue' => 'bsardo_cpt',
                    'label_for' => 'singular_name',
                    'placeholder' => 'eg. Post Type'
                ]
            ],
            [
                'id' => 'plural_name',
                'title' => 'Plural Name',
                'callback' => [
                    $this->cpt_callbacks,
                    'textBoxField'
                ],
                'page' => 'bsardo_cpt', 
                'section' => 'bsardo_admin_cpt_index',
                'args' => [
                    'passPageValue' => 'bsardo_cpt',
                    'label_for' => 'plural_name',
                    'placeholder' => 'eg. Post Types'
                ]
            ],
            [
                'id' => 'has_archives',
                'title' => 'Has Archives',
                'callback' => [
                    $this->cpt_callbacks,
                    'checkBoxField'
                ],
                'page' => 'bsardo_cpt', 
                'section' => 'bsardo_admin_cpt_index',
                'args' => [
                    'passPageValue' => 'bsardo_cpt',
                    'label_for' => 'has_archives',
                    'class' => 'form-control'
                ]
            ],
            [
                'id' => 'public',
                'title' => 'Public',
                'callback' => [
                    $this->cpt_callbacks,
                    'checkBoxField'
                ],
                'page' => 'bsardo_cpt', 
                'section' => 'bsardo_admin_cpt_index',
                'args' => [
                    'passPageValue' => 'bsardo_cpt',
                    'label_for' => 'public',
                    'class' => 'form-control'
                ]
            ],
                

        ];
       
        $this->settings->setFields($args);
    }

    public function setSubPages() {

        $this->subpages = [
            [
                'parent_slug' => 'bsardo_plugin',
                'page_title' => 'Custom Post Types',
                'menu_title' => 'CPT',
                'capability' => 'manage_options',
                'menu_slug' => 'bsardo_cpt',
                'callback' => array($this->callbacks, 'cptManager'),
            ],
        ];

    }

    public function storeCustomPostTypeContent() {
        
        $this->custom_post_types[] = [
            'post_type' => 'bsardo_custom_type',
            'name' => 'Your Own Post Types',
            'singular_name' => 'Your Own Post Type',
            'menu_name' => '',
            'name_admin_bar' => '',
            'archives' => '',
            'attributes' => '',
            'parent_item_colon' => '',
            'all_items' => '',
            'add_new_item' => '',
            'add_new' => '',
            'new_item' => '',
            'edit_item' => '',
            'update_item' => '',
            'view_item' => '',
            'view_items' => '',
            'search_items' => '',
            'not_found' => '',
            'not_found_in_trash' => '',
            'featured_image' => '',
            'set_featured_image' => '',
            'remove_featured_image' => '',
            'insert_into_item' => '',
            'uploaded_to_this_item' => '',
            'items_list' => '',
            'items_list_navigation' => '',
            'filter_items_list' => '',
            'label' => '',
            'description' => '',
            'supports' => false,
            'taxonomies' => [],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'excluded_from_search' => false,
            'capability_type' => 'page',
        ];
    }

    public function activateCustomPostTypeCtrl() {

        foreach($this->custom_post_types as $custom_post_type) {

            register_post_type($custom_post_type['post_type'], [
                'labels' => [
                    'name' => $custom_post_type['name'],
                    'singular_name' => $custom_post_type['singular_name'],
                    'menu_name' => $custom_post_type['menu_name'],
                    'name_admin_bar' => $custom_post_type['name_admin_bar'],
                    'archives' => $custom_post_type['archives'],
                    'attributes' => $custom_post_type['attributes'],
                    'parent_item_colon' => $custom_post_type['parent_item_colon'],
                    'all_items' => $custom_post_type['all_items'],
                    'add_new_item' => $custom_post_type['add_new_item'],
                    'add_new' => $custom_post_type['add_new'],
                    'new_item' => $custom_post_type['new_item'],
                    'edit_item' => $custom_post_type['edit_item'],
                    'update_item' =>  $custom_post_type['update_item'],
                    'view_item' => $custom_post_type['view_item'],
                    'view_items' => $custom_post_type['view_items'],
                    'search_items' => $custom_post_type['search_items'],
                    'not_found' => $custom_post_type['not_found'],
                    'not_found_in_trash' => $custom_post_type['not_found_in_trash'],
                    'featured_image' => $custom_post_type['featured_image'],
                    'set_featured_image' => $custom_post_type['set_featured_image'],
                    'remove_featured_image' => $custom_post_type['remove_featured_image'],
                    'insert_into_item' => $custom_post_type['insert_into_item'],
                    'uploaded_to_this_item' => $custom_post_type['uploaded_to_this_item'],
                    'items_list' => $custom_post_type['items_list'],
                    'items_list_navigation' => $custom_post_type['items_list_navigation'],
                    'filter_items_list' => $custom_post_type['filter_items_list'],
                ],
                'label' => $custom_post_type['label'],
                'public' => $custom_post_type['public'],
                'has_archive' => $custom_post_type['has_archive'],
                'description' => $custom_post_type['description'],
                'supports' => $custom_post_type['supports'],
                'taxonomies' => $custom_post_type['taxonomies'],
                'hierarchical' => $custom_post_type['hierarchical'],
                'show_ui' => $custom_post_type['show_ui'],
                'show_in_menu' => $custom_post_type['show_in_menu'],
                'menu_position' => $custom_post_type['menu_position'],
                'show_in_admin_bar' => $custom_post_type['show_in_admin_bar'],
                'show_in_nav_menus' => $custom_post_type['show_in_nav_menus'],
                'can_export' => $custom_post_type['can_export'],
                'excluded_from_search' => $custom_post_type['excluded_from_search'],
                'capability_type' => $custom_post_type['capability_type']
            ]);

        }

      
 
    }

   
 }