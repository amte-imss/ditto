<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Docente_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Devuelve un arreglo con todos la informacion de los docentes
     * @author CPMS
     * @date 30/08/2017
     * @param arreglo con los filtros 
     * @param indice donde incia la paginacion
     * @param cantidad de registros a devolver
     * @return array
     */
    public function get_docentes($filtros = null, $inicio = null, $tam = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        //$select = array('id_registro_docente','matricula','delegacion','id_rol','C.clave_curso','activo','fecha_registro','id_tipo_curso');
        $this->db->distinct();
        $select = array('D.*', 'nombre_curso', 'T.id_tipo_curso', 'nombre_tipo_curso', 'id_area_enfoque',
            'N.nombre', 'N.apellido_paterno', 'N.apellido_materno', 'N.clave_categoria', 'N.categoria', 'N.clave_unidad', 'N.unidad', "concat(\"N\".nombre, ' ', \"N\".apellido_paterno, ' ',\"N\".apellido_materno) nombre_completo");
        $this->db->select($select);
        $this->db->join('catalogo.curso C', 'C.clave_curso = D.clave_curso', 'left');
        $this->db->join('catalogo.tipo_curso T', 'T.id_tipo_curso = C.id_tipo_curso', 'left');
        $this->db->join('nominas.nomina_historico N', 'N.matricula = D.matricula', 'left');
        if (!is_null($filtros))
        {
            if (isset($filtros['matricula']))
            {
                $this->db->where('D.matricula', $filtros['matricula']);
                unset($filtros['matricula']);
            }

            if (isset($filtros['delegacion']))
            {
                $this->db->where('D.delegacion', $filtros['delegacion']);
                unset($filtros['delegacion']);
            }

            if (isset($filtros['tipo_curso']))
            {
                $this->db->where('C.id_tipo_curso', $filtros['tipo_curso']);
                unset($filtros['tipo_curso']);
            }

            if (isset($filtros['curso']))
            {
                $this->db->where('D.clave_curso', $filtros['curso']);
                unset($filtros['curso']);
            }

            if (isset($filtros['rol']))
            {
                $this->db->where('D.id_rol', $filtros['rol']);
                unset($filtros['rol']);
            }

            if (isset($filtros['nombre_completo']))
            {
                $this->db->like('nombre_completo', $filtros['nombre_completo'], 'both');
                unset($filtros['nombre_completo']);
            }

            if (isset($filtros['unidad']))
            {
                $this->db->like('unidad', $filtros['unidad'], 'both');
                unset($filtros['unidad']);
            }

            if (isset($filtros['categoria']))
            {
                $this->db->like('categoria', $filtros['categoria'], 'both');
                unset($filtros['categoria']);
            }

            if (isset($filtros['acceso']))
            {
                if (!$filtros['acceso'])
                {
                    $this->db->where("(id_unidad_instituto = " . $filtros['id_unidad_instituto'] . " OR clave_unidad = '" . $filtros['clave_unidad'] . "')");
                    unset($filtros['id_unidad_instituto']);
                    unset($filtros['clave_unidad']);
                }
                unset($filtros['acceso']);
            }

            $this->db->where($filtros);
        }
        $this->db->limit($tam, $inicio);
        $this->db->order_by('T.id_tipo_curso,nombre_tipo_curso,id_rol,unidad,nombre_completo');
        $res = $this->db->get('ods.registro_docente D')->result_array();

//        pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    public function get_datos_curso($filtros = null, $clave_unidad = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        //$select = array('id_registro_docente','matricula','delegacion','id_rol','C.clave_curso','activo','fecha_registro','id_tipo_curso');
        $select = array(
            "D.matricula", "concat(\"N\".nombre, ' ', \"N\".apellido_paterno, ' ',\"N\".apellido_materno) nombre_completo",
            "R.nombre_rol", "DP.nombre nombre_delegacion",
            "T.nombre_tipo_curso", "C.clave_curso", "C.nombre_curso",
            "A.nombre_area_enfoque", "MD.nombre_modalidad", "TA.nombre_tipo_actividad",
            "N.clave_categoria", "N.categoria", "N.clave_unidad", "N.unidad"
        );
        $grud_by = array(
            "D.matricula", "N.nombre", "N.apellido_paterno", "N.apellido_materno",
            "D.fecha_registro", "R.nombre_rol", "DP.nombre",
            "C.id_tipo_curso", "nombre_tipo_curso", "C.clave_curso", "C.nombre_curso",
            "A.nombre_area_enfoque", "N.anio", "MD.nombre_modalidad", "TA.nombre_tipo_actividad",
            "N.clave_categoria", "N.categoria", "N.clave_unidad", "N.unidad"
        );
        $this->db->select($select);
        $this->db->join('catalogo.curso C', 'C.clave_curso = D.clave_curso');
        $this->db->join('catalogo.tipo_curso T', 'T.id_tipo_curso = C.id_tipo_curso');
        $this->db->join('catalogo.area_enfoque A', 'A.id_area_enfoque = T.id_area_enfoque');
        $this->db->join('catalogo.modalidad MD', 'MD.id_modalidad = A.id_modalidad');
        $this->db->join('catalogo.tipo_actividad TA', 'TA.id_tipo_actividad = MD.id_tipo_actividad');
        $this->db->join('catalogo.rol R', 'D.id_rol = R.id_rol', 'left');
        $this->db->join('nominas.nomina_historico N', 'N.matricula = D.matricula', 'left');
        $this->db->join('catalogo.delegaciones DP', 'DP.clave_delegacional = D.delegacion', 'left');
        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }
