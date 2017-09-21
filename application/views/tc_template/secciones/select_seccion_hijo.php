
<?php
$nivel;
$ruta = '/' . $this->uri->rsegment(1) . '/carga_elemento_seccion/';
$atributos = array(
    'name' => 'n_1',
    'class' => 'form-control',
    'placeholder' => '',
    'data-nivel' => $nivel,
    'data-toggle' => '',
    'data-placement' => 'top',
    'data-nameselect' => 'n_' . $nivel,
    'data-ruta' => $ruta,
    'title' => 'sub seccines',
    'onchange' => 'carga_hijo_elemento_seccion(this);',
);
echo $this->form_complete->create_element(array('id' => 'n_' . $nivel,
    'type' => 'dropdown',
    'first' => array('' => 'Selecciona opción'),
    'options' => $opciones_select,
    'value' => '',
    'attributes' => $atributos,
));
?>
