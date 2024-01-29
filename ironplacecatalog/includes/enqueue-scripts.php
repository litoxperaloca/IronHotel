<?php
    //agrego dependencias cexternas (js y css)

    function ironplacecatalog_enqueue_scripts() {
        wp_enqueue_script('jquery');
        //js de mapbox
        wp_enqueue_script('mapbox-gl-js', 'https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.js', array(), null, false);
        //css mapbox
        wp_enqueue_style('mapbox-gl-css', 'https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.css', array(), null);
        
        //wp_enqueue_script('mapbox-gl-directions-js', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.2.0/mapbox-gl-directions.js', array(), null, false);
        //wp_enqueue_style('mapbox-gl-directions-css', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.2.0/mapbox-gl-directions.css', array(), null);
        wp_enqueue_script('iron-hotel-widget-country-list-js', plugin_dir_url(__FILE__) .'js/IronHotelWidgetCountryList.js', array(), null, false);

        wp_enqueue_style('iron-hotel-widget-css', plugin_dir_url(__FILE__) . 'css/IronHotelWidget.css');

    }
    //js y css necesarios
    add_action('wp_enqueue_scripts', 'ironplacecatalog_enqueue_scripts');
?>