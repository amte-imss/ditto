/* 
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */

$(function () {
    console.log('colando ayudas');
    $('.sipimss-helper').click(function (event) {
        var id_help = $(this).attr('data-help');
        data_ajax(site_url + '/ayuda/get/' + id_help, null, '#sipimss-modal');
        $('#myModal').modal();
    });
});