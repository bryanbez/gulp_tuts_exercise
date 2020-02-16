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

        return $input;

    }

    public function textBoxField( $args ) {

        $txt_name = $args['label_for'];
        $passPageValue = $args['passPageValue'];
        $textbox = get_option($passPageValue);
        $placeholder = $args['placeholder'];

        echo '<input type="text" class="regular-text" id="'.$txt_name.'" name="'.$passPageValue.'['.$txt_name.']"
             value="'.$textbox.'" placeholder="'.$placeholder.'"';
    }

    public function checkBoxField($args) {
        $chk_name = $args['label_for'];
        $classes = $args['class'];
        $passPageValue = $args['passPageValue'];
        $checkbox = get_option($passPageValue);
        $checked = isset($checkbox[$chk_name]) ? ($checkbox[$chk_name] ? true : false): false;

        echo '<input type="checkbox" id="'.$chk_name.'" name="'.$passPageValue.'['.$chk_name.']" 
                value="1" class="" '. ($checked ? 'checked' : '') .'>';
       
    
    }  


 }