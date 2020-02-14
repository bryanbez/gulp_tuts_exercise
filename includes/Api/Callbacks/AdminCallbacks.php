<?php
namespace IncludeFile\Api\Callbacks;

use IncludeFile\Base\BaseController;

class AdminCallbacks extends BaseController {

    public function adminDashboard() {
        return require_once("$this->plugin_path/templates/index.php");
    }

    public function manageItems() {
        return require_once("$this->plugin_path/templates/manage_items.php");
    }

    public function manageCustomer() {
        return require_once("$this->plugin_path/templates/manage_customer.php");
    }

    // public function bsardo_option_group($input) {
    //     // input validation
    //     return $input;
    // }

    // public function bsardo_admin_section() {
    //     echo 'This is the Section';
    // }

    public function bsardo_fields() {
        $setValueInput = esc_attr(get_option('sample_name'));
        echo '<input type="text" class="regular-text" name="sample_name" value="'.$setValueInput.'" placeholder="...">';
    }

}