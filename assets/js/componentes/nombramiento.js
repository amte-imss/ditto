$(document).ready(function () {//Ejecuta al final de la página
    var elemento_nombramiento = document.getElementById('nombramiento');
    var value_select_nombramiento = parseInt(elemento_nombramiento.value);
//    alert(value_select_duracion);
    switch (value_select_nombramiento) {
        case 252: //Si
            $("#div_archivo_nombramiento").css("display", "none");//Visualiza
            $('#div_archivo_nombramiento').toggle("slow");//Evento, forma de salida
            break;
        default :
            var elemento = document.getElementById('archivo_nombramiento');
            var display = $(elemento).data("displaycomponente");
            $("#div_archivo_nombramiento").css("display", display);//Oculta
            $('#div_archivo_nombramiento').toggle("slow");//Evento, forma de salida
    }

});

function visualizar_comprobante_nombramiento(element) {
//    var prop_elemento = $(element);
//    alert(display);
    switch (parseInt(element.value)) {
        case 252: //Si
            $("#div_archivo_nombramiento").css("display", "none");
            $('#div_archivo_nombramiento').toggle("slow");//Evento, forma de salida
            break;
        default :
            var elemento_archivo_nombramiento = document.getElementById('archivo_nombramiento');
            var var_jquery = $(elemento_archivo_nombramiento);
            var display = var_jquery.data("displaycomponente");
            $("#div_archivo_nombramiento").css("display", display);
            $('#div_archivo_nombramiento').toggle("slow");//Evento, forma de salida
            elemento_archivo_nombramiento.value = "";
    }
}