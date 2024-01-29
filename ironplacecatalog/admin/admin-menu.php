<?php
	//Admin menu para settings
    function ironplacecatalog_add_admin_menu() {
        add_menu_page(
            'IronHotel Config',   // Título de la página
            'IronHotel',                    // Título del menú
            'manage_options',             // Capacidad requerida para ver este menú
            'ironplacecatalog-settings',           // Slug del menú
            'ironplacecatalog_settings_page',      // Función que renderiza la página de opciones
            'dashicons-admin-site-alt3',  // Icono del menú
            6                             // Posición en el menú
        );
    }

    add_action('admin_menu', 'ironplacecatalog_add_admin_menu');
?>