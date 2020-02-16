<div class="wrap">

    <h1> CPT Manager </h1>
    <?php settings_errors();  ?>

    <form action="options.php" method="post">
        <?php
            settings_fields('bsardo_plugin_cpt_settings');
            do_settings_sections('bsardo_cpt');
            submit_button();
        ?>
    </form>

</div>