//        if (!is_null($clave_unidad))
//        {
//            $this->db->or_where('N.clave_unidad', $clave_unidad);
//        }
        $this->db->order_by('D.matricula');
//        $this->db->having("to_char(D.fecha_registro, 'YYYY'::text) >= '2017'", false);
        $this->db->group_by($grud_by);
        $res = $this->db->get('ods.registro_docente D')->result_array();
//        pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();
//        exit();
        return $res;
    }

    /**
     * Inserta un registro docente
     * @author CPMS
     * @date 30/08/2017
     * @param arreglo con los datos a insertar
     * @return array con mensaje de respuesta
     */
    public function insert($values)
    {
        $salida = false;
        $mensaje = "No se pudo registrar la información del docente";
        $data = "";

        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin();

        $this->db->insert('ods.registro_docente', $values);
        $last_id = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        } else
        {
            $this->db->trans_commit();
            $salida = true;
            $mensaje = "Se ha registrado la información del docente correctamente";
            $data = $this->get_docentes(array('id_registro_docente' => $last_id));
        }
        $this->db->flush_cache();
        $this->db->reset_query();
//        pr($data);
        return array("success" => $salida, "message" => $mensaje, "data" => $data[0]);
    }

    /**
     * Elimina un registro docente
     * @author CPMS
     * @date 30/08/2017
     * @param id_registro_docente del docente
     * @return array con mensaje de respuesta
     */
    public function delete($id_registro_docente)
    {
        $salida = false;
        $mensaje = "No se pudo eliminar la información del docente";

        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin();

        $this->db->delete('ods.registro_docente', array('id_registro_docente' => $id_registro_docente));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        } else
        {
            $this->db->trans_commit();
            $salida = true;
            $mensaje = "Se ha eliminado la información del docente";
        }
        $this->db->flush_cache();
        $this->db->reset_query();
        return array("success" => $salida, "message" => $mensaje);
    }

    /**
     * Edita un registro docente
     * @author CPMS
     * @date 04/09/2017
     * @param id del registro
     * @param arreglo con los datos que se van a actualizar
     * @return array con mensaje de respuesta
     */
    public function update($id_registro, $values)
    {
        $salida = false;
        $mensaje = "No se pudo actualizar la información del docent";
        $data = "";

        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin();

        $this->db->where('id_registro_docente', $id_registro);
        $this->db->update('ods.registro_docente', $values);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        } else
        {
            $this->db->trans_commit();
            $salida = true;
            $mensaje = "Se ha actualizado la información del docente correctamente";
            $data = $this->get_docentes(array('id_registro_docente' => $id_registro));
        }
        $this->db->flush_cache();
        $this->db->reset_query();
        return array("success" => $salida, "message" => $mensaje, "data" => $data[0]);
        //return array("success" => $salida, "message" => $mensaje);
    }

    /**
     * Determina si un registro ya existe en base a
     * la matricula y la clave de curso 
     * (opcional) y el id del registro
     * @author CPMS
     * @date 05/09/2017
     * @param matricula
     * @param clave de curso
     * @return bool
     */
    public function existe_registro($matricula, $curso, $id_registro = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $filtros = array(
            'matricula' => $matricula,
            'clave_curso' => $curso
        );

        $this->db->where($filtros);
        $res_array = $this->db->get('ods.registro_docente')->result_array();
        //pr($this->db->last_query());

        $this->db->flush_cache();
        $this->db->reset_query();

        //pr($res_array);

        if (!is_null($id_registro))
        {
            if (count($res_array) == 1 && $res_array[0]['id_registro_docente'] == $id_registro)
                return false;
        }

        return count($res_array) > 0;
    }

    /**
     * Determina si un docente existe en la nomina dependiendo de la matricula
     * @author CPMS
     * @date 05/09/2017
     * @param matricula
     * @return bool
     */
    public function existe_docente($matricula)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->where('matricula', $matricula);
        $res_array = $this->db->get('nominas.nomina_historico')->result_array();
        //pr($this->db->last_query());

        $this->db->flush_cache();
        $this->db->reset_query();

        return count($res_array) > 0;
    }

    /**
     * Devuelve el numero total de registros en un tabla con ciertas
     * restricciones
     * @author CPMS
     * @date 07/09/2017
     * @param filtros 
     * @return int
     */
    public function numero_total_registros($filtros = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $total = count($this->get_docentes($filtros));

        $this->db->flush_cache();
        $this->db->reset_query();

        return $total;
    }

}

?>