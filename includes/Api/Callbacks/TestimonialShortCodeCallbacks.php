<?php
/**
 * @package BSardoPlugin
 */

namespace IncludeFile\Api\Callbacks;

use \IncludeFile\Base\BaseController;


 class TestimonialShortCodeCallbacks extends BaseController {

 	public function shortCodePage() {

 		return require_once($this->plugin_path. '/templates/testimonials.php');
 	}


 }