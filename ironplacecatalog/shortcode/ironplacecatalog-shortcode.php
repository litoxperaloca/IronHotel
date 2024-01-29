<?php
	//Creo shortcode [ironplacecatalog]
    function ironplacecatalog_shortcode($atts) {
        // Guardo la salida del widget en un búfer y retorno
        ob_start();
        the_widget('IronPlaceCatalog_Widget'); 
        $widget_output = ob_get_clean();
        return $widget_output;
    }
    
    function ironplacecatalog_register_shortcodes() {
        add_shortcode('ironplacecatalog', 'ironplacecatalog_shortcode');
    }

    add_action('init', 'ironplacecatalog_register_shortcodes');
?>