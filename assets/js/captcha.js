/* 
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */



function new_captcha(){
    document.getElementById('captcha_img').src = site_url+ '/inicio/captcha/' + Math.random(); 
}
