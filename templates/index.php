<div class="wrap">

    <h1>BSardo Plugin</h1>

    <ul class="nav nav-tabs">
        <li class="active"> <a href="#tab-settings"> Settings </a></li>
        <li><a href="#tab-updates"> Updates </a></li>
        <li><a href="#tab-about"> About BSardo Plugin </a>
    
    </ul>

    <div class="tab-content">
        <div id="tab-settings" class="tab-pane active">
            <form action="options.php" method="post">
                <?php
                    settings_fields('bsardo_plugin_settings');
                    do_settings_sections('bsardo_plugin');
                    submit_button();
                ?>
            </form>
        </div>

        <div id="tab-updates" class="tab-pane">
            <h3> Updates </h3>
        </div>

        <div id="tab-about" class="tab-pane">
            <h3> About BSardo Plugin</h3>
        </div>
    </div>

</div>

