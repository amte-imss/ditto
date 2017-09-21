$(document).ready(function () {//Ejecuta al final de la página
    var element = document.getElementById('nombramiento');
    var prop_elemento = $(element);
    var display = prop_elemento.data("displaycomponente");
    var value_select_duracion = parseInt(element.value);
//    alert(value_select_duracion);
    
    switch (value_select_duracion) {
        case 254: //hrs
            $("#div_horas").css("display", "none");//Visualiza
            $('#div_horas').toggle("slow");//Evento, forma de salida
            break;
        default :
            $("#div_horas").css("display", display);//Oculta
            $('#div_horas').toggle("slow");//Evento, forma de salida
    }

});

function visualizar_campos(element) {
    var prop_elemento = $(element);
    var display = prop_elemento.data("displaycomponente");
    
    switch (parseInt(element.value)) {
        case 254: //horas
            $("#div_horas").css("display", "none");
            $('#div_horas').toggle("slow");//Evento, forma de salida
            break;
        default :
            $("#div_horas").css("display", display);
            $('#div_horas').toggle("slow");//Evento, forma de salida
            document.getElementById('horas').value = "";
    }
}