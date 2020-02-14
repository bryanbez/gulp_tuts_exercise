<?php

/**
 *
 * @package bsardoplugin
 * 
 */

namespace IncludeFile\Api\Callbacks;

use IncludeFile\Base\BaseController;

 class ManageCallbacks extends BaseController {

    public function checkBoxSanitize( $input ) {

        $output = array();
        //return (isset($input) ? true : false);
        foreach($this->managers as $key => $value) {
            $output[$key] = isset($input[$key]) ? true : false;
        }
        return $output;
    }

    public function adminSectionManager() {
        echo 'Activate Section and Fields base on your website';
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