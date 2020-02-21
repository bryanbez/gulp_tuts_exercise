<?php

/**
 *
 * @package bsardoplugin
 * 
 */

namespace IncludeFile\Api\Callbacks;

 class CustomPostTypeCallbacks {

    public function cptSectionMessage() {

        echo 'Manage CPT';

    }

    public function CPTSanitize( $input ) {

        $output = get_option('bsardo_plugin_cpt');

        //remove custom post type
        if (isset($_POST['remove_post_type'])) {

            unset($output[$_POST['remove_post_type']]);
            return $output;
        }

        if (count($output) == 0) {
            $output[$input['post_type']] = $input;
            return $output;
        }
    
        foreach($output as $key => $value) {
            
            if ($input['post_type'] === $key) {
                $output[$key] = $input; // Update Existing Record
            } else {
                $output[$input['post_type']] = $input; // Add Record
            }
        }
    
        return $output;

    }

    public function textBoxField( $args ) {

        $txt_name = $args['label_for'];
        $passPageValue = $args['passPageValue'];
        $value = '';
        $checkPostType = (isset($_POST['edit_post_type']) ? (($txt_name === 'post_type') ? 'readonly' : '') : null);

        if(isset($_POST['edit_post_type'])) {
            $textbox = get_option($passPageValue); 
            $value = $textbox[$_POST['edit_post_type']][$txt_name];
        }

        echo '<input type="text" class="regular-text" id="'.$txt_name.'" name="' . $passPageValue. '[' . $txt_name .
        ']" value="'.$value.'" placeholder="'.$args['placeholder'].'" required '.$checkPostType.'>';
    }

    public function checkBoxField($args) {
        $chk_name = $args['label_for'];
        $classes = $args['class'];
        $passPageValue = $args['passPageValue'];
        $checked = false; 

        if(isset($_POST['edit_post_type'])) {
            $checkbox = get_option($passPageValue);
            $checked = isset($checkbox[$_POST['edit_post_type']][$chk_name]) ?: false;
        }
        
        echo '<input type="checkbox" id="'.$chk_name.'" name="'.$passPageValue.'['.$chk_name.']" 
                value="1" class="" '. ($checked ? 'checked' : '') .'>';
       
    
    }  


 }