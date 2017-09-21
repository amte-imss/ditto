<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Reporte_modal
 *
 * @author chrigarc
 */
class Reporte_model extends MY_Model
{

    /**
     * Tipos para hacer la consulta
     */
    const
            TIPO_1 = 1, //'tipo_actividad'
            TIPO_2 = 2, //'modalidad',
            TIPO_3 = 3, //'area_enfoque',
            TIPO_4 = 4, //'tipo_curso',
            TIPO_1_TEXT = 'TA.id_tipo_actividad', //'tipo_actividad'
            TIPO_2_TEXT = 'M.id_modalidad', //'modalidad',
            TIPO_3_TEXT = 'AE.id_area_enfoque', //'area_enfoque',
            TIPO_4_TEXT = 'TC.id_tipo_curso', //'tipo_curso',
            Delegacion = 'delegacion',
            Unidad = 'unidad'

    ;

    function __construct()
    {
        parent::__construct();
    }

    public function get_cantidad_cursos_unidad($filtros = null)
    {

        $this->db->flush_cache();
        $this->db->reset_query();
        $select = ['count(rd.matricula) total'];
        $this->db->select($select);

        if (!is_null($filtros))
        {
            $this->db->where($filtros);
//            foreach ($filtros as $key => $value)
//            {
//                if ($key == 'N.clave_unidad')
//                {
//                    $this->db->or_where($key, $value);
//                } else
//                {
//                    $this->db->where($key, $value);
//                }
//            }
        }


        $this->db->join('catalogo.curso c', 'c.clave_curso = rd.clave_curso');
        $this->db->join('catalogo.tipo_curso tp', 'tp.id_tipo_curso = c.id_tipo_curso');
        $this->db->join('nominas.nomina_historico N', 'N.matricula = rd.matricula', 'left');
        $this->db->group_by(
                array("c.clave_curso", "c.nombre_curso", "c.id_tipo_curso", "rd.matricula"
                )
        );
        $result_array = $this->db->get('ods.registro_docente rd')->result_array();
//        pr($this->db->last_query());
        return count($result_array);
    }

    public function get_reporte_nivel_central()
    {
        $salida['total'] = $this->get_total_registros();
        $salida['unidades'] = $this->get_total_registros(array('unidades' => true));
        $salida['delegaciones'] = $this->get_total_registros(array('delegaciones' => true));
        $salida['cursos'] = $this->get_total_cursos();
        return $salida;
    }

    private function get_total_cursos()
    {
        $salida = null;
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'count(distinct clave_curso) cantidad'
        );
        $this->db->select($select);
        $salida = $this->db->get('ods.registro_docente')->result_array()[0]['cantidad'];
        $this->db->flush_cache();
        $this->db->reset_query();
//        pr($this->db->last_query());
        return $salida;
    }

    private function get_total_registros($opciones = [])
    {
        $salida = null;
        if (isset($opciones['unidades']) && $opciones['unidades'])
        {
            $salida = $this->get_reporte_unidades();
        } else if (isset($opciones['delegaciones']) && $opciones['delegaciones'])
        {
            $salida = $this->get_reporte_delegaciones();
        } else
        {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select('count(*) cantidad');
            $salida = $this->db->get('ods.registro_docente')->result_array()[0]['cantidad'];
            $this->db->flush_cache();
            $this->db->reset_query();
        }
        return $salida;
    }

    private function get_reporte_unidades($filtros = [])
    {
        $unidades = [];
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'CC.clave_delegacional clave_delegacion', 'CC.nombre delegacion',
            'D.clave_unidad', 'D.nombre unidad', 'count(distinct "A".matricula) cantidad',
        );
        $this->db->select($select);
        $this->db->join('nominas.nomina_historico B', 'B.matricula = A.matricula', 'inner');
        $this->db->join('catalogo.delegaciones C', 'C.clave_delegacional = A.delegacion', 'inner');
        $this->db->join('catalogo.unidades_instituto D', 'D.clave_unidad = B.clave_unidad', 'inner');
        $this->db->join('catalogo.delegaciones CC', 'CC.id_delegacion = D.id_delegacion', 'inner');
        $this->db->where('D.anio', 2017);
        $this->db->group_by(array(
            'D.clave_unidad', 'D.nombre', 'CC.id_delegacion', 'CC.clave_delegacional', 'CC.nombre'
        ));
        $unidades = $this->db->get('ods.registro_docente A')->result_array();
