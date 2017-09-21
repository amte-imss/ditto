/*
 * 08/08/2017 
 * @author  LEAS
 */
var memoria_sede = new Object();
$(document).ready(function () {//Ejecuta al final de la página
    $('.localiza_sede').each(function (index, element) {
//    var sede = memoria_values['sede'];
        $("#" + element.name).trigger('onchange');
        var config = memoria_sede[element.name];//Componente de resultados
        if (element.value.length > 0) {
            //Consulta
            add_select_item_value_sede(element.name, config.anio, element.value);
        } else if (typeof memoria_values[element.name] !== 'undefined') {
//            alert(config.anio);
            add_select_item_value_sede(element.name, config.anio, memoria_values[element.name]);
//            alert(element.name);
        }
    });
});

function get_inicializa(config, element) {
//    alert(config);
    memoria_sede[element.name] = config;
}
//function carga_localizador_sede(config, element) {
function carga_localizador_sede(element) {
    $('#my_modal_content').html(crear_estructura_modal());
    var titulo = "Localizador de sede";
//    try {//Cacha el error
    var config = memoria_sede[element.name];
    if (element.value.length > 0) {
        titulo += ": " + element.options[1].text + " (" + element.value + ")";
    }
    $('#modal_titulo').html(titulo);
//    $('#modal_cuerpo').html(cuerpo);
    $('#modal_pie').html(this.crear_localizador_sede_pie(element.name, config));
//    $('#my_modal').modal({show: true});
    $('#' + element.name).localizador_sedes(config);
//    } catch (e) {
//    }
}

function  crear_localizador_sede_pie(componente_name, config) {
    var pie = '<button type="button" class="btn btn-primary" data-periodo="' + config.anio + '" data-componente="' + componente_name + '"  onclick="agregar_unidad_drop_down(this); ">Aceptar</button>'
            + '<button type="button" class="btn btn-primary" data-componente="' + componente_name + '" onclick="limpiar_unidad(this);" data-dismiss="modal">Cancelar</button>';
    return pie;
}


function limpiar_unidad(element) {
    var data = $(element);
    var componente = data.data('componente');//Componente de resultados
    $("#" + componente).removeAttr('value');//Limpia atributo
}

function agregar_unidad_drop_down(element) {
    var data = $(element);
    var componente = data.data('componente');//Componente de resultados
    var periodo = data.data('periodo');//Componente de resultados
    var dropdown_resultado = $("#" + componente);//Componente de resultados
//    var cmp = document.getElementById(componente);
//    alert(dropdown_resultado.attr('value'));
    if (dropdown_resultado.attr('value')) {
        add_select_item_value_sede(componente, periodo, dropdown_resultado.attr('value'));
    } else {
        var elmnt = document.getElementById(componente);
        if (elmnt.options.length === 2) {//Si existe información actual
            apprise('No ha selecciono una sede, desea conservar la sede actual', {verify: true}, function (btnClick) {
                if (!btnClick) {//Si desea conservar la información actual
                    elmnt.selectedIndex = 0;
                    $("#" + componente + " option[value='" + elmnt.options[1].value + "']").remove();
                }
                $('#my_modal').modal('hide');//Cierra modal
            });
        } else {//Informa y cierra modal
            get_mensaje_general_modal("No se ha seleccionada unidad", 'warning', 2000, true);
        }
    }

}

function add_select_item_value_sede(componente, periodo, value) {
    var elmnt = document.getElementById(componente);
    var consulta = site_url + "/rama_organica/get_detalle/unidad/" + value + "/" + periodo;
    $.getJSON(consulta, {})
            .done(function (data, textStatus, jqXHR) {
                if (data[0] /*&& textStatus === 'success'*/) {
                    if (elmnt.options.length === 2) {
                        elmnt.options[1].text = data[0].unidad;
                        elmnt.options[1].value = value;
                    } else {
                        $("#" + componente).append('<option value=' + value + ' >' + data[0].unidad + '</option>');
                        elmnt.selectedIndex = 1;
                        //Remove atrr
                    }
                    $("#" + componente).removeAttr('value');//Limpia atributo
                    get_mensaje_general_modal("Unidad seleccionada correctamente", textStatus, 1000, true);
                } else {
                    get_mensaje_general_modal("Ocurrió un error durante el proceso, inténtelo más tarde.", textStatus, 5000);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                get_mensaje_general_modal("Ocurrió un error durante el proceso, inténtelo más tarde.", textStatus, 5000);
            });

}

