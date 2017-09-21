/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */

function recovery_password() {
    console.log('test');
    $('#login-modal').modal('hide')

    $('#modalRecovery').modal('show');
}

$(function(){
    $('#boton_registro').click(function(event){
        var destino = site_url + '/welcome/registro';
        data_ajax(destino, null, '#registro_modal_content');
    });       
})