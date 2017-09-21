<!--<link rel="stylesheet" type="text/css" href="http://11.32.41.238:9000/jsgrid-1.5.3/css/jsgrid.css" />
<link rel="stylesheet" type="text/css" href="http://11.32.41.238:9000/jsgrid-1.5.3/css/theme.css" />

 script src="http://11.32.41.238:9000/jsgrid-1.5.3/external/jquery/jquery-1.8.3.js"></script 

<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.core.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.load-indicator.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.load-strategies.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.sort-strategies.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.field.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.text.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.number.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.select.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.checkbox.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.control.js"></script>-->

<!--<script src="http://11.32.41.238:9000/jsgrid-1.5.3/demos/db.js"></script>-->
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>

<style>
    .config-panel {
        padding: 10px;
        margin: 10px 0;
        background: #fcfcfc;
        border: 1px solid #e9e9e9;
        display: inline-block;
    }

    .config-panel label {
        margin-right: 10px;
    }
    #page-inner{
        min-height: 1250px !important;
    }
</style>

<?php
echo js("rama_organica/listas.js");
echo js("reporte/reporte_n1.js");
?>

<div id="page-inner">
    <div class="panel-heading">
        <h1 class="page-head-line">Tablero de seguimiento
        </h1>
        <div class="col-md-12 col-sm-12 ">
            <label><h4><?php echo $total_cursos_unidad; ?> Profesores almacenados</h4></label>
        </div>
    </div>
    <div id="form_filtro">
        <br>
        <form class="form-inline">
            <div class="form-group tipo_actividad_class col-sm-4">
                <i class="fa fa-question-circle sipimss-helper" data-help="tipo_actividad"></i>
                <label for="tipo_actividad">Tipo de actividad </label>
                <div class=".col-5">
                    <select name="tipo_actividad" id="tipo_actividad" class="form-control"></select>
                </div>
            </div>
            <div class="form-group modalidad_class col-sm-4">
                <i class="fa fa-question-circle sipimss-helper" data-help="modalidad"></i>
                <label for="modalidad">Modalidad </label>
                <div class=".col-5">
                    <select name="modalidad" id="modalidad" class="form-control"></select>
                </div>
            </div>
            <div class="form-group area_enfoque_class col-sm-4">
                <i class="fa fa-question-circle sipimss-helper" data-help="area_enfoque"></i>
                <label for="area_enfoque">Tipo de alumno</label>
                <div class=".col-5">
                    <select name="area_enfoque" id="area_enfoque" class="form-control"></select>
                </div>
            </div>
            <!--<button type="submit" class="btn btn-primary" id="boton_filtro">Aplicar filtro</button>-->
        </form>
    </div>

    <br>
    <br>
    <div  class="col-sm-12 col-md-12 text-right">
        <h4>
            <a href="<?php echo site_url('/reporte/exportar_datos_detalle_cursos_registros/'); ?>">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i></a> Totales de registros por curso
        </h4>
        <div id="jsGrid2"></div>
    </div>
    <div class="col-sm-12">        
        <div id="jsGridUnidad"></div>
        <div style="clear:both;"></div>
        <br>
    </diV>

</div>
