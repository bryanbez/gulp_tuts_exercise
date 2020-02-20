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
            </div>
            
        </div>


</div>