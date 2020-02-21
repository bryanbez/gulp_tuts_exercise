<?php

/**
 *
 * @package bsardoplugin
 * 
 */

namespace IncludeFile\Api\Callbacks;

 class TaxonomiesCallbacks {

    public function taxSectionMessage() {

        echo isset($_POST['edit_taxonomies']) ? 'Edit Your Own Taxonomy' : 'Add Your Own Taxonomy';

    }

    public function TaxSanitize( $input ) {

        $output = get_option('bsardo_plugin_tax');

        //remove taxonomies
        if (isset($_POST['remove_taxonomies'])) {

            unset($output[$_POST['remove_taxonomies']]);
            return $output;
        }

        if (count($output) == 0) {
            $output[$input['taxonomies_id']] = $input;
            return $output;
        }
    
        foreach($output as $key => $value) {
            
            if ($input['taxonomies_id'] === $key) {
                $output[$key] = $input; // Update Existing Record
            } else {
                $output[$input['taxonomies_id']] = $input; // Add Record
            }
        }
    
        return $output;

    }

    public function textBoxField( $args ) {

        $txt_name = $args['label_for'];
        $passPageValue = $args['passPageValue'];
        $value = '';
        $checkPostType = (isset($_POST['edit_taxonomies']) ? (($txt_name === 'taxonomies_id') ? 'readonly' : '') : null);

        if(isset($_POST['edit_taxonomies'])) {
            $textbox = get_option($passPageValue); 
            $value = $textbox[$_POST['edit_taxonomies']][$txt_name];
        }

        echo '<input type="text" class="regular-text" id="'.$txt_name.'" name="' . $passPageValue. '[' . $txt_name .
        ']" value="'.$value.'" placeholder="'.$args['placeholder'].'" required '.$checkPostType.'>';
    }

    public function checkBoxField($args) {
        $chk_name = $args['label_for'];
        $classes = $args['class'];
        $passPageValue = $args['passPageValue'];
        $checked = false; 

        if(isset($_POST['edit_taxonomies'])) {
            $checkbox = get_option($passPageValue);
            $checked = isset($checkbox[$_POST['edit_taxonomies']][$chk_name]) ?: false;
        }
        
        echo '<input type="checkbox" id="'.$chk_name.'" name="'.$passPageValue.'['.$chk_name.']" 
                value="1" class="" '. ($checked ? 'checked' : '') .'>';
       
    
    }  

    public function checkBoxFieldPostTypes( $args ) {

    	$output = '';
    	$chk_name = $args['label_for'];
        $classes = $args['class'];
        $passPageValue = $args['passPageValue'];
        $checked = false; 

        if(isset($_POST['edit_taxonomies'])) { 
		    $checkbox = get_option($passPageValue);
		      
		 }

    	$get_list_of_post_types = get_post_types( array( 'show_ui' => true ) );
 

    	foreach ($get_list_of_post_types as $post_type) {

    		if(isset($_POST['edit_taxonomies'])) {
		        $checked = isset($checkbox[$_POST['edit_taxonomies']][$chk_name][$post_type]) ?: false;
    		}
		    
    		$output .= '<input type="checkbox" id="'.$chk_name.'" name="'.$passPageValue.'['.$chk_name.']['.$post_type.']" 
                value="1" class="" '. ($checked ? 'checked' : '') .'><label> '.$post_type.' </label><br />';
    		
    	}

    	echo $output;
    }


 }