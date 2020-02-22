<?php
/**
 * @package BSardoPlugin
 */

 namespace IncludeFile\Base;

 use IncludeFile\Api\Widgets\MediaWidgets;

 class WidgetsCtrl extends BaseController {

    public function register() {

        if (!$this->activatedGetOption('custom_widgets')) return;

        $media_widget = new MediaWidgets;

        $media_widget->register();
      

    }

}


