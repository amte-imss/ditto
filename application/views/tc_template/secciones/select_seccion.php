<div id="div_errores_tmp"></div>
<?php
$ruta = '/' . $this->uri->rsegment(1) . '/carga_elemento_seccion/';
$atributos = array('name' => 'n_1' ,
    'class' => 'form-control',
    'placeholder' => '',
    'data-toggle' => '',
    'data-placement' => 'top',
    'data-nameselect' => 'n_1',
    'data-nivel' => '1',
    'data-ruta' => $ruta,
    'title' => 'seccion',
    'onchange' => 'carga_hijo_elemento_seccion(this);',
);
echo $this->form_complete->create_element(array('id' => 'n_1',
    'type' => 'dropdown',
    'first' => array('' => 'Selecciona opción'),
    'options' => $opciones_select,
    'value' => '',
    'attributes' => $atributos,
));
?>
