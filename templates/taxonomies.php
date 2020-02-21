<div class="wrap">

    <h1> CPT Manager </h1>
    <?php settings_errors(); ?>
   
    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST['edit_taxonomies']) ? 'active' : '' ?>"> <a href="#tab-manage"> Manage Taxonomies </a></li>
        <li class="<?php echo isset($_POST['edit_taxonomies']) ? 'active' : '' ?>"><a href="#tab-add-new"> <?php echo isset($_POST['edit_taxonomies']) ? 'Edit Taxonomy' : 'Add Taxonomy' ?> </a></li>
        <li><a href="#tab-export"> Export </a>
    
    </ul>

        <div class="tab-content">

            <div id="tab-manage" class="tab-pane <?php echo !isset($_POST['edit_taxonomies']) ? 'active' : '' ?>">
                <h3> Manage Taxonomies</h3>

               <?php  
                    $options = get_option('bsardo_plugin_tax') ?: [];
   

                    if (count($options) === 0) {
                        echo '<br/ ><br /><h3 class="noCustomPostType"> No Taxonomy/ies Saved </h3>';
                    }
                    else {
                        ?> <table class="tableCptManager">
                        <tr>
                            <th>Custom Taxonomy ID</th>  
                            <th> Singular Name </th>                    
                            <th> Hierarchical </th> 
                            <th colspan="2">Options</th> 
                        </tr>
                            <?php foreach($options as $option) {
                                $hierarchical = isset($option['is_hierarchical']) ? 'TRUE' : 'FALSE';
                            ?>
                        <tr>
                            <td> <?php echo $option['taxonomies_id']; ?> </td>
                            <td> <?php echo $option['singular_name']; ?> </td>
                            <td> <?php echo $hierarchical; ?> </td>
                            <td> 
                                <form action="" method="post">
                                    <?php
                                        settings_fields('bsardo_plugin_tax_settings');
                                        ?><input type="hidden" name="edit_taxonomies" value="<?php echo $option['taxonomies_id']; ?>"></input>
                                        <?php submit_button('Edit', 'btnEdit', 'submit_edit', false);
                                    ?>
                                </form>
                            </td>
                            <td>
                                <form action="options.php" method="post">
                                    <?php
                                        settings_fields('bsardo_plugin_tax_settings');
                                        ?><input type="hidden" name="remove_post_type" value="<?php echo $option['taxonomies_id']; ?>"></input>
                                        <?php submit_button('Delete', 'btnDelete', 'submit_delete', false, [
                                            'onclick' => 'return confirm("Are you sure to delete this taxonomy? ");'
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

            <div id="tab-add-new" class="tab-pane <?php echo isset($_POST['edit_taxonomies']) ? 'active' : '' ?>">
                <form action="options.php" method="post">
                    <?php
                        settings_fields('bsardo_plugin_tax_settings');
                        do_settings_sections('bsardo_taxonomies');
                        submit_button();
                    ?>
                </form>
            </div>

            <div id="tab-export" class="tab-pane">
                <h3> Export </h3>

              <!--   <?php foreach($options as $option) { ?>

                    <pre class="prettyprint">

           
                    </pre>

                    <?php } ?> -->
            </div>
            
        </div>


</div>