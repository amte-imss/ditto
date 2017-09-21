/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author LEAS
 */

$(document).ready(function () {
//    $('#js_detalle_exportar').on('click', function () {
//        document.location.href = site_url + '/reporte/exportar_datos_detalle_cursos_registros/';
//    });

    $('#modalidad').attr('disabled', true);
    $('#modalidad').append('<option value="">Todos</option>');
    $('#area_enfoque').attr('disabled', true);
    $('#area_enfoque').append('<option value="">Todos</option>');

    $.ajax({
        url: site_url + '/rama_organica/get_lista_rama',
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                lista_tipo_actividad = data['tipos_actividad'];
                lista_modalidad = data['modalidades'];
                lista_area_enfoque = data['areas_enfoque'];
                lista_delegacion = data['delegaciones'];
                delegaciones();

                $('#tipo_actividad').append('<option value="">Todos</option>');
                $.each(lista_tipo_actividad, function (key, value) {
                    $('#tipo_actividad').append('<option value="' + value['id_tipo_actividad'] + '">' + value['nombre_tipo_actividad'] + '</option>');
                });

                ocultar_loader();

                $('#tipo_actividad').on('change', function (event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var valor = $(this).val();
                    mostrar_loader();

                    if (valor) {
                        select_modalidad(valor);
                        $('#modalidad').attr('disabled', false);
                    } else {
                        $('#modalidad').attr('disabled', true);
                        $('#modalidad').empty();
                        $('#modalidad').append('<option value="">Todos</option>');

                    }
                    $('#area_enfoque').attr('disabled', true);
                    $('#area_enfoque').empty();
                    $('#area_enfoque').append('<option value="">Todos</option>');
                    get_info_cursos(1, valor);
                    ocultar_loader();

                });
                get_info_cursos(1, "");//Carga datos al inicio

            })
            .fail(function (jqXHR, error, errorThrown) {
                console.log("error carga rama");
                console.log(jqXHR);
                console.log(error);
                console.log(errorThrown);
            });
});


function select_modalidad(tipo) {
    modalidad(tipo);
    $('#modalidad').empty();

    $('#modalidad').append('<option value="">Todos</option>');
    $.each(opciones_modalidad, function (key, value) {
        $('#modalidad').append('<option value="' + value['id_modalidad'] + '">' + value['nombre_modalidad'] + '</option>');
    });

    $('#modalidad').on('change', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        var valor = $(this).val();
        if (valor) {
            select_area_enfoque(valor);
            $('#area_enfoque').attr('disabled', false);
        } else {
            $('#area_enfoque').attr('disabled', true);
            $('#area_enfoque').empty();
            $('#area_enfoque').append('<option value="">Todos</option>');
        }
        get_info_cursos(2, valor);
    });

}

function select_area_enfoque(tipo) {
    area_enfoque(tipo);
    $('#area_enfoque').empty();

    $('#area_enfoque').append('<option value="">Todos</option>');
    $.each(opciones_area_enfoque, function (key, value) {
        $('#area_enfoque').append('<option value="' + value['id_area_enfoque'] + '">' + value['nombre_area_enfoque'] + '</option>');
    });

    $('#area_enfoque').on('change', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        var valor = $(this).val();
        if (valor) {
            mostrar_loader();
//            get_info_cursos(area);
            ocultar_loader();
        }
        get_info_cursos(3, valor);
    });

}

function get_info_cursos(tipo, identificador) {
    $.ajax({
        url: site_url + '/reporte/get_informacion_curso_unidad/' + tipo + '/' + identificador,
        type: 'POST',
        dataType: 'json',
    })
            .done(function (data) {
//                $('#jsGridUnidad').html(data.consulta);
                grid_docente(data);
            })
            .fail(function (jqXHR, error, errorThrown) {
                console.log("error carga rama");
                console.log(jqXHR);
                console.log(error);
                console.log(errorThrown);
            });
}
//var cursos;
function grid_docente(data) {
//    console.log(data);
    $("#jsGridUnidad").jsGrid({
        height: "500px",
        width: "100%",
        filtering: true,
        editing: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 5,
        pageButtonCount: 3,
        //Spanish ***************
//        pageLoading: true,
        pagerFormat: "Paginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
        pagePrevText: "Anterior",
        pageNextText: "Siguiente",
        pageFirstText: "Primero",
        pageLastText: "Último",
        pageNavigatorNextText: "...",
        pageNavigatorPrevText: "...",
        noDataContent: "No se encontraron datos",
        invalidMessage: "",
//        loadMessage: "Por favor espere",
        //***********************

        data: data.cursos,
        controller: {
            loadData: function (filter) {
                return $.grep(data.cursos, function (cursos) {
                    return (filter.id_tipo_curso == cursos.id_tipo_curso) || (filter.id_tipo_curso == "");
                });
            },
        },
        fields: [
            {name: "id_tipo_curso", type: "select", items: data.countries_tc, valueField: "id_tc", textField: "tipo_curso", title: "Tipo curso"},
//            {name: "clave_curso", type: "label", valueField: "Name", textField: "Name", title: "Cursos"},
            {name: "nombre_curso", type: "label", valueField: "name", textField: "Name", title: "Nombre del curso"},
            {name: "cantidad", type: "label", width: 50, title: "Número de registros almacenados"},
        ]
    });
}