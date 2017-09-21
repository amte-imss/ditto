<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends MY_Controller
{

    const LISTA = 'lista';
    const EDITAR = 'editar';
    const INSERTAR = 'insertar';
    const ELIMINAR = 'eliminar';

    function __construct()
    {
        parent::__construct();
        $this->load->model('docente_model', 'docente');
    }

    public function index()
    {
        $output = array();
        $vista = $this->load->view('docente/docentes.tpl.php', $output, true);
        $this->template->setTitle("Registro de actividad docente");
        $this->template->setMainContent($vista);
        $this->template->getTemplate();
    }

    public function exportar_datos($area = null)
    {
        //Columnas
        $columnas = array(
            'Matrícula', 'Nombre',
            'Rol', 'Delegación',
            'Tipo de curso', //'Curso', 'Rol',
            'Clave curso', 'Curso', 'Área de enfoque', 'Modalidad',
            'Tipo de actividad',
            'Clave de categoría', 'Categoría',
            'Clave de unidad', 'Unidad'
        );

        $id_usuario = $this->get_datos_sesion(En_datos_sesion::ID_USUARIO);
//        $id_unidad_instituto = $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO);
//        $clave_unidad = $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD);
         
        $tmp = '(N.clave_unidad=\'' . $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD) . '\' or D.id_unidad_instituto=' . $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO) . ')';
        $filtros[$tmp] = null;
        //Carga modelo de modulos
        $this->load->library('LNiveles_acceso');
        $this->load->model('Modulo_model', 'modulo');
        $niveles = $this->modulo->get_niveles_acceso($id_usuario, 'usuario');
        if ($this->lniveles_acceso->nivel_acceso_valido(array(LNiveles_acceso::Super, LNiveles_acceso::Admin), $niveles))
        {//Valida un nivel central
//            unset($filtros['D.id_unidad_instituto']); //Quita el filtro para que se exporten todos los datos
//            $clave_unidad = null;//Quita el filtro de clave de unidad
            unset($filtros[$tmp]); //Quita el filtro para que se exporten todos los datos
        }

        if (!is_null($area))
        {
            $filtros['T.id_area_enfoque'] = $area;
        }
        $file_name = 'registros_docentes_cursos_' . date('Ymd_his', time());
        $resultado = $this->docente->get_datos_curso($filtros);
