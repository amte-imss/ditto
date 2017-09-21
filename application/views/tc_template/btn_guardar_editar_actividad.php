<?php
$id_censo_data = '';
$string_value = get_elementos_lenguaje(array(En_catalogo_textos::GENERAL));
$titulo = $string_value['guardar'];
$controlador = '/' . $this->uri->rsegment(1);
$evento = ' onclick="funcion_guardar_actividad(this);"';
$tmp_actualiza = '/datos_actividad_actualiza';
$update_tabla = 'data-updatetabla="' . $controlador . '/actualiza_tabla"';
if (isset($censo_regstro) and ! is_null($censo_regstro)) {
//    $id_censo_data = ' data-censo="' . $censo_regstro . '"';
    $evento = ' onclick="funcion_actualizar_actividad(this);"';
    $titulo = $string_value['actualizar'];
    $tmp_actualiza = '/editar_actividad'; //Otra ruta para actualizar datos
}

if (!isset($ruta_controller)) {//Si no existe la ruta del controlador, la sustituye por las default
    $ruta_controller = $controlador . $tmp_actualiza;
}
if (!is_null($ruta_controller)) {//Aplica la ruta del controlador
//    echo $this->form_complete->create_element(array('id' => 'ruta_controller', 'type' => 'hidden', 'value' => $ruta_controller));
}
?>


<button name="guardar_actividad" type="button" id="guardar_actividad" value="Guardar"
        class="btn btn-tpl  btn" placeholder="" data-toggle="" data-placement="top" title="<?php echo $titulo; ?>"
        <?php echo $update_tabla; ?>
        data-formularioid="form_actividad_<?php echo $formulario; ?>" <?php echo $evento; ?>
        data-ruta="<?php echo $ruta_controller; ?>"
        >
            <?php echo $titulo; ?>
</button>
