<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;
 use \IncludeFile\Api\SettingsApi;
 use \IncludeFile\Base\BaseController;
 use \IncludeFile\Api\Callbacks\AdminCallbacks;
 use \IncludeFile\Api\Callbacks\TaxonomiesCallbacks;

 class TaxonomiesCtrl extends BaseController {


    public $subpages = [];
    public $settings;
    public $callbacks;
    public $taxonomies_callbacks;
    public $taxonomies = [];
    public $setSettings = array();
    public $setSections = array();
    public $setFields = array();


    public function register() {

        if (!$this->activatedGetOption('taxonomies_manager')) return;

        $this->settings = new SettingsApi(); 
        $this->callbacks = new AdminCallbacks();
        $this->taxonomies_callbacks = new TaxonomiesCallbacks();
        $this->setSubPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addSubPages($this->subpages)->register();

        $this->storeCustomTaxonomy();

        if (!empty($this->taxonomies)) {
            add_action('init', array($this, 'activateTaxonomies'));
        }
      

    }

    public function setSettings() {

        $args = [
            [
                'option_group' => 'bsardo_plugin_tax_settings',
                'option_name' => 'bsardo_plugin_tax',
                'callback' => [
                    $this->taxonomies_callbacks,
                    'TaxSanitize'
                ]
            ]
        ];

        $this->settings->setSettings($args);
    } 

    public function setSections() {

        $args = [
            [
                'id' => 'bsardo_admin_tax_index',
                'title' => 'Taxonomies Manager',
                'callback' => [
                    $this->taxonomies_callbacks,
                    'taxSectionMessage'
                ],
                'page' => 'bsardo_taxonomies',
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields() {

        $args = [
            [
                'id' => 'taxonomies_id',
                'title' => 'Taxonomy ID',
                'callback' => [
                    $this->taxonomies_callbacks,
                    'textBoxField'
                ],
                'page' => 'bsardo_taxonomies', 
                'section' => 'bsardo_admin_tax_index',
                'args' => [
                    'passPageValue' => 'bsardo_plugin_tax',
                    'label_for' => 'taxonomies_id',
                    'placeholder' => 'eg. genre'
                ]
            ],
            [
                'id' => 'singular_name',
                'title' => 'Singular Name',
                'callback' => [
                    $this->taxonomies_callbacks,
                    'textBoxField'
                ],
                'page' => 'bsardo_taxonomies', 
                'section' => 'bsardo_admin_tax_index',
                'args' => [
                    'passPageValue' => 'bsardo_plugin_tax',
                    'label_for' => 'singular_name',
                    'placeholder' => 'eg. Genre'
                ]
            ],
            [
                'id' => 'is_hierarchical',
                'title' => 'Is Hierarchical',
                'callback' => [
                    $this->taxonomies_callbacks,
                    'checkBoxField'
                ],
                'page' => 'bsardo_taxonomies', 
                'section' => 'bsardo_admin_tax_index',
                'args' => [
                    'passPageValue' => 'bsardo_plugin_tax',
                    'label_for' => 'is_hierarchical',
                    'class' => 'form-control'
                ]
            ],
             [
                'id' => 'on_post_types',
                'title' => 'List of Post Types to apply the taxonomy',
                'callback' => [
                    $this->taxonomies_callbacks,
                    'checkBoxFieldPostTypes'
                ],
                'page' => 'bsardo_taxonomies', 
                'section' => 'bsardo_admin_tax_index',
                'args' => [
                    'passPageValue' => 'bsardo_plugin_tax',
                    'label_for' => 'on_post_types',
                    'class' => 'form-control'
                ]
            ]
        ];
       
        $this->settings->setFields($args);
    }

    public function setSubPages() {

        $this->subpages = [
            [
                'parent_slug' => 'bsardo_plugin',
                'page_title' => 'Add Taxonomies',
                'menu_title' => 'Taxonomies',
                'capability' => 'manage_options',
                'menu_slug' => 'bsardo_taxonomies',
                'callback' => array($this->callbacks, 'taxonomiesManager'),
            ],
        ];

    }

	public function storeCustomTaxonomy() {

		  $options = get_option('bsardo_plugin_tax') ?: [];
   
            foreach ($options as $option) {
            
            	$labels = [
						'name'                       => $option['singular_name'],
						'singular_name'              => $option['singular_name'],
						'menu_name'                  => $option['singular_name'],
						'all_items'                  => 'All '. $option['singular_name'],
						'parent_item'                => 'Parent '. $option['singular_name'],
						'parent_item_colon'          => 'Parent '. $option['singular_name'],
						'new_item_name'              => 'New '. $option['singular_name'] . ' Name',
						'add_new_item'               => 'Add New '. $option['singular_name'],
						'edit_item'                  => 'Edit '. $option['singular_name'],
						'update_item'                => 'Update '. $option['singular_name'],
						'search_items'               => 'Search '. $option['singular_name'],
				];

                $this->taxonomies[] = [
						'labels'                     => $labels,
						'hierarchical'               => isset($option['hierarchical']) ? true : false,
						'public'                     => true,
						'show_ui'                    => true,
						'show_admin_column'          => true,
						'show_in_nav_menus'          => true,
						'query_var'                  => true,
						'rewrite'                    => array('slug' => $option['singular_name']),
						'objects'                    => isset($option['on_post_types']) ? $option['on_post_types'] : null
				];

			}
	}

	public function activateTaxonomies() {

		foreach($this->taxonomies as $taxonomy) {

			$objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null;

			register_taxonomy( $taxonomy['rewrite']['slug'], $objects, $taxonomy );

		}

	}
	


























}