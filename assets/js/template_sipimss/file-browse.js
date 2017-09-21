$(document).on('click', '.browse', function() {
    var file = $(this).parent().parent().parent().find('.file');
    file.trigger('click');
});
$(document).on('change', '.file', function() {
    var nombre_nuevo_ = $(this).val();
    var nombre_nuevo = nombre_nuevo_.replace(/C:\\fakepath\\/i, '');
    $(this).parent().find('.form-control').val(nombre_nuevo);
    var componente = document.getElementById("comprobante");//Le asigna el texto a la caja de texto
    if (componente !== null) {
        componente.value = nombre_nuevo;
    }
});

$(document).on('click', '#uncheck-radio', function() {
    $('#beca-interrumpida').prop('checked', false);
});