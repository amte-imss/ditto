<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author CPMS
     * @date 21/07/2017
     * @return array
     */
    public function get_catalogos() {
        $resutado = $this->db->get('catalogo.catalogo');
        return $resutado->result_array();
    }

    /**
     * 
     * @author LEAS
     * @fecha 18/05/2017
     * @return type catálogo de las delegaciones
     */
    public function get_delegaciones() {

        $select = array(
            'clave_delegacional', 'nombre',
        );
        $this->db->select($select);
        $this->db->where('activo', TRUE);

        $resultado = $this->db->get('catalogo.delegaciones');
//            pr($this->db->last_query());
        return $resultado->result_array();
    }

    /**
     * @author LEAS
     * @fecha 18/05/2017
     * @return catálogo del estado civil de una  persona
     */
    public function get_estado_civil() {

        $select = array(
            'id_estado_civil', 'estado_civil',
        );
        $this->db->select($select);

        $resultado = $this->db->get('catalogo.estado_civil');
//            pr($this->db->last_query());
        return $resultado->result_array();
    }

    public function opciones_combos($combo, $idcombo, $base) {
        /* select id_elemento_seccion, nombre from catalogo.elementos_seccion where id_seccion=1 and id_catalogo_elemento_padre=5 */

        $resultado = array();

        switch ($combo) {

            case "formacion_prof_prof": {
                    $opc = '';
                    $select = array(
                        'id_elemento_catalogo', 'label'
                    );

                    //$this->db->where('id_seccion',$id_seccion);
                    $this->db->where('id_catalogo_elemento_padre', $idcombo);

                    $this->db->order_by('label', 'asc');

                    $resultado = $this->db->get('catalogo.elementos_catalogos');
                    if ($resultado->num_rows() > 0) {
                        $secciones = $resultado->result_array();
                        foreach ($secciones as $index => $value) {
                            $opc[$value['id_elemento_catalogo']] = $value['label'];
                        }
                    }

                    break;
                }

            case "rama_conocimiento": {
                    $opc = '';
                    $select = array(
                        'id_elemento_catalogo', 'label'
                    );

                    //$this->db->where('id_seccion',$id_seccion);
                    $this->db->where('id_catalogo_elemento_padre', $idcombo);

                    $this->db->order_by('label', 'asc');

                    $resultado = $this->db->get('catalogo.elementos_catalogos');
                    if ($resultado->num_rows() > 0) {
                        $secciones = $resultado->result_array();
                        foreach ($secciones as $index => $value) {
                            $opc[$value['id_elemento_catalogo']] = $value['label'];
                        }
                    }

                    break;
                }

            case "cseccion": {
                    $opc = '';
                    $select = array(
                        'id_elemento_seccion', 'label'
                    );

                    $this->db->where('id_catalogo_elemento_padre', Null);
                    $this->db->where('id_seccion', $idcombo);

                    $this->db->order_by('label', 'asc');

                    $resultado = $this->db->get('catalogo.elementos_seccion');
                    if ($resultado->num_rows() > 0) {
                        $secciones = $resultado->result_array();
                        foreach ($secciones as $index => $value) {
                            $opc[$value['id_elemento_seccion']] = $value['label'];
                        }
                    }

                    break;
                }


            case "c_elem_seccion": {
                    $opc = '';
                    $select = array(
                        'id_elemento_seccion', 'label'
                    );

                    //$this->db->where('id_seccion',$id_seccion);
                    $this->db->where('id_catalogo_elemento_padre', $idcombo);

                    $this->db->order_by('label', 'asc');

                    $resultado = $this->db->get('catalogo.elementos_seccion');
                    if ($resultado->num_rows() > 0) {
                        $secciones = $resultado->result_array();
                        foreach ($secciones as $index => $value) {
                            $opc[$value['id_elemento_seccion']] = $value['label'];
                        }
                    }

                    break;
                }

            case "c_elem_subseccion": {
                    $opc = '';
                    $select = array(
                        'id_elemento_seccion', 'label'
                    );

                    //$this->db->where('id_seccion',$id_seccion);
                    $this->db->where('id_catalogo_elemento_padre', $idcombo);

                    $this->db->order_by('label', 'asc');

                    $resultado = $this->db->get('catalogo.elementos_seccion');
                    if ($resultado->num_rows() > 0) {
                        $secciones = $resultado->result_array();
                        foreach ($secciones as $index => $value) {
                            $opc[$value['id_elemento_seccion']] = $value['label'];
                        }
                    }

                    break;
                }



            case "tipo_form_complementaria": {
                    $opc = '';
                    $select = array(
                        'id_elemento_catalogo', 'label'
                    );

                    //$this->db->where('id_seccion',$id_seccion);
                    $this->db->where('id_catalogo_elemento_padre', $idcombo);

                    $this->db->order_by('label', 'asc');

                    $resultado = $this->db->get('catalogo.elementos_catalogos');
                    if ($resultado->num_rows() > 0) {
                        $secciones = $resultado->result_array();
                        foreach ($secciones as $index => $value) {
                            $opc[$value['id_elemento_catalogo']] = $value['label'];
                        }
                    }

                    break;
                }
        }





        return $opc;
    }

    /**
     * @author LEAS
     * @fecha 29/05/2017
     * @param type $clave_categoria Clave de la categoria del empleado o docente en el IMSS
     * @return array vacio en el caso de no encontrar datos decategoria del docente o del empleado,ç
     * si no, retorna informacion generales de la categoria
     */
    public function get_datos_categoria($clave_categoria) {
        $this->db->where('clave_categoria', $clave_categoria);
        $resultado = $this->db->get('catalogo.categorias');
        return $resultado->result_array();
    }

    /**
     * 
     * @author LEAS
     * @fecha 29/05/2017
     * @param type $clave_adscripcion Clave de adscripción del departamento donde se
     * labora el docente, 
     * @return array vacio, en el caso de que no encuentre datos de departamento, 
     * si no, retorna datos del departamento 
     * 
     */
    public function get_datos_departamento($clave_adscripcion) {
        $this->db->where('clave_departamental', $clave_adscripcion);
        $resultado = $this->db->get('catalogo.departamentos_instituto');
        return $resultado->result_array();
    }

    /**
     * 
     * @author TEZH
     * @fecha 29/06/2017
     * @param Listado de listado de validaciones
     * 
     */
    public function get_listado_reglas($params = null) {

        $opc = array();


        if (isset($params['rules'])) {

            $this->db->where_in('id_rules_validaciones ', $params['rules']);
        }


        $this->db->order_by('orden', 'asc');

        $resultado = $this->db->get('catalogo.lista_rules_validaciones');


        $resul = $resultado->result_array();

        foreach ($resul as $index => $value) {
            $opc[$value['id_rules_validaciones']] = $value['label'];
        }

        return $opc;
    }

    public function get_listado_callback_opciones($params = null) {
        $opciones = array();

        if (isset($params['callback'])) {
            $this->db->where_in('id_callback', $params['rules']);
        }

        $this->db->order_by('label', 'asc');
        $resultado = $this->db->get('ui.callback');
        $resultado = $resultado->result_array();

        foreach ($resultado as $key => $value) {
            $opciones[$value['id_callback']] = $value['label'];
        }

        return $opciones;
    }

    /**
     * 
     * @author TEZH
     * @fecha 29/06/2017
     * @param Listado de listado de validaciones
     * 
     */
    public function get_listado_excepciones_opciones($params = null) {

        $opc = array();


        if (isset($params['id_catalogo'])) {

            $this->db->where_in('id_catalogo ', $params['id_catalogo']);
        }
        $this->db->order_by('label', 'asc');

        $resultado = $this->db->get('catalogo.elementos_catalogos');

        //pr($this->db->last_query().$params['rules']);
        $resul = $resultado->result_array();

        foreach ($resul as $index => $value) {
            $opc[$value['id_elemento_catalogo']] = $value['label'];
        }

        return $opc;
    }

    /**
     * 
     * @author TEZH
     * @fecha 29/06/2017
     * @param Listado de listado de validaciones
     * 
     */
    public function get_listado_campos_dependientes($params = null) {

        $opc = array();


        if (isset($params['id_campo'])) {

            $this->db->where_in('id_campo ', $params['id_campo']);
        }
        $this->db->order_by('label', 'asc');

        $resultado = $this->db->get('ui.campo');

        //pr($this->db->last_query().$params['rules']);
        $resul = $resultado->result_array();

        foreach ($resul as $index => $value) {
            $opc[$value['nombre']] = $value['label'];
        }

        return $opc;
    }

    /**
     * @author LEAS
     * @Fecha 03/08/2017
     * @param type $id_catalogo identificador del catalogo a buscar
     * @param type $str cadena de busqueda
     * @param type $igual indica que va a traer unicamente la cadena que coinsida con el criterio o no 
     * true = si, puede obtener vacio o uno 
     * False = si, puede traer vacio o muchos
     */
    public function get_busca_opciones_catalogo($id_catalogo, $str, $igual = FALSE) {
        $str = str_replace(' ', '', $str);
        if ($igual) {
            $this->db->where("(replace(translate(lower(label), 'áéíóúü','aeiouu'),' ', ''))='" . $str . "'", null);
            $this->db->or_where("(replace(lower(label), ' ', '')) ='" . $str . "'", NULL);
            $this->db->where("id_catalogo", $id_catalogo);
        } else {
            $this->db->like("(replace(translate(lower(label), 'áéíóúü','aeiouu'),' ', ''))", $str);
            $this->db->or_like("(replace(lower(label), ' ', ''))", $str);
            $this->db->where("id_catalogo", $id_catalogo);
        }
        $select = array("id_elemento_catalogo", "label");

        $this->db->order_by("label");
        $this->db->select($select);
        $resultado = $this->db->get("catalogo.elementos_catalogos");

        return $resultado->result_array();
    }

    /**
    * Devuelve un arreglo con todas las areas de enfoque
    * @author CPMS
    * @date 30/08/2017
    * @param arreglo con los filtros 
    * @param string con los nombres de las columnas respecto a las
    * cuales se va a ordenar
    * @return array
    */
    public function get_areas_enfoque($filtros=null, $order_by = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if(!is_null($filtros)){
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get('catalogo.area_enfoque')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    /**
    * Devuelve un arreglo con todos los tipos de curso
    * @author CPMS
    * @date 30/08/2017
    * @param arreglo con los filtros
    * @param string con los nombres de las columnas respecto a las
    * cuales se va a ordenar
    * @return array
    */
    public function get_tipos_curso($filtros=null, $order_by = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if(!is_null($filtros)){
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get('catalogo.tipo_curso')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    /**
    * Devuelve un arreglo con todos los cursos
    * @author CPMS
    * @date 30/08/2017
    * @param arreglo con los filtros
    * @param string con los nombres de las columnas respecto a las
    * cuales se va a ordenar 
    * @return array
    */
    public function get_cursos($filtros=null, $order_by = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = array('C.*','nombre_tipo_curso','id_area_enfoque','id_proceso_educativo','T.clave clave_tipo_curso');
        $this->db->select($select);
        $this->db->join('catalogo.tipo_curso T','C.id_tipo_curso = T.id_tipo_curso','inner');
        if(!is_null($filtros)){
            if(isset($filtros['activo'])){
                $this->db->where('C.activo',$filtros['activo']);
                $this->db->where('T.activo',$filtros['activo']);
                unset($filtros['activo']);
            }
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get('catalogo.curso C')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    /**
    * Devuelve un arreglo con todos los roles del docente
    * @author CPMS
    * @date 30/08/2017
    * @param arreglo con los filtros
    * @param string con los nombres de las columnas respecto a las
    * cuales se va a ordenar 
    * @return array
    */
    public function get_rol_docente($filtros=null, $order_by = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if(!is_null($filtros)){
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get('catalogo.rol')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    /**
    * Devuelve los datos de los roles por tipo de curso
    * @author CPMS
    * @date 30/08/2017
    * @param arreglo con los filtros
    * @param string con los nombres de las columnas respecto a las
    * cuales se va a ordenar 
    * @return array
    */
    public function get_rol_curso($filtros=null, $order_by=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if(!is_null($filtros)){
            if(isset($filtros['id_tipo_curso'])){
                $filtros['T.id_tipo_curso'] = $filtros['id_tipo_curso'];
                unset($filtros['id_tipo_curso']);
            }
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }

        $select = array('T.*','nombre_rol','');
        $this->db->join('catalogo.rol R','T.id_rol = R.id_rol','inner');
        $this->db->join('catalogo.tipo_curso C','C.id_tipo_curso = T.id_tipo_curso','inner');
        $res = $this->db->get('catalogo.rol_tipo_curso T')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    /**
    * Devuelve un arreglo con todos los tipos de actividad registrados
    * @author CPMS
    * @date 07/09/2017
    * @param arreglo con filtros
    * @param string con los nombres de las columnas respecto a las
    * cuales se va a ordenar 
    * @return array
    */
    public function get_tipos_actividad($filtros=null, $order_by = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if(!is_null($filtros)){
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get('catalogo.tipo_actividad')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    /**
    * Devuelve un arreglo con todas las modalidades
    * @author CPMS 
    * @date 08/09/2017
    * @param arreglo con filtros
    * @param string con los nombres de las columnas respecto a las
    * cuales se va a ordenar 
    * @return array
    */
    public function get_modalidades($filtros=null,$order_by=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if(!is_null($filtros)){
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get('catalogo.modalidad')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    /**
    * Devuelve la informacion de la rama hasta el area de enfoque
    * @author CPMS
    * @date 13092017
    * @param id_area_enfoque
    * @return array
    */
    public function get_rama_area_enfoque($id_area_enfoque=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = array('A.*','clave_modalidad','nombre_modalidad','T.id_tipo_actividad', 'nombre_tipo_actividad');
        $this->db->select($select);
        if(!is_null($id_area_enfoque)){
            $this->db->where('id_area_enfoque',$id_area_enfoque);
        }
        $this->db->join('catalogo.modalidad M', 'M.id_modalidad = A.id_modalidad', 'inner');
        $this->db->join('catalogo.tipo_actividad T', 'M.id_tipo_actividad = T.id_tipo_actividad', 'inner');
        $this->db->order_by('nombre_tipo_actividad');
        $res = $this->db->get('catalogo.area_enfoque A')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    public function get_rama_modalidad($id_modalidad=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = array('M.*','nombre_tipo_actividad');
        $this->db->select($select);
        if(!is_null($id_modalidad)){
            $this->db->where('id_modalidad',$id_modalidad);
        }
        $this->db->join('catalogo.tipo_actividad T', 'M.id_tipo_actividad = T.id_tipo_actividad', 'inner');
        $this->db->order_by('nombre_tipo_actividad');
        $res = $this->db->get('catalogo.modalidad M')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;    
    }


    public function get_rama_tipo_curso($id_tipo_curso=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = array('C.*','nombre_area_enfoque' , 'A.id_modalidad', 'clave_modalidad','nombre_modalidad','T.id_tipo_actividad', 'nombre_tipo_actividad');
        $this->db->select($select);
        if(!is_null($id_tipo_curso)){
            $this->db->where('id_tipo_curso',$id_tipo_curso);
        }

        $this->db->join('catalogo.area_enfoque A', 'A.id_area_enfoque = C.id_area_enfoque', 'inner');
        $this->db->join('catalogo.modalidad M', 'M.id_modalidad = A.id_modalidad', 'inner');
        $this->db->join('catalogo.tipo_actividad T', 'T.id_tipo_actividad = M.id_tipo_actividad', 'inner');
        
        $this->db->order_by('nombre_tipo_actividad');
        $res = $this->db->get('catalogo.tipo_curso C')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    public function get_proceso_educativo($filtros=null,$order_by=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if(!is_null($filtros)){
            $this->db->where($filtros);
        }
        if(!is_null($order_by)){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get('catalogo.proceso_educativo')->result_array();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }
}
