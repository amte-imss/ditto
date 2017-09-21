/* 
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */

var localizadores_sede = [];

(function ($) {

    var index_localizadores = 0;
    $.fn.localizador_sedes = function (config) {
        var destino = site_url + '/rama_organica/get_localizador/';
        var configuraciones = {};
        if (typeof config !== 'undefined') {
            configuraciones = config;
        }
        this.configuracion = configuraciones;
        this.data_index = index_localizadores;
        if (typeof configuraciones.seleccion !== 'undefined') {
            switch (configuraciones.seleccion) {
                case 'checkbox':
                    this.value = {};
                    break;
                default :
                    this.value = '';
                    break;
            }
        }
        this.attr('data_index', index_localizadores);
        var dataSend = {'view': 1, data_index: index_localizadores, configuraciones: configuraciones};
        var localizador = this;

        if (typeof configuraciones.div_resultado !== 'undefined') {
            localizador = $(configuraciones.div_resultado);
        }

        $.ajax({
            url: destino,
            data: dataSend,
            method: 'POST',
            beforeSend: function (xhr) {
                mostrar_loader();
            }
        }).done(function (response) {
            localizador.html(response);
            ocultar_loader();
        });
        sipimss_rama_funciones(this);
        localizadores_sede[index_localizadores++] = this;
        return this;
    };

    grid_fields();
}(jQuery));

function grid_fields() {

}

function sipimss_rama_funciones(elemento) {

}

function localizador_sede_servicio(elemento) {
    var index = elemento.getAttribute('data-index');
    console.log('index: ' + index + ", valor: " + elemento.value);
    switch (elemento.value) {
        case 1:
        case '1':
            $('#localizador_sede_id_delegacion_' + index).parent().parent().css('display', 'block');
            $('#localizador_sede_id_nivel_' + index).parent().parent().css('display', 'block');
            $('#localizador_sede_id_nivel_' + index).prop('disabled', false);
            $('#localizador_sede_id_nivel_' + index).val('');
            $('#localizador_sede_id_delegacion_' + index).val('');
            break;
        case 2:
        case '2':
            $('#localizador_sede_id_delegacion_' + index).parent().parent().css('display', 'none');
            $('#localizador_sede_id_delegacion_' + index).val('');
            $('#localizador_sede_id_nivel_' + index).val('3');
            $('#localizador_sede_id_nivel_' + index).prop('disabled', true);           
            localizador_submit(index, '#localizador_sede_table_' + index);
        case '':
            $('#localizador_sede_id_delegacion_' + index).parent().parent().css('display', 'none');
            $('#localizador_sede_id_nivel_' + index).parent().parent().css('display', 'none');
            $('#localizador_sede_id_delegacion_' + index).val('');
            $('#localizador_sede_id_nivel_' + index).val('');
            break;
        default:
            console.log('opcion no encontrada');
            break;
    }
}

function localizador_sede_delegacion(elemento) {
    var data_index = $(elemento).attr('data-index');    
    localizador_submit(data_index, '#localizador_sede_table_' + data_index);
}

function localizador_sede_nivel(elemento) {
    var data_index = $(elemento).attr('data-index');
    $('#localizador_sede_id_delegacion_' + data_index).val('');
}

function localizador_sede_check(item) {
    switch (localizadores_sede[item.getAttribute('data-index')].configuracion.seleccion) {
        case 'checkbox':
            localizadores_sede[item.getAttribute('data-index')].value[item.getAttribute('data-cve')] = $(item).is(":checked");
            break;
        default:
            if ($(item).is(":checked")) {
                localizadores_sede[item.getAttribute('data-index')].value = item.getAttribute('data-cve');
            } else {
                localizadores_sede[item.getAttribute('data-index')].value = '';
            }
            localizadores_sede[item.getAttribute('data-index')].attr('value', localizadores_sede[item.getAttribute('data-index')].value);
            break;
    }
}
function localizador_sede_detalle(tipo_elemento, clave, periodo) {
    var consulta = site_url + "/rama_organica/get_detalle/" + tipo_elemento + "/" + clave + "/" + periodo;
    $.getJSON(consulta, {})
            .done(function (data, textStatus, jqXHR) {
                if (textStatus === 'success') {
                    return data;
                } else {
                    return null;
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                return null;
            });
}

function localizador_submit(data_index, elemento) {
    var destino = site_url + '/rama_organica/get_localizador/';
    var dataSend = {};
    dataSend['data_index'] = data_index;
    if (document.getElementById('localizador_sede_config_' + data_index) != null) {
        dataSend['config'] = document.getElementById('localizador_sede_config_' + data_index).value;
    }
    if (document.getElementById('localizador_sede_id_servicio_' + data_index) != null) {
        dataSend['localizador_sede_id_servicio_' + data_index] = document.getElementById('localizador_sede_id_servicio_' + data_index).value;
    }
    if (document.getElementById('localizador_sede_id_nivel_' + data_index) != null) {
        dataSend['localizador_sede_id_nivel_' + data_index] = document.getElementById('localizador_sede_id_nivel_' + data_index).value;
    }
    if (document.getElementById('localizador_sede_id_delegacion_' + data_index) != null) {
        dataSend['localizador_sede_id_delegacion_' + data_index] = document.getElementById('localizador_sede_id_delegacion_' + data_index).value;
    }

    $.ajax({
        url: destino,
        data: dataSend,
        method: 'POST',
        beforeSend: function (xhr) {
            mostrar_loader();
        }
    }).done(function (response) {
        $(elemento).html(response);
        ocultar_loader();
    });
}

