<!-- <section class="wrapper"> -->
<?php
//Agrega cuerpo de la tabla
//pr($datos_actividad_docente);
$controlador = $this->uri->rsegment(1);
$ruta_eliminar_registro = '/' . $controlador . '/elimina_censo/';
$ruta_vista_detalle = '/' . $this->uri->rsegment(1) . '/ver_detalle_registro_censo/';
$ruta_editar_registro = '/' . $this->uri->rsegment(1) . '/carga_actividad';
$update_tabla = 'data-updatetabla="' . '/' . $this->uri->rsegment(1) . '/actualiza_tabla"';
$this->load->config('general');
$propiedades_validacion_registro = $this->config->item('propiedades_validacion_registro'); //Carga propiedades de validación del registro
//pr($campos_mostrar_datatable);
//pr($datos_actividad_docente);
?>
<?php
//Crear columnas dinamicas para mostrar en tabla
$column_dinamicas = '';
foreach ($campos_mostrar_datatable as $key => $value) {
    $column_dinamicas .= '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" '
            . 'colspan="1" aria-label="">' . $value['label'] . '</th>';
}
?>

<!-- <div class="col-sm-6">
    <div id="datatable_filter" class="dataTables_filter">
        <label>Buscar:</label>
        <input type="search" class="form-control input-sm" placeholder="" aria-controls="datatable">

    </div>
</div> -->

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered table-hover dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="datatable_info" style="width: 100%;">
        <thead >
            <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="" style="width: 30px;"><?php echo $string_value['th_estado_validacion']; ?></th>
                <?php echo $column_dinamicas; //Imprime las columnas dinamicas de la tabla ?>
                <th class="sorting" tabindex="2" aria-controls="datatable" rowspan="1" colspan="1" aria-label=""><?php echo $string_value['th_folio']; ?></th>
                <th class="sorting" tabindex="4" aria-controls="datatable" rowspan="1" colspan="1" aria-label="" style="width: 30px;"><?php echo $string_value['th_acciones']; ?></th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($datos_actividad_docente as $value) {


                $id_censo = encrypt_base64($value['id_censo']);
                $ruta_file = str_replace('.', '', $value['ruta']);
                $ruta_base_comprobante = base_url($ruta_file) . $value["nombre_fisico"] . '.pdf';
                $link_ver_comprobate = '<a class="opcion" href="' . $ruta_base_comprobante . '"'
                        . 'onclick="window.open(\'' . $ruta_base_comprobante . '\', \'_blank\');'
                        . 'return false;">'
                        . '<span class="fa fa-file" > </span>'
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
                                . '<span data-tip="tip-2" class="tip glyphicon glyphicon-pencil"></span>'
                                . '</a>';
                        $link_eliminar = '<a class="opcion" href="#"'
                                . 'onclick="drop_censo(this);"'
                                . 'data-censo="' . $id_censo . '"'
                                . 'data-ruta="' . $ruta_eliminar_registro . '"'
                                . $update_tabla
                                . '>'
                                . '<span class="fa fa-remove" title="" placeholder="Eliminar registro"> </span>'
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
                        . '<span class="fa fa-eye" title="" placeholder="Ver detalle"> </span>'
                        . '</a>';
                $icon_validacion = $propiedades_validacion_registro[$value['id_validacion_registro']]; //Obtiene propiedades del estado  de la validación
                $estado_validacion = '<span class = "fa fa-' . $icon_validacion['icon'] . '"'
                        . 'data-toggle="popover"'
                        . ' data-trigger="hover"'
                        . ' data-content=""'//Puede agregar texto con indicaciones del estado
                        . ' title="' . $value['nombre_validacion'] . '">';
                $column_dinamicas = '';
//                pr($value);
                foreach ($campos_mostrar_datatable as $key_dinamicos => $value_dinamicos) {
                    if (isset($value[$key_dinamicos]) and $value[$key_dinamicos] != 'NULL') {
//                        pr($value_dinamicos['nom_tipo_campo']);
                        switch ($value_dinamicos['nom_tipo_campo']) {
                            case 'file'://Aplica iconos de ver y descargar para el tipo file
                                $file = encrypt_base64($value[$key_dinamicos]);
                                $column_dinamicas .= '<td><a href="' . site_url($controlador . '/ver_archivo/' . $file) . '" target="_blank"><span class="fa fa-search"></span> ' . $string_value['ver_archivo'] . '</a><br>'
                                        . '<a href="' . site_url($controlador . '/descarga_archivo/' . $file) . '" target="_blank"><span class="fa fa-download"></span> ' . $string_value['descargar_archivo'] . '</a>'
                                        . '</td>';
                                break;
                            case 'date'://Aplica iconos de ver y descargar para el tipo file
                                $column_dinamicas .= '<td>' . get_date_formato($value[$key_dinamicos]) . '</td>';
//                                $column_dinamicas .= '<td>' . time($value[$key_dinamicos]) . '</td>';
                                break;
                            default :
                                $column_dinamicas .= '<td>' . $value[$key_dinamicos] . '</td>';
                        }
                    } else {
                        $column_dinamicas .= '<td></td>';
                    }
                }
                ?>

                <tr>
                    <td class="text-center"><?php echo $estado_validacion ?></td>
                    <?php echo $column_dinamicas; ?>
                    <td><?php echo $value['folio']; ?></td>
                    <td>
                        <?php echo $link_ver_comprobate . $link_editar . $link_eliminar . $link_ver_detalle; ?>
                    </td>
                </tr>
                <?php
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
