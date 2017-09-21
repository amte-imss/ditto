<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Buscador_model
 *
 * @author chrigarc
 */
class Buscador_model extends MY_Model
{

    //put your code here
    function __construct()
    {
        parent::__construct();
    }

    public function search_categoria($keyword = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select(array(
            'id_categoria', 'clave_categoria', 'concat(nombre, $$ [$$, clave_categoria, $$]$$) nombre'
        ));
        if ($keyword != null)
        {
            $this->db->like('lower(concat(clave_categoria,$$ $$, nombre))', $keyword);            
        }
        $this->db->limit(10);
        $categoria = $this->db->get('catalogo.categorias')->result_array();
        return $categoria;
    }

}
