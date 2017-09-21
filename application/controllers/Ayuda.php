<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Ayuda
 *
 * @author chrigarc
 */
class Ayuda extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('ayudas'); //Cargar archivo de lenguaje
    }

    public function get($id = 'help')
    {
        $ayudas = $this->lang->line('ayudas');
        if (isset($ayudas[$id]))
        {
            $output['contenido'] = $ayudas[$id];
        } else
        {
            $output['contenido'] = $ayudas['lorem'];
        }
        $this->load->view('ayuda/modal.tpl.php', $output);
    }

    public function test()
    {
        $vista = $this->load->view('ayuda/test.tpl.php', null, true);
        $this->template->setMainContent($vista);
        $this->template->getTemplate();
    }

}