//        exit();
        $this->exportar_xls($columnas, $resultado, null, null, $file_name);
    }

    public function registros($accion = Docente::LISTA, $area = null)
    {
        $resultado = array();
        switch ($accion)
        {
            case Docente::LISTA:
                $id_unidad_instituto = $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO);
                $id_usuario = $this->get_datos_sesion(En_datos_sesion::ID_USUARIO);
                $clave_unidad = $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD);

                //pr($id_unidad_instituto);
                //pr($id_usuario);
                //pr($clave_unidad);

                $filtros = null;
                $tam = null;
                $inicio = null;

                if (!is_null($area))
                {
                    $get = $this->input->get(null, true);
                    //pr($get);

                    $this->load->library('LNiveles_acceso');
                    $filtros = array('id_area_enfoque' => $area);

                    $this->load->model('Modulo_model', 'modulo');
                    $niveles = $this->modulo->get_niveles_acceso($id_usuario, 'usuario');
                    $acceso = $this->lniveles_acceso->nivel_acceso_valido(array(LNiveles_acceso::Super, LNiveles_acceso::Admin), $niveles);

                    $filtros['acceso'] = $acceso;
                    if (!$acceso)
                    {
                        $filtros['id_unidad_instituto'] = $id_unidad_instituto;
                        $filtros['clave_unidad'] = $clave_unidad;
                    }

                    if (isset($get['pageIndex']) && isset($get['pageSize']))
                    {
                        if ($get['pageIndex'] != '' && $get['pageSize'] != '')
                        {
                            $tam = $get['pageSize'];
                            $inicio = ($get['pageIndex'] - 1) * $tam;
                        }
                    }

                    $columnas_get = array('matricula', 'delegacion', 'rol', 'tipo_curso', 'curso');
                    $columnas_upper = array('nombre_completo', 'clave_unidad', 'unidad', 'clave_categoria', 'categoria');

                    foreach ($columnas_get as $key => $value)
                    {
                        if (isset($get[$value]))
                        {
                            if ($get[$value] != '')
                            {
                                $filtros[$value] = $get[$value];
                            }
                        }
                    }

                    foreach ($columnas_upper as $key => $value)
                    {
                        if (isset($get[$value]))
                        {
                            if ($get[$value] != '')
                            {
                                $filtros[$value] = strtoupper($get[$value]);
                            }
                        }
                    }
                }

                $resultado['data'] = $this->docente->get_docentes($filtros, $inicio, $tam);

                $resultado['length'] = $this->docente->numero_total_registros($filtros);

                break;

            case Docente::INSERTAR:
                $id_unidad_instituto = $this->get_datos_sesion(En_datos_sesion::ID_UNIDAD_INSTITUTO);
                $id_usuario = $this->get_datos_sesion(En_datos_sesion::ID_USUARIO);
                $clave_unidad = $this->get_datos_sesion(En_datos_sesion::CLAVE_UNIDAD);

                $this->load->library('LNiveles_acceso');
                $this->load->model('Modulo_model', 'modulo');
                $niveles = $this->modulo->get_niveles_acceso($id_usuario, 'usuario');
                $acceso = $this->lniveles_acceso->nivel_acceso_valido(array(LNiveles_acceso::Super, LNiveles_acceso::Admin), $niveles);

                $post = $this->input->post(null, true);
                //pr($post);

                $matricula = $post['matricula'];
                $curso = $post['curso'];
                $delegacion = $post['delegacion'];
                $rol = $post['rol'];

                if ((!is_null($matricula) || $matricula != '') && (!is_null($curso) || $curso != '') &&
                        (!is_null($delegacion) || $delegacion != '') && (!is_null($rol) || $rol != ''))
                {

                    if (strlen($matricula) > 15)
                    {
                        $resultado = array("success" => false, "message" => "La matrícula cuenta con menos de 15 caracteres", "data" => []);
                    } else
                    {
                        if ($this->docente->existe_docente($matricula))
                        {

                            $insert = array(
                                'matricula' => $matricula,
                                'clave_curso' => $curso,
                                'id_rol' => $rol,
                                'delegacion' => $delegacion
                            );

                            if (!$acceso)
                            {
                                $insert['id_unidad_instituto'] = $id_unidad_instituto;
                            }

                            if (!$this->docente->existe_registro($matricula, $curso))
                                $resultado = $this->docente->insert($insert);
                            else
                                $resultado = array("success" => false, "message" => "Ya existe ese registro", "data" => []);
                        }else
                        {
                            $resultado = array("success" => false, "message" => "No se ha encontrado la matrícula " . $matricula . ". Favor de verificar.");
                        }
                    }
                } else
                {
                    $resultado = array("success" => false, "message" => "Falta información", "data" => []);
                }
                break;

            case Docente::EDITAR:
                $post = $this->input->post(null, true);
                //pr($post);
                $matricula = $post['matricula'];
                $curso = $post['curso'];
                $delegacion = $post['delegacion'];
                $rol = $post['rol'];
                $id_registro = $post['id_registro_docente'];

                unset($post['id_registro_docente']);

                if ((!is_null($matricula) || $matricula != '') && (!is_null($curso) || $curso != '') &&
                        (!is_null($delegacion) || $delegacion != '') && (!is_null($rol) || $rol != '') &&
                        (!is_null($id_registro) || $id_registro != ''))
                {

                    if (strlen($matricula) > 15)
                    {
                        $resultado = array("success" => false, "message" => "La matrícula cuenta con menos de 15 caracteres", "data" => []);
                    } else
                    {
                        if ($this->docente->existe_docente($matricula))
                        {
                            $values = array(
                                'matricula' => $matricula,
                                'id_rol' => $rol,
                                'delegacion' => $delegacion,
                                'clave_curso' => $curso
                            );

                            if (!$this->docente->existe_registro($matricula, $post['curso'], $id_registro))
                            {
                                $resultado = $this->docente->update($id_registro, $values);
                            } else
                            {
                                $data = $this->docente->get_docentes(array('id_registro_docente' => $id_registro));
                                $data = $data[0];
                                $resultado = array("success" => false, "message" => "Ya existe ese registro", "data" => $data);
                            }
                        } else
                        {
                            $resultado = array("success" => false, "message" => "No se ha encontrado la matrícula " . $matricula . ". Favor de verificar.");
                        }
                    }
                } else
                {
                    $resultado = array("success" => false, "message" => "Falta información", "data" => []);
                }

                break;

            case Docente::ELIMINAR:
                $post = $this->input->post(null, true);
                $id_registro = $post['id_registro_docente'];
                $resultado = $this->docente->delete($id_registro);
                break;
        }

        header('Content-Type: application/json; charset=utf-8;');
        echo json_encode($resultado);
    }

}

?>