//        pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();
        return $unidades;
    }

    private function get_reporte_delegaciones($filtros = [], $clave_unidad = null)
    {
        $delegaciones = [];
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'CC.clave_delegacional clave_delegacion', 'CC.nombre delegacion',
            'count(distinct "A".matricula) cantidad'
        );
        $this->db->select($select);
        $this->db->join('nominas.nomina_historico B', 'B.matricula = A.matricula', 'inner');
        $this->db->join('catalogo.delegaciones C', 'C.clave_delegacional = A.delegacion', 'inner');
        $this->db->join('catalogo.unidades_instituto D', 'D.clave_unidad = B.clave_unidad', 'inner');
        $this->db->join('catalogo.delegaciones CC', 'CC.id_delegacion = D.id_delegacion', 'inner');
        $this->db->where('D.anio', 2017);
        $this->db->group_by(array(
            'CC.clave_delegacional', 'CC.nombre'
        ));
        $delegaciones = $this->db->get('ods.registro_docente A')->result_array();
        //pr($this->db->last_query());
        return $delegaciones;
    }

    public function get_reporte_curso_unidad($filtros = [])
    {
//        pr($filtros);
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'count("C"."clave_curso") cantidad', "C.clave_curso", "C.nombre_curso",
//            "concat(\"TA\".nombre_tipo_actividad, ' > ', \"M\".nombre_modalidad, ' > ', \"AE\".nombre_area_enfoque, ' > ', \"TC\".nombre_tipo_curso) Ruta"
//            "TC.nombre_tipo_curso tipo_curso"
            "TC.id_tipo_curso", "TC.nombre_tipo_curso"
        );
        $this->db->select($select);
        $this->db->join('catalogo.curso C', 'C.clave_curso = RD.clave_curso');
        $this->db->join('catalogo.tipo_curso TC', 'TC.id_tipo_curso = C.id_tipo_curso');
        $this->db->join('catalogo.area_enfoque AE', 'AE.id_area_enfoque = TC.id_area_enfoque');
        $this->db->join('catalogo.modalidad M', 'M.id_modalidad = AE.id_modalidad');
        $this->db->join('catalogo.tipo_actividad TA', 'TA.id_tipo_actividad = M.id_tipo_actividad');
        $this->db->join('nominas.nomina_historico N', 'N.matricula = RD.matricula', 'left');
        $this->db->group_by(array(
            'C.clave_curso', 'C.nombre_curso', 'TA.nombre_tipo_actividad', 'M.nombre_modalidad',
            'AE.nombre_area_enfoque', 'TC.nombre_tipo_curso', 'TC.id_tipo_curso', 'RD.matricula'
        ));


        if (!is_null($filtros))
        {

            $this->db->where($filtros);
//            foreach ($filtros as $key => $value)
//            {
//                if ($key == 'N.clave_unidad')
//                {
//                    $this->db->or_where($key, $value);
//                } else
//                {
//                    $this->db->where($key, $value);
//                }
//            }
        }
        $res = $this->db->get('ods.registro_docente RD')->result_array();
//        pr($this->db->last_query());
//        exit();
//        $this->db->flush_cache();
//        $this->db->reset_query();
//        return $res->result_array();
        return $res;
    }

    public function get_tipos_cursos_unidad($filtros = [])
    {
//        pr($filtros);
//        $this->db->flush_cache();
//        $this->db->reset_query();
        $select = array(
            "TC.nombre_tipo_curso tipo_curso", "TC.id_tipo_curso id_tc"
        );
        $this->db->select($select);
        $this->db->distinct();
        $this->db->join('catalogo.curso C', 'C.clave_curso = RD.clave_curso');
        $this->db->join('catalogo.tipo_curso TC', 'TC.id_tipo_curso = C.id_tipo_curso');
        $this->db->join('catalogo.area_enfoque AE', 'AE.id_area_enfoque = TC.id_area_enfoque');
        $this->db->join('catalogo.modalidad M', 'M.id_modalidad = AE.id_modalidad');
        $this->db->join('catalogo.tipo_actividad TA', 'TA.id_tipo_actividad = M.id_tipo_actividad');
        $this->db->join('nominas.nomina_historico N', 'N.matricula = RD.matricula', 'left');
        $this->db->group_by(array(
            'C.clave_curso', 'C.nombre_curso', 'TA.nombre_tipo_actividad',
            'M.nombre_modalidad', 'AE.nombre_area_enfoque', 'TC.nombre_tipo_curso', 'TC.id_tipo_curso', "RD.matricula"
        ));
        $this->db->order_by(1);

        if (!is_null($filtros))
        {
            $this->db->where($filtros);
//            foreach ($filtros as $key => $value)
//            {
//                if ($key == 'N.clave_unidad')
//                {
//                    $this->db->or_where($key, $value);
//                } else
//                {
//                    $this->db->where($key, $value);
//                }
//            }
        }

        $res = $this->db->get('ods.registro_docente RD')->result_array();
//        pr($this->db->last_query());
//        $this->db->flush_cache();
//        $this->db->reset_query();
//        return $res->result_array();
        return $res;
    }

}
