<link rel="stylesheet" type="text/css" href="http://11.32.41.238:9000/jsgrid-1.5.3/css/jsgrid.css" />
<link rel="stylesheet" type="text/css" href="http://11.32.41.238:9000/jsgrid-1.5.3/css/theme.css" />

<!-- script src="http://11.32.41.238:9000/jsgrid-1.5.3/external/jquery/jquery-1.8.3.js"></script -->
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/demos/db.js"></script>

<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.core.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.load-indicator.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.load-strategies.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.sort-strategies.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/jsgrid.field.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.text.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.number.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.select.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.checkbox.js"></script>
<script src="http://11.32.41.238:9000/jsgrid-1.5.3/src/fields/jsgrid.field.control.js"></script>

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
        <!-- div class="config-panel">
            <label><input id="heading" type="checkbox" checked /> Heading</label>
            <label><input id="filtering" type="checkbox" checked /> Filtering</label>
            <label><input id="inserting" type="checkbox" /> Inserting</label>
            <label><input id="editing" type="checkbox" checked /> Editing</label>
            <label><input id="paging" type="checkbox" checked /> Paging</label>
            <label><input id="sorting" type="checkbox" checked /> Sorting</label>
            <label><input id="selecting" type="checkbox" checked /> Selecting</label>
        </div --> 
    <div class="col-sm-6 text-center">
        <button type="button" class="btn btn-info"><h4>4473 Registros almacenados</h4></button>
    </div>
    <div class="col-sm-6 text-center">
        <button type="button" class="btn btn-info"><h4>80 Unidades participantes</h4></button>
    </div><br>
    <div class="col-sm-12">        
        <h4>Totales por delegación</h4>
        <div id="jsGrid"></div>
        <h4>Totales por unidad</h4>
        <div id="jsGrid2"></div>
        <div style="clear:both;"></div>
        <br>
        <script>
            $(function() {
                $("#jsGrid").jsGrid({
                    height: "400px",
                    width: "100%",
                    sorting: true,
                    paging: true,
                    fields: [
                        { name: "Delegacion", type: "select", items: db.countries, valueField: "Id", textField: "Name", title: "Delegación"  },
                        //{ name: "Name", type: "text", width: 150 },
                        { name: "Age", type: "number", width: 50, title: "# de registros almacenados" },
                        //{ name: "Address", type: "text", width: 200 },
                        //{ name: "Married", type: "checkbox", title: "Is Married",  }
                    ],
                    data: db.delegaciones
                });
                $("#jsGrid2").jsGrid({
                    height: "600px",
                    width: "100%",
                    filtering: true,
                    editing: true,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    pageSize: 15,
                    pageButtonCount: 5,
                    controller: db,
                    fields: [
                        { name: "Delegacion", type: "select", items: db.countries, valueField: "Id", textField: "Name", title: "Delegación" },
                        { name: "Address", type: "text", width: 200, title: "Unidad" },
                        //{ name: "Fecha", width: 200, title: "Fecha de última actualización", filtering: false, sorttype: 'date', align: "right", formatter: 'date', formatoptions: {srcformat: 'ISO8601Long', newformat: 'D/M/Y'}},
                        //{ name: "Name", type: "text", width: 150 },
                        { name: "Age", type: "number", width: 50, title: "# de registros almacenados", filtering: false },
                        //{ name: "Married", type: "checkbox", title: "Is Married", sorting: false },
                        //{ type: "control", modeSwitchButton: false, editButton: false }
                    ]
                });

                $(".config-panel input[type=checkbox]").on("click", function() {
                    var $cb = $(this);
                    $("#jsGrid").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
                });
            });
        </script>
    </diV>
</div>