<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion_model extends MY_Model {
    
    const DOCENTE = 3, ROOT = 1, ADMIN = 2;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();

    }

    public function get_niveles_acceso()
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $grupos = [];
        $select = array(
            'id_rol id_grupo', 'nombre', 'descripcion'
        );
        $this->db->select($select);
        $this->db->where('activo', true);
        $this->db->order_by('orden', 'asc');
        $grupos = $this->db->get('sistema.roles')->result_array();
        return $grupos;
    }



}
