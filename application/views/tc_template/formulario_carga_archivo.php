<?php
///////////////////Inicio carga de archivo
$string_values = get_elementos_lenguaje(array(En_catalogo_textos::COMPROBANTE));
$controlador = $this->uri->rsegment(1);
?>

<style type="text/css">
    .button-padding {padding-top: 30px}
    .rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding-left:20px; padding-bottom: 20px;}
</style>
<script type='text/javascript' src="<?php echo base_url('assets/js/template_sipimss/file-browse.js'); ?>"></script>

<div id="" class="row">
    <div class="col-md-6">
        <label for='' class="control-label pull-left">
            <b class="rojo">*</b><?php echo $string_values['lbl_texto_folio']; ?>
        </label>
        <div class="input-group">
            <div class="input-group-btn">
                <button type="button" aria-expanded="false" class="btn">
                    <span aria-hidden="true" class="fa fa-folder"> </span>
                </button>
            </div>
            <?php
            echo $this->form_complete->create_element(
                    array('id' => 'folio_comprobante', 'type' => 'text',
                        'value' => isset($folio) ? $folio : '',
                        'attributes' => array(
                            'class' => 'form-control',
                            'placeholder' => $string_values['lbl_texto_folio'],
                            'min' => '0',
                            'max' => '100',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => $string_values['lbl_texto_folio'],
                        )
                    )
            );
            ?>
        </div>
        <?php echo form_error_format('folio_comprobante'); ?>
    </div>
    <div class="col-md-6" id="capa_carga_archivo">
      <label for='lbl_comprobante' class="control-label pull-left">
          <b class="rojo">*</b><?php echo $string_values['lbl_texto_comprobante']; ?>
      </label>
        <?php
        echo $this->form_complete->create_element(array('id' => 'userfile', 'type' => 'upload', 'attributes' => array(
                'class' => 'file',
                'accept' => 'application/pdf',
                'autocomplete' => 'off'
        )));
        echo $this->form_complete->create_element(array('id' => 'extension', 'type' => 'hidden', 'value' => (isset($nombre_extencion) ? $nombre_extencion : 'pdf')));
        ?>

          <!-- <span  display="none" class="input-group-addon" data-toggle="popover" title="Ayuda" data-content="Todo tipo de documento que usted desee subir como evidencia, debe ser escaneado y guardar en formato PDF. Puede checar el tutorial.">
        <span class="fa fa-question-circle-o"> </span>
        </span> -->


        <div class="input-group" style="display:none;">

            <?php
            echo $this->form_complete->create_element(
                    array('id' => 'comprobante', 'type' => 'text',
                        'value' => isset($nombre_comprobante) ? $nombre_comprobante : '',
                        'attributes' => array(
                            'class' => 'form-control',
                            'placeholder' => $string_values['lbl_texto_comprobante'],
                            'min' => '0',
                            'max' => '100',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => $string_values['lbl_texto_comprobante'],
                            'readonly' => 'readonly',

                        )
                    )
            );
            ?>
        </div>
        <div class="col-lg-8 col-md-12" id="capa_archivo_cargado">
            <?php
            if (isset($id_censo) || !empty($id_censo)) { //En caso de tener asociado archivo, se muestra link
                $file = (isset($id_file)) ? encrypt_base64($id_file) : '';
                echo $this->form_complete->create_element(array('id' => 'id_file_comprobante', 'type' => 'hidden', 'value' => $file));
                echo '<a href="' . site_url($controlador . '/ver_archivo/' . $file) . '" target="_blank"><span class="fa fa-search"></span> ' . $string_values['ver_archivo'] . '</a><br>';
                echo '<a href="' . site_url($controlador . '/descarga_archivo/' . $file) . '" target="_blank"><span class="fa fa-download"></span> ' . $string_values['descargar_archivo'] . '</a>';
//                echo $this->form_complete->create_element(array('id' => 'idc', 'type' => 'hidden', 'value' => $file));
            }
            ?>
        </div>
        <?php echo form_error_format('comprobante'); ?>
    </div>
    <div id="error_carga_archivo"></div>
</div>
<?php
///////////////////////Fin carga de archivo ?>
