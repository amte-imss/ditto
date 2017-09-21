<?php
$evento = '';
if (isset($tipo_evento_js) and ! is_null($tipo_evento_js) and isset($funcion_js) and ! is_null($funcion_js)) {
    $evento = $tipo_evento_js . ' = ' . $funcion_js;
}
$ruta = '/' . $this->uri->rsegment(1) . '/carga_seccion/';
//pr($seccion);
$text_seccion = '';
if (isset($seccion)) {
    $text_seccion = 'data-seccion="' . encrypt_base64($seccion) . '"';
}
?>

<button  name="save" type="button" class="btn btn-lg btnverde" <?php echo $evento; ?>
        data-ruta="<?php echo $ruta; ?>"
        <?php echo $text_seccion; ?>
        >
    <span><i class="fa fa-plus"></i></span>
        <?php echo $titulo; ?>
</button>
