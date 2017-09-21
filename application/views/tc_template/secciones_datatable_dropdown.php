<?php
if (!empty($catalogo_secciones_actividad_docente)) {
    $controlador = '/' . $this->uri->rsegment(1) . '/actualiza_tabla/';
    $optiones = dropdown_options($catalogo_secciones_actividad_docente, 'id_elemento_seccion', 'label');
    echo $this->form_complete->create_element(
            array('id' => 'secciones_datatable', 'type' => 'dropdown',
                'options' => $optiones,
                'first' => array('' => 'Selecciona opción'),
                'value' => (isset($value_secciones)) ? $value_secciones : '',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-toggle' => '',
                    'onchange' => 'recarga_datatable(this);',
                    'data-placement' => 'top',
                    'title' => '',
                    'data-ruta' => $controlador,
                ),
            )
    );
} else {
    echo '';
}
?>

