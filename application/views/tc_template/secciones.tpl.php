<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($titulo_seccion);
//echo js('docente/formacion_docente/formacion_docente.js');
?>

<?php echo css('template_sipimss/campos_obligatorios.css'); //Asterisco en color rojito ?>

<style media="screen">
    label {
        display: block;
        text-align: right;
    }
</style>

<div class="col-md-12" id='div_error' style='display:none'>
    <div id='mensaje_error_div' class='alert alert-info' >
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span id='mensaje_error'></span>
    </div>
</div>
<div id="main_content" class="">
    <!-- <div id="page-wrapper" class="page-wrapper-cls"> -->
    <div id="page-inner">
        <div  class="row">

            <div class="col-md-12">
                <?php if (!is_null($titulo_seccion)) {//Pinta sección ?>
                    <h1 class="page-head-line">
                        <?php echo $titulo_seccion; ?>
                    </h1>
                <?php } ?>
            </div>


            <div class="col-md-12">

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
                <div class="col-md-12 form-inline" role="form" id="seccion_seccion">
                    <?php if (!is_null($seccion)) {//Pinta sección ?>
                        <?php echo $seccion; ?>
                    <?php } ?>
                </div>
                <br>
                
                <link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
                <link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
                <script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>
                
                <div class="col-md-12 form-inline" role="form" id="seccion_formulario">
                    <?php if (!is_null($formulario)) { //Pinta formulario?>
                        <?php echo $formulario; ?>
                    <?php } ?>
                </div>

                <div class="col-md-12" id="seccion_tabla" >
                    <?php if (!is_null($tabla)) { //Pinta tabla?>
                        <?php echo $tabla; ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <a class="link" href="#" data-rel="content1">Link 3</a>
<a class="link" href="#" data-rel="content2">Link 4</a>
<a class="link" href="#" data-rel="content3">Link 5</a>
<a class="link" href="#" data-rel="content4">Link 6</a>
<a class="link" href="#" data-rel="content5">Link 7</a>

<div class="content-container">
    <div id="content3">This is the test content for part 3</div>
    <div id="content4">This is the test content for part 4</div>
    <div id="content5">This is the test content for part 5</div>
    <div id="content6">This is the test content for part 6</div>
    <div id="content7">This is the test content for part 7</div>
</div>
<script type="text/javascript">
$(".link").click(function(e) {
    e.preventDefault();
    $('.content-container div').fadeOut('slow');
    $('#' + $(this).data('rel')).fadeIn('slow');
});

</script> -->
<!-- /. WRAPPER  -->


<script type="text/javascript">

    $('.tip').each(function () {
        $(this).tooltip(
                {
                    html: true,
                    title: $('#' + $(this).data('tip')).html()
                });
    });
</script>
