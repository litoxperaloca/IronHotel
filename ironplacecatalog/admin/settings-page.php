<?php
	function ironplacecatalog_settings_page() {
        // usuario tiene permisos 
        if (!current_user_can('manage_options')) {
            return;
        }
		$imgSrc= '/wp-content/plugins/ironplacecatalog/assets/ironplacecatalog-logo.png';
        ?>
        <div class="wrap">
            <h1>IronSky Config</h1>
			<img src="<?php echo $imgSrc;?>"/>
            <form action="options.php" method="post">
                <?php
                // Opciones de seguridad, campos, etc.
                settings_fields('ironplacecatalog-settings');
                do_settings_sections('ironplacecatalog-settings');
                submit_button('Save');
                ?>
            </form>
        </div>
        <?php
    }
    
    function ironplacecatalog_register_settings() {
        // Registro de la configuración para Mapbox API Key
        register_setting('ironplacecatalog-settings', 'mapbox_api_key');
        register_setting('ironplacecatalog-settings', 'googlw_place_api_key');

        // Registro de la configuración para ancho
        register_setting('ironplacecatalog-settings', 'map_width');
        // Registro de la configuración para alto
        register_setting('ironplacecatalog-settings', 'map_height');
        // Registro de la configuración para zoom
        register_setting('ironplacecatalog-settings', 'map_zoom');
        /*
        // Registro de la configuración para pitch
        register_setting('ironplacecatalog-settings', 'map_pitch');
        // Registro de la configuración para lat
        register_setting('ironplacecatalog-settings', 'map_center_lat');
        // Registro de la configuración para lon
        register_setting('ironplacecatalog-settings', 'map_center_lon');
        */
        // sección de configuración
        add_settings_section(
            'ironplacecatalog_settings_section',
            'API key & map settings',
            'ironplacecatalog_settings_section_callback',
            'ironplacecatalog-settings'
        );
 // googleplacea API Key
        add_settings_field(
            'googlw_place_api_key_field',
            'Google Place API Key',
            'googlw_place_api_key_field_callback',
            'ironplacecatalog-settings',
            'ironplacecatalog_settings_section'
        );
    
        // Mapbox API Key
        add_settings_field(
            'mapbox_api_key_field',
            'Mapbox API Key',
            'imapbox_api_key_field_callback',
            'ironplacecatalog-settings',
            'ironplacecatalog_settings_section'
        );
        // Map width
        add_settings_field(
            'map_width_field',
            'Map Width (px), default (leave empty) is 300',
            'imap_width_field_callback',
            'ironplacecatalog-settings',
            'ironplacecatalog_settings_section'
        );
        // Map height
        add_settings_field(
            'map_height_field',
            'Map Height (px), default (leave empty) is 300',
            'imap_height_field_callback',
            'ironplacecatalog-settings',
            'ironplacecatalog_settings_section'
        );
        // Map zoom
        add_settings_field(
            'map_zoom_field',
            'Map Zoom (1-16), default (leave empty) is 1',
            'imap_zoom_field_callback',
            'ironplacecatalog-settings',
            'ironplacecatalog_settings_section'
        );
    }

    add_action('admin_init', 'ironplacecatalog_register_settings');

    function ironplacecatalog_settings_section_callback() {
        echo '<p>Edit IronPlaceCatalog settings.</p>
			  <p>Get free apikey from mapbox: <a href="https://account.mapbox.com/">https://account.mapbox.com/</a></p>';
    }

    function googlw_place_api_key_field_callback() {
 
        // Obtener el valor de Mapbox API Key
        $googlw_place_api_key = get_option('googlw_place_api_key');
        echo '<input type="text" name="googlw_place_api_key" value="' . esc_attr($googlw_place_api_key) . '">';
    }
    
    
    function imapbox_api_key_field_callback() {
 
        // Obtener el valor de Mapbox API Key
        $mapbox_api_key = get_option('mapbox_api_key');
        echo '<input type="text" name="mapbox_api_key" value="' . esc_attr($mapbox_api_key) . '">';
    }
    
    function imap_width_field_callback() {
 
        // Obtener el valor de map_width_field
        $map_width = get_option('map_width');
        echo '<input type="text" name="map_width" value="' . esc_attr($map_width) . '">';
    }
    
    function imap_height_field_callback() {
 
        // Obtener el valor de map_height_field
        $map_height = get_option('map_height');
        echo '<input type="text" name="map_height" value="' . esc_attr($map_height) . '">';
    }
    
    function imap_zoom_field_callback() {
 
        // Obtener el valor de map_height_field
        $map_zoom = get_option('map_zoom');
        echo '<input type="text" name="map_zoom" value="' . esc_attr($map_zoom) . '">';
    }
?>