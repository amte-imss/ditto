<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
?>
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>
<?php
echo js("rama_organica/listas.js");
echo js("docente/docente.js");
?>

<div id="page-inner">
    <div class="panel-heading">
        <h3 class="page-head-line">Registro de actividad docente</h3>
    </div>
    <div class="panel-body"></div>
    <div id="form_filtro">
        <div class="row" style="margin: 5px;">
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
                    <label for="area_enfoque">Tipo de alumno </label>
                    <div class=".col-5">
                        <select name="area_enfoque" id="area_enfoque" class="form-control"></select>
                    </div>
                </div>
                <!--<button type="submit" class="btn btn-primary" id="boton_filtro">Aplicar filtro</button>-->
            </form>
        </div>
        <br>
        <div class="row" style="margin: 5px;">
            <div class="form-group col-sm-8" id="ditto-config-columnas">
                <h4>Mostrar/Ocultar columnas</h4>
                <div class="config-panel">
                    <label><input class="ditto-column" data-id="nombre_completo" checked="" type="checkbox"> Nombre</label>
                    <label><input class="ditto-column" data-id="clave_unidad" checked="" type="checkbox"> Clave unidad</label>
                    <label><input class="ditto-column" data-id="unidad" checked="" type="checkbox"> Unidad</label>
                    <label><input class="ditto-column" data-id="clave_categoria" checked="" type="checkbox"> Clave categoría</label>
                    <label><input class="ditto-column" data-id="categoria" checked="" type="checkbox"> Categoría</label>                
                </div>
            </div>
                        <div id="jsGrid_exportar" class="col-sm-2 col-lg-offset-2">
                            <i class="fa fa-question-circle sipimss-helper" data-help="exportar"></i>
                            <button id="js_grid_exportar" name="exportar" type="button" class="btn btn-lg btnverde">
                                Exportar a Excel
                            </button>
                        </div>
<!--            <div  class="col-sm-12 col-md-12 text-right">
                <h4>
                    <a href="<?php echo site_url('/docente/exportar_datos/'); ?>">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i></a> Totales de registros
                </h4>
                <div id="jsGrid2"></div>
            </div>-->
        </div>
    </div>
    <div id="jsGrid"></div>
</div>