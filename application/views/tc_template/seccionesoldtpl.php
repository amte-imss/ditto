<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($titulo_seccion);
//echo js('docente/formacion_docente/formacion_docente.js');
?>

<?php echo css('template_sipimss/campos_obligatorios.css');//Asterisco en color rojito ?>

<section id="main-content">
    <div class="col-md-12 col-sm-12 col-xs-12 " id='div_error' style='display:none'>
        <div id='mensaje_error_div' class='alert alert-info' >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span id='mensaje_error'></span>
        </div>
    </div>
<!-- <section class="wrapper"> -->
    <?php // if (!is_null($titulo_seccion)) {//Pinta sección ?>
    <!--<h3>-->
    <?php // echo $titulo_seccion; ?>
    <!--</h3>-->
    <?php // } ?>
    <!-- BASIC FORM ELELEMENTS -->
    <div class="row mt">
        <div class="col-lg-12">
            <div class="content-panel">
                <?php if (!is_null($titulo_seccion)) {//Pinta sección ?>
                    <h3>
                        <?php echo $titulo_seccion; ?>
                    </h3>
                <?php } ?>
                <?php if (!is_null($boton_agregar)) {//Pinta sección ?>
                    <div class="">
                        <div class="col-sm-10">
                        </div>
                        <div class="col-sm-2">
                            <?php echo $boton_agregar; ?>
                        </div>
                    </div>
                <?php } ?>
                <br><br>
                <?php if (!is_null($ruta_accion_boton_agregar)) { ?>
                    <script src="<?php echo base_url($ruta_accion_boton_agregar); ?>"></script>
                <?php } ?>
                <div class="form-inline" role="form" id="seccion_seccion">
                    <?php if (!is_null($seccion)) {//Pinta sección ?>
                        <?php echo $seccion; ?>
                    <?php } ?>
                </div>
                <br>

                <div class="form-inline" role="form" id="seccion_formulario">
                    <?php if (!is_null($formulario)) { //Pinta formulario?>
                        <?php echo $formulario; ?>
                    <?php } ?>
                </div>

                <div id="seccion_tabla" >
                    <?php if (!is_null($tabla)) { //Pinta tabla?>
                        <?php echo $tabla; ?>
                    <?php } ?>
                </div>
            </div>
        </div><!-- col-lg-12-->
    </div><!-- /row -->

    <!-- /MAIN CONTENT -->

</section>


<script>
//custom select box

    $(function () {
//        $('select.styled').customSelect();
    });

</script>
