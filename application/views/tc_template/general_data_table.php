<!-- <section class="wrapper"> -->
<?php
$tc_array = array('tc', 'tipo_comprobante', 'tc_tesis');
//Agrega cuerpo de la tabla
//pr($datos_actividad_docente);
$controlador = $this->uri->rsegment(1);
$ruta_eliminar_registro = '/' . $controlador . '/elimina_censo/';
$ruta_vista_detalle = '/' . $this->uri->rsegment(1) . '/ver_detalle_registro_censo/';
$ruta_editar_registro = '/' . $this->uri->rsegment(1) . '/carga_actividad';
$update_tabla = 'data-updatetabla="' . '/' . $this->uri->rsegment(1) . '/actualiza_tabla"';
$this->load->config('general');
$propiedades_validacion_registro = $this->config->item('propiedades_validacion_registro'); //Carga propiedades de validación del registro
//pr($datos_actividad_docente);
?>



<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered table-hover dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="datatable_info" style="width: 100%;">
        <thead >
            <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="" style="width: 50px;"><?php echo $string_value['th_estado_validacion']; ?></th>
                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="" ><?php echo $string_value['th_elemento_seccion']; ?></th>
                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="" ><?php echo $string_value['th_folio']; ?></th>
                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="" ><?php echo $string_value['th_tipo_comprobante']; ?></th>
                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="" ><?php echo $string_value['th_acciones']; ?></th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (isset($datos_actividad_docente)) {
                foreach ($datos_actividad_docente as $value) {


                    $id_censo = encrypt_base64($value['id_censo']);
                    $ruta_file = str_replace('.', '', $value['ruta']);
                    $ruta_base_comprobante = base_url($ruta_file) . $value["nombre_fisico"] . '.pdf';
                    $tipo_comprobante_text = '';
                    foreach ($tc_array as $tc) {
                        if (isset($value[$tc])) {
                            $tipo_comprobante_text = $value[$tc];
                            break;
                        }
                    }
                    $link_ver_comprobate = '<a class="opcion" href="' . $ruta_base_comprobante . '"'
                            . 'onclick="window.open(\'' . $ruta_base_comprobante . '\', \'_blank\');'
                            . 'return false;">'
                            . '<span class="fa fa-file fa-size" > </span>'
                            . '</a>';
                    if (is_bool($value['is_carga_sistema']) === TRUE && !empty($value['is_carga_sistema'])) {
                        //NO SE PUEDE BORRAR
                        $link_editar = '';
                        $link_eliminar = '';
                    } else {
                        if ($value['id_validacion_registro'] != En_estado_validacion_registro::EVALUADO) {
                            // SE PUEDE BORRAR
//                  pr($ruta_editar_registro);
                            $link_editar = '<a class="opcion" href="#"'
                                    . 'onclick="cargar_actividad(this);"'
                                    . 'data-censo="' . $id_censo . '"'
                                    . 'data-rutaeditar="' . $ruta_editar_registro . '"'
                                    . '>'
                                    . '<span data-tip="tip-2" class="fa-size tip fa fa-pencil"></span>'
                                    . '</a>';
                            $link_eliminar = '<a class="opcion" href="#"'
                                    . 'onclick="drop_censo(this);"'
                                    . 'data-censo="' . $id_censo . '"'
                                    . 'data-ruta="' . $ruta_eliminar_registro . '"'
                                    . $update_tabla
                                    . '>'
                                    . '<span class="fa-size fa fa-remove" title="" placeholder="Eliminar registro"> </span>'
                                    . '</a>';
                        } else {
                            //NO se puede eliminar
                            $link_editar = '';
                            $link_eliminar = '';
                        }
                    }



                    $link_ver_detalle = '<a class="opcion" data-toggle="modal" data-target="#my_modal"'
                            . 'onclick="detalle_registro(this);"'
                            . 'data-censo="' . $id_censo . '"'
                            . 'data-ruta="' . $ruta_vista_detalle . '" >'
                            . '<span class="fa-size fa fa-eye" title="" placeholder="Ver detalle"> </span>'
                            . '</a>';
                    $icon_validacion = $propiedades_validacion_registro[$value['id_validacion_registro']]; //Obtiene propiedades del estado  de la validación
                    $estado_validacion = '<span class = "fa fa-' . $icon_validacion['icon'] . '"'
                            . 'data-toggle="popover"'
                            . ' data-trigger="hover"'
                            . ' data-content=""'//Puede agregar texto con indicaciones del estado
                            . ' title="' . $value['nombre_validacion'] . '">';
                    ?>

                    <tr>
                        <td class="text-center"><?php echo $estado_validacion ?></td>
                        <td><?php echo $value['nom_elemento_seccion']; ?></td>
                        <td><?php echo $value['folio']; ?></td>
                        <td><?php echo $tipo_comprobante_text; ?></td>
                        <td>
                            <?php echo $link_ver_comprobate . $link_editar . $link_eliminar . $link_ver_detalle; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $('.tip').each(function () {
        $(this).tooltip(
                {
                    html: true,
                    title: $('#' + $(this).data('tip')).html()
                });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#info_imss").click(function () {
            $("#divimss").each(function () {
                displaying = $(this).css("display");
                if (displaying == "block") {
                    $(this).fadeOut('slow', function () {
                        $(this).css("display", "none");
                    });
                } else {
                    $(this).fadeIn('slow', function () {
                        $(this).css("display", "block");
                    });
                }
            });
        });
    });
</script>
