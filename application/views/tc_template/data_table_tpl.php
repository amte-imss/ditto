<?php
$controlador = '/' . $this->uri->rsegment(1);

//pr($valores_mostrar_opciones);
//echo js('jquery/datatables/js/jquery.dataTables.js');

echo js('jquery.dataTables.min.js');
?>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#docente_actividad').dataTable({
//            "sPaginationType": "full_numbers",
        });
    });
</script>

<script type="text/javascript">
    $('#docente_actividad').dataTable({
        responsive: true
    });
</script>
<div class="col-sm-6">
    <br><br>
    <div id="datatable_filter" class="dataTables_filter">
        <div class="col-md-2">
            <label>Buscar:</label>
        </div>
        <div class="col-md-6">
            <input type="search" class="form-control" placeholder="" aria-controls="datatable">
        </div>
    </div>
    <br><br>
</div>

<div class="col-md-12">
    <div class="table">
        <br>
        <div class="row">

            <?php
            if (isset($catalogo_secciones_actividad_docente)) {
                ?>
                <?php
                echo $catalogo_secciones_actividad_docente;
                ?>
                <?php
            }
            ?>

        </div>
        <br>
        <div id="div_cuerpo_tabla" class="row">
            <!-- tabla -->
            <?php
            echo $componente_datatable;
            ?>
        </div>
    </div>
    <div class="row">
        <!-- <div class="col-sm-6">
            <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Mostrando 1 a 10 de 26 entradas
            </div>
        </div> -->
        <!-- <div class="col-sm-6">
            <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                <ul class="pagination">
                    <li class="paginate_button previous disabled" aria-controls="datatable" tabindex="0" id="datatable_previous"><a href="#">Anterior</a></li>
                    <li class="paginate_button active" aria-controls="datatable" tabindex="0"><a href="#">1</a></li>
                    <li class="paginate_button " aria-controls="datatable" tabindex="0"><a href="#">2</a></li>
                    <li class="paginate_button " aria-controls="datatable" tabindex="0"><a href="#">3</a></li>
                    <li class="paginate_button next" aria-controls="datatable" tabindex="0" id="datatable_next"><a href="#">Siguiente</a></li>
                </ul>
            </div>
        </div> -->
    </div>





</div>
</div>
