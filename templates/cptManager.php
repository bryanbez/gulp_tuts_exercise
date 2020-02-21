<div class="wrap">

    <h1> CPT Manager </h1>
    <?php settings_errors(); ?>
   
    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST['edit_post_type']) ? 'active' : '' ?>"> <a href="#tab-manage"> Manage Custom Post Types </a></li>
        <li class="<?php echo isset($_POST['edit_post_type']) ? 'active' : '' ?>"><a href="#tab-add-new"> <?php echo isset($_POST['edit_post_type']) ? 'Edit Custom Post Type' : 'Add Custom Post Type' ?> </a></li>
        <li><a href="#tab-export"> Export </a>
    
    </ul>

        <div class="tab-content">

            <div id="tab-manage" class="tab-pane <?php echo !isset($_POST['edit_post_type']) ? 'active' : '' ?>">
                <h3> Manage Custom Post Types</h3>

               <?php  
                    $options = get_option('bsardo_plugin_cpt') ?: [];

                    if (count($options) === 0) {
                        echo '<br/ ><br /><h3 class="noCustomPostType"> No Custom Post Type Saved </h3>';
                    }
                    else {
                        ?> <table class="tableCptManager">
                        <tr>
                            <th>Custom Post ID</th>  
                            <th>Singular Name</th>  
                            <th>Plural Name</th>  
                            <th> Is Public </th>  
                            <th> Is has Archive</th> 
                            <th colspan="2">Options</th> 
                        </tr>
                            <?php foreach($options as $option) {
                                $public = isset($option['public']) ? 'TRUE' : 'FALSE';
                                $has_archive = isset($option['has_archive']) ? 'TRUE' : 'FALSE';
                            ?>
                        <tr>
                            <td> <?php echo $option['post_type']; ?> </td>
                            <td> <?php echo $option['singular_name']; ?> </td>
                            <td> <?php echo $option['plural_name']; ?> </td>
                            <td> <?php echo $public; ?> </td>
                            <td> <?php echo $has_archive; ?> </td>
                            <td> 
                                <form action="" method="post">
                                    <?php
                                        settings_fields('bsardo_plugin_cpt_settings');
                                        ?><input type="hidden" name="edit_post_type" value="<?php echo $option['post_type']; ?>"></input>
                                        <?php submit_button('Edit', 'btnEdit', 'submit_edit', false);
                                    ?>
                                </form>
                            </td>
                            <td>
                                <form action="options.php" method="post">
                                    <?php
                                        settings_fields('bsardo_plugin_cpt_settings');
                                        ?><input type="hidden" name="remove_post_type" value="<?php echo $option['post_type']; ?>"></input>
                                        <?php submit_button('Delete', 'btnDelete', 'submit_delete', false, [
                                            'onclick' => 'return confirm("Are you sure to delete this custom post type? ");'
                                        ]);
                                    ?>
                                </form>
                            </td>
                        </tr>
                            <?php } ?>
                        </table>
                        <?php
                    }
                    ?>
            </div>

            <div id="tab-add-new" class="tab-pane <?php echo isset($_POST['edit_post_type']) ? 'active' : '' ?>">
                <form action="options.php" method="post">
                    <?php
                        settings_fields('bsardo_plugin_cpt_settings');
                        do_settings_sections('bsardo_cpt');
                        submit_button();
                    ?>
                </form>
            </div>

            <div id="tab-export" class="tab-pane">
                <h3> Export </h3>

                <?php foreach($options as $option) { ?>

                    <pre class="prettyprint">

                    // Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( '<?php echo $option['singular_name'] ?>', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '<?php echo $option['plural_name'] ?>', 'text_domain' ),
		'plural_name'             => __( '<?php echo $option['plural_name'] ?>', 'text_domain' ),
		'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Post Type', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => <?php isset($option['public']) ? 'true' : 'false'; ?>,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => <?php isset($option['has_archive']) ? 'true' : 'false'; ?>,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( '<?php echo $option['post_type']; ?>', $args );

}
add_action( 'init', 'custom_post_type', 0 );
                    
                    </pre>

                    <?php } ?>
            </div>
            
        </div>


</div>