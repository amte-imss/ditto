<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
//pr($delegaciones);
$todas = [];
$todas[0] = array('clave_delegacional' => '', 'nombre' => 'TODAS');
$delegaciones = $todas + $delegaciones;
//pr($delegaciones);
?>
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

<div id="page-inner">
    <div class="col-sm-12"><h1 class="page-head-line">Tablero de seguimiento</h1></div>   
    <div class="col-md-4 col-sm-4 text-center">
        <label><h4><?php echo $reporte['total']; ?> Profesores almacenados</h4></label>
    </div>
    <div class="col-md-4 col-sm-4 text-center">
        <label><h4><?php echo count($reporte['unidades']); ?> Unidades participantes</h4></label>
    </div><br>
    <div class="col-md-4 col-sm-4 text-center">
        <label><h4><?php echo $reporte['cursos']; ?> Cursos registrados</h4></label>
    </div><br>
    <div class="col-sm-12">        
        <div class="col-md-6 col-sm-6">
            <h4><a href="<?php echo site_url('reporte/nivel_central/delegacion'); ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a> Totales por delegación</h4>
            <div id="jsGrid"></div>
        </div>
        <div class="col-md-6 col-sm-6">
            <h4><a href="<?php echo site_url('reporte/nivel_central/unidad'); ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a> Totales por unidad</h4>
            <div id="jsGrid2"></div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <script>
            $(function () {
                var reporte_unidades = <?php echo json_encode($reporte['unidades']); ?>;
                var reporte_delegaciones = <?php echo json_encode($reporte['delegaciones']); ?>;
                var delegaciones = <?php echo json_encode($delegaciones); ?>;
                $("#jsGrid").jsGrid({
                    height: "600px",
                    width: "100%",
                    pagerFormat: "Paginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
                    pagePrevText: "Anterior",
                    pageNextText: "Siguiente",
                    pageFirstText: "Primero",
                    pageLastText: "Último",
                    pageNavigatorNextText: "...",
                    pageNavigatorPrevText: "...",
                    noDataContent: "No se encontraron datos",
                    invalidMessage: "",
                    loadMessage: "Por favor espere",
                    filtering: true,
                    sorting: true,
                    autoload: true,
                    paging: true,
                    data: reporte_delegaciones,
                    controller: {
                        loadData: function (filter) {
                            return $.grep(reporte_delegaciones, function (reporte) {
                                return (!filter.clave_delegacion || reporte.clave_delegacion === filter.clave_delegacion);
                            });
                        },
                    },
                    fields: [
                        {name: "clave_delegacion", type: "select", items: delegaciones, valueField: "clave_delegacional", textField: "nombre", title: "Delegación"},
                        {name: "cantidad", type: "number", width: 50, title: "Número de profesores almacenados", filtering: false},
                    ],
                });
                $("#jsGrid2").jsGrid({
                    height: "600px",
                    width: "100%",
                    pagerFormat: "Paginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
                    pagePrevText: "Anterior",
                    pageNextText: "Siguiente",
                    pageFirstText: "Primero",
                    pageLastText: "Último",
                    pageNavigatorNextText: "...",
                    pageNavigatorPrevText: "...",
                    noDataContent: "No se encontraron datos",
                    invalidMessage: "",
                    loadMessage: "Por favor espere",
                    filtering: true,
                    editing: false,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    pageSize: 15,
                    pageButtonCount: 5,
                    data: reporte_unidades,
                    controller: {
                        loadData: function (filter) {
                            return $.grep(reporte_unidades, function (reporte) {
                                return  (!filter.unidad || reporte.unidad.indexOf(filter.unidad) > -1)
                                        && (!filter.clave_delegacion || reporte.clave_delegacion === filter.clave_delegacion);
                            });
                        },
                    },
                    fields: [
                        {name: "clave_delegacion", type: "select", items: delegaciones, valueField: "clave_delegacional", textField: "nombre", title: "Delegación"},
                        {name: "unidad", type: "text", width: 200, title: "Unidad"},
                        {name: "cantidad", type: "number", width: 50, title: "Número de profesores almacenados", filtering: false}
                    ]
                });

                $(".config-panel input[type=checkbox]").on("click", function () {
                    var $cb = $(this);
                    $("#jsGrid").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
                });
            });
        </script>
    </diV>
</div>