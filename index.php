<?php
/*
Plugin Name: Cupos Packs
Description:  Plugin personalizado favric
Version: 1.0.0
*/

function Activar(){

}

function Desactivar(){
    flush_rewrite_rules();
}

register_activation_hook(__FILE__,'Activar');
register_deactivation_hook(__FILE__,'Desactivar');

add_action('admin_menu','CreateMenu');

function CreateMenu(){
    add_menu_page(
	'Cupos Packs',
	'Cupos Packs',
	'manage_options',
	'sp_menu',
	'ShowContent',
	plugin_dir_url(__FILE__).'img/icon.png',
	1
    );
}

function ShowContent(){
    echo "<h1> Contenido del plugin </h1>";
    echo '<form method="post" action="">';
    echo '<input type="submit" name="btn_show_appointments" value="Mostrar Datos">';
    echo '<input type="submit" name="btn_validate_before_cart" value="Validar Disponibilidad">';
    echo '</form>';

    if (isset($_POST['btn_show_appointments'])) {
        global $wpdb;
        $tabla = "{$wpdb->prefix}wc_appointments_availability";
        $query = "SELECT * FROM $tabla";
        $lista_encuestas = $wpdb->get_results($query, ARRAY_A);

        // Mostrar los datos, por ejemplo, en una tabla HTML
        echo '<h2>Datos de la Tabla wp_wc_appointments_availability</h2>';
        echo '<table>';
        echo '<tr><th>ID</th><th>Kind</th><th>Kind ID</th><th>Range Type</th><th>From Date</th><th>To Date</th><th>From Range</th><th>To Range</th><th>Appointable</th><th>Priority</th><th>Qty</th><th>Ordering</th></tr>';

        foreach ($lista_encuestas as $fila) {
            echo '<tr>';
            echo '<td>' . $fila['ID'] . '</td>';
            echo '<td>' . $fila['kind'] . '</td>';
            echo '<td>' . $fila['kind_id'] . '</td>';
            echo '<td>' . $fila['range_type'] . '</td>';
            echo '<td>' . $fila['from_date'] . '</td>';
            echo '<td>' . $fila['to_date'] . '</td>';
            echo '<td>' . $fila['from_range'] . '</td>';
            echo '<td>' . $fila['to_range'] . '</td>';
            echo '<td>' . $fila['appointable'] . '</td>';
            echo '<td>' . $fila['priority'] . '</td>';
            echo '<td>' . $fila['qty'] . '</td>';
            echo '<td>' . $fila['ordering'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }

    if (isset($_POST['btn_validate_before_cart'])) {
        add_filter('woocommerce_add_to_cart_validation', 'validar_disponibilidad_cupos', 1, 3);

        function validar_disponibilidad_cupos($passed, $product_id, $quantity) {
            echo '<h1>¡El hook se ha activado correctamente!</h1>';
            return $passed;
        }
    }
}