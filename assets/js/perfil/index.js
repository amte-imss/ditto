/* 
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */


$(function () {
    console.log('cargando');
    $('#form_actualizar_password').submit(function (event) {
        event.preventDefault();
        data_ajax($(this).attr('action'), $(this), '#campo_password', null, true);
    });
});