<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends MY_Model
{
    
    const LIMIT = 10, LISTA = 'lista', BASICOS = 'basico', PASSWORD = 'password',
            NIVELES_ACCESO = 'niveles';

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function nuevo(&$parametros = null)
    {
        $salida['msg'] = 'Error';
        $salida['result'] = false;


        $token = $this->seguridad->folio_random(10, TRUE);
        $pass = $this->seguridad->encrypt_sha512($token . $parametros['password'] . $token);
        $usuario = $this->empleados_siap->buscar_usuario_siap($parametros['delegacion'], $parametros['matricula']);
//        pr($usuario);
        $params['where'] = array(
            'docentes.matricula' => $usuario['empleado']['matricula'][0]
        );
        $usuario_db = count($this->get_usuarios($params)) == 0;
        if ($usuario && $usuario_db && $usuario['tp_msg'] == En_tpmsg::SUCCESS)
        {
            $usuario = $usuario['empleado'];
            $unidad_instituto = $this->get_unidad($usuario['adscripcion'][0]);
            $categoria = $this->get_categoria($usuario['emp_keypue'][0]);
            if ($unidad_instituto == null)
            {
                $unidad_instituto = $this->localiza_unidad($usuario['adscripcion'][0]);
            }
            if ($unidad_instituto != null)
            {
                $data['usuario'] = array(
                    'password' => $pass,
                    'token' => $token,
                );
                $data['docente'] = array(
                    'email' => $parametros['email'],
                    'matricula' => $parametros['matricula'],
                    'nombre' => $usuario['nombre'][0],
                    'apellido_p' => $usuario['paterno'][0],
                    'apellido_m' => $usuario['materno'][0],
                    'curp' => $usuario ['curp'],
                    'sexo' => $usuario['sexo'],
                    'rfc' => $usuario['rfc'][0],
                    'status_siap' => 1
                );
                $data['historico'] = array(
                    'actual' => 1,
                    'id_categoria' => $categoria['id_categoria'],
                    'id_departamento_instituto' => $unidad_instituto['id_departamento_instituto']
                );
                //pr($data);
                $salida = $this->insert_guardar($data, $parametros['grupo']);
                if ($salida['result'] && isset($parametros['registro_usuario']))
                {
                    $this->load->model('Plantilla_model', 'plantilla');
                    //$this->plantilla->send_mail(Plantilla_model::BIENVENIDA_REGISTRO, $parametros);
                }
                $salida['siap'] = $data;
            } else
            {
                $salida['msg'] = 'Adcripción no localizada en la base de datos';
            }
        } else if (!$usuario_db)
        {
            $salida['msg'] = 'Usuario ya registrado';
        } else if (!$usuario || $usuario['tp_msj'] != En_tpmsg::SUCCESS)
        {
            $salida['msg'] = 'Usuario no registrado en SIAP';
        }
        return $salida;
    }

    public function carga_masiva(&$csv_array)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin(); //Definir inicio de transacción
        $registros = [];
        $errores_presentes = false;
        foreach ($csv_array as $row)
        {
            if (isset($row['matricula']) && isset($row['delegacion']) && isset($row['nivel_acceso']) && isset($row['email']))
            {
                $clave_delegacional = $this->get_delegacion($row['delegacion'])['clave_delegacional'];
                $data = array(
                    "reg_delegacion" => $clave_delegacional,
                    "asp_matricula" => $row['matricula']
                );
                $usuario = $this->empleados_siap->buscar_usuario_siap($data);
                $params['where'] = array(
                    'docentes.matricula' => $row['matricula']
                );
                $usuario_db = count($this->get_usuarios($params)) == 0;
                if ($usuario && $usuario_db && $usuario['tp_msg'] == En_tpmsg::SUCCESS)
                {
                    $unidad_instituto = $this->get_unidad($usuario['adscripcion'][0]);
                    $categoria = $this->get_categoria($usuario['emp_keypue'][0]);
                    if ($unidad_instituto == null)
                    {
                        $unidad_instituto = $this->localiza_unidad($usuario['adscripcion'][0]);
                    }
                    if ($unidad_instituto != null)
                    {
		                $token = $this->seguridad->folio_random(10, TRUE);
		                $password = $this->seguridad->folio_random(10, TRUE);
		                $pass = $this->seguridad->encrypt_sha512($token . $password . $token);
                        $data['usuario'] = array(
                            'password' => $pass,
                            'token' => $token,
                        );
                        $data['docente'] = array(
                            'email' => $row['email'],
                            'matricula' => $row['matricula'],
                            'nombre' => $usuario['nombre'][0],
                            'apellido_p' => $usuario['paterno'][0],
                            'apellido_m' => $usuario['materno'][0],
                            'curp' => $usuario ['curp'],
                            'sexo' => $usuario['sexo'],
                            'rfc' => $usuario['rfc'][0],
                            'status_siap' => 1
                        );
                        $data['historico'] = array(
                            'actual' => 1,
                            'id_categoria' => $categoria['id_categoria'],
                            'id_departamento_instituto' => $unidad_instituto['id_departamento_instituto']
                        );
                        //pr($data);
                        $this->insert_guardar($data, $row['nivel_acceso']);
                    }
                }
            }else
            {
                $errores_presentes = true;
                $row['errores'] = 'Datos de matricula, grupo y delegacion inválidos';
            }
             $registros[] = $row;
        }
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $registros[] = 'Error en la transaccion';
            $resultado['msg'] = "Ocurrió un error durante el guardado, por favor intentelo de nuevo más tarde.";
        } else
        {
            $this->db->trans_commit();
            $resultado['msg'] = 'Usuarios almacenado con éxito';
            if ($errores_presentes)
            {
                $resultado['msg'] = 'Se presentaron errores durante el registro';
            }
            $resultado['result'] = TRUE;
        }
        $resultado['data'] = $registros;
        //pr($resultado);
        return $resultado;
    }

    private function get_unidad($clave)
    {
        $unidad = null;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->where('clave_departamental', $clave);
        $resultado = $this->db->get('catalogo.departamentos_instituto')->result_array();
        if ($resultado)
        {
            $unidad = $resultado[0];
        }
        return $unidad;
    }

    private function get_categoria($clave)
    {
        $categoria = null;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->where('clave_categoria', $clave);
        $resultado = $this->db->get('catalogo.categorias')->result_array();
        if ($resultado)
        {
            $categoria = $resultado[0];
        }
        return $categoria;
    }

    private function insert_guardar(&$datos, $id_grupo, $transaccion = true)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        if ($transaccion)
        {
	        $this->db->trans_begin(); //Definir inicio de transacción
		}
        $this->db->insert('censo.docente', $datos['docente']);

        $datos['usuario']['id_docente'] = $this->db->insert_id();
        $this->db->insert('sistema.usuarios', $datos['usuario']); //nombre de la tabla en donde se insertaran
        $id_usuario = $this->db->insert_id();
        $data = array(
            'id_rol' => $id_grupo,
            'id_usuario' => $id_usuario
        );
        $this->db->insert('sistema.usuario_rol', $data);
        $datos['historico']['id_docente'] = $datos['usuario']['id_docente'];
        $this->db->insert('censo.historico_datos_docente', $datos['historico']);
        //pr($this->db->last_query());
        //pr($datos);
        $resultado = null;
        if ($transaccion)
        {
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $resultado['result'] = FALSE;
                $resultado['msg'] = "Ocurrió un error durante el guardado, por favor intentelo de nuevo más tarde.";
            } else
            {
                $this->db->trans_commit();
                $resultado['msg'] = 'Usuario almacenado con éxito';
                $resultado['result'] = TRUE;
            }
        }
        return $resultado;
    }

    private function localiza_unidad($clave)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $unidad = null;
        if (strlen($clave) > 7)
        {
            $busqueda = substr($clave, 0, 7);
            $this->db->like('clave_unidad', $clave, 'after');
            $resultado = $this->db->get('catalogo.unidades_instituto')->result_array();
            if ($resultado)
            {
                $unidad = $resultado[0];
            }
        }
        return $unidad;
    }

    public function get_usuarios($params = [])
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $usuarios = [];
        if (isset($params['total']))
        {
            $select = 'count(*) total';
        } else
        {
            if (isset($params['select']))
            {
                $select = $params['select'];
            } else
            {
                $select = array(
                    'usuarios.id_usuario', 'docentes.id_docente', 'docentes.matricula', 'docentes.email'
                    , 'concat("docentes".nombre, $$ $$, "docentes".apellido_p, $$ $$, "docentes".apellido_m) nombre_completo'
                );
            }
        }
        $this->db->select($select);
        $this->db->from('sistema.usuarios usuarios');
        $this->db->join('censo.docente docentes', 'docentes.id_docente = usuarios.id_docente', 'inner');
        $this->db->join('censo.historico_datos_docente C', 'C.id_docente = docentes.id_docente and C.actual = 1', 'inner');
        $this->db->join('catalogo.departamentos_instituto D', 'D.id_departamento_instituto = C.id_departamento_instituto', 'left');
        $this->db->join('catalogo.unidades_instituto E', 'E.id_unidad_instituto = D.id_unidad_instituto', 'left');
        $this->db->join('catalogo.categorias F', ' F.id_categoria = C.id_categoria', 'left');
        $this->db->join('catalogo.delegaciones G', 'G.id_delegacion = E.id_delegacion', 'left');

        if (isset($params['where']))
        {
//            pr($params['where']);            
            $this->db->where($params['where']);
        }
        if (isset($params['like']))
        {
            if (isset($params['like']['nombre_completo']))
            {
                $params['like']['concat("docentes".nombre, $$ $$, "docentes".apellido_p, $$ $$,"docentes".apellido_m)'] = $params['like']['nombre_completo'];
                unset($params['like']['nombre_completo']);
            }
            $this->db->like($params['like']);
        }
        if (isset($params['limit']) && isset($params['offset']) && !isset($params['total']))
        {
            $this->db->limit($params['limit'], $params['offset']);
        } else if (isset($params['limit']) && !isset($params['total']))
        {
            $this->db->limit($params['limit']);
        }
        if (isset($params['order_by']) && !isset($params['total']))
        {
            $order = $params['order_by'] == 'desc' ? $params['order_by'] : 'asc';
            $this->db->order_by('docentes.matricula', $order);
        }
        $query = $this->db->get();
        if ($query)
        {
            $usuarios = $query->result_array();
            $query->free_result(); //Libera la memoria 
        }
        //pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();
        return $usuarios;
    }

    public function get_niveles_acceso($id_usuario)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'A.id_rol', 'A.nombre', 'B.activo'
        );
        $this->db->select($select);
        $this->db->join('sistema.usuario_rol B', " B.id_rol = A.id_rol and B.id_usuario = {$id_usuario}", 'left');
        $query = $this->db->get('sistema.roles A');
        if ($query)
        {
            $niveles = $query->result_array();
            $query->free_result(); //Libera la memoria 
        }
        $this->db->flush_cache();
        $this->db->reset_query();
        return $niveles;
    }

    public function update($tipo = Usuario_model::BASICOS, $params = [])
    {
        $salida = false;
        switch ($tipo)
        {
            case Usuario_model::BASICOS:
                $salida = $this->update_basicos($params);
                break;
            case Usuario_model::PASSWORD:
                $salida = $this->update_password($params);
                break;
            case Usuario_model::NIVELES_ACCESO:
                $salida = $this->update_niveles_acceso($params);
                break;
        }
        return $salida;
    }

    private function update_basicos($params = [])
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $salida = false;
        $this->db->trans_begin();
        $params['where'] = array(
            'usuarios.id_usuario' => $params['id_usuario']
        );
        $resultado = $this->usuario->get_usuarios($params);
        if (count($resultado) == 1)
        {
            $usuario = $resultado[0];
            $docente = array(
                'curp' => $params['curp'],
                'sexo' => $params['sexo'],
                'rfc' => $params['rfc'],
                'email' => $params['email'],
                'nombre' => $params['nombre'],
                'apellido_p' => $params['apellido_p'],
                'apellido_m' => $params['apellido_m'],
                'telefono_particular' => $params['telefono_particular'],
                'telefono_laboral' => $params['telefono_laboral'],
                'fecha_nacimiento' => $params['fecha_nacimiento']
            );
            $this->db->start_cache();
            $this->db->where('id_docente', $usuario['id_docente']);
            $this->db->stop_cache();
            $this->db->update('censo.docente', $docente);
            $this->db->reset_query();
            $this->db->set('actual', 0);
            $this->db->update('censo.historico_datos_docente');
            //pr($this->db->last_query());
            $this->db->flush_cache();
            $this->db->reset_query();
            $historico = array(
                'id_docente' => $usuario['id_docente'],
                'actual' => 1,
                'id_categoria' => $params['categoria'],
                'id_departamento_instituto' => $params['departamento']
            );
            $this->db->insert('censo.historico_datos_docente', $historico);
        }
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $salida = false;
        } else
        {
            $this->db->trans_commit();
            $salida = true;
        }
        $this->db->flush_cache();
        $this->db->reset_query();
        return $salida;
    }

    private function update_password($datos = null)
    {
        $salida = false;
        try
        {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select('token');
            $this->db->where('id_usuario', $datos['id_usuario']);
            $resultado = $this->db->get('sistema.usuarios')->result_array();
            //pr($datos);
            //pr($this->db->last_query());
            if ($resultado)
            {
                $this->load->library('seguridad');
                $token = $resultado[0]['token'];
                $this->db->reset_query();
                $password = $this->seguridad->encrypt_sha512($token . $datos['pass'] . $token);
                $this->db->set('password', $password);
                $this->db->where('id_usuario', $datos['id_usuario']);
                $this->db->update('sistema.usuarios');
//                pr($this->db->last_query());
                $salida = true;
            } else
            {
                // pr('usuario no localizado');
            }
        } catch (Exception $ex)
        {
            //  pr($ex);
        }
        $this->db->flush_cache();
        $this->db->reset_query();
        return $salida;
    }

    private function update_niveles_acceso($params = [])
    {
        $this->load->model('Administracion_model', 'admin');
        $id_usuario = $params['id_usuario'];
        $grupos = $this->admin->get_niveles_acceso();
//        pr($grupos);
        $this->db->trans_begin();
        foreach ($grupos as $grupo)
        {
            $id_grupo = $grupo['id_grupo'];
            $activo = (isset($params['activo' . $id_grupo])) ? true : false;
            $this->upsert_usuario_nivel_acceso($id_usuario, $id_grupo, $activo);
        }
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $status = false;
        } else
        {
            $this->db->trans_commit();
            $status = true;
        }
        return $status;
    }

    private function upsert_usuario_nivel_acceso($id_usuario, $id_grupo, $activo)
    {
        if ($id_grupo > 0 && $id_usuario > 0)
        {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select('count(*) cantidad');
            $this->db->start_cache();
            $this->db->where('id_rol', $id_grupo);
            $this->db->where('id_usuario', $id_usuario);
            $this->db->stop_cache();
            $existe = $this->db->get('sistema.usuario_rol')->result_array()[0]['cantidad'] != 0;
            if ($existe)
            {
                $this->db->set('activo', $activo);
                $this->db->update('sistema.usuario_rol');
//                pr($this->db->last_query());
            } else
            {
                $this->db->flush_cache();
                $insert = array(
                    'id_usuario' => $id_usuario,
                    'id_rol' => $id_grupo,
                    'activo' => $activo
                );
                $this->db->insert('sistema.usuario_rol', $insert);
            }
        }
        $this->db->flush_cache();
        $this->db->reset_query();
    }

    public function datos_generales_docente($params)
    {
        $this->db->where('matricula', $params['matricula']);
        $query = $this->db->get('censo.docente');
        $this->db->flush_cache(); // limpiamos la cache
        $resultado = $query->free_result(); //Libera la memoria 
        return $resultado;
    }

    public function datos_imss_docente($parametros)
    {

        /*
          select * from censo.docente
          left join censo.historico_datos_docente on (censo.historico_datos_docente.id_docente=censo.docente.id_docente and actual=1)
          inner join catalogo.delegaciones on catalogo.delegaciones.clave_delegacional = censo.historico_datos_docente.clave_delegacional
          inner join catalogo.categorias on catalogo.categorias.clave_categoria= historico_datos_docente.clave_categoria
          left join catalogo.departamentos_instituto on catalogo.departamentos_instituto.clave_departamental= historico_datos_docente.clave_departamental
          left join catalogo.unidades_instituto on catalogo.unidades_instituto.id_unidad_instituto=catalogo.departamentos_instituto.id_unidad_instituto
          where matricula='99095896'
         */



        $this->db->where('matricula', $params['matricula']);
        $this->db->join('censo.historico_datos_docente hd ', 'hd.id_docente=c.docente.id_docente', 'left');
        $this->db->join('catalogo.delegaciones cd ', 'cd.clave_delegacional = ch.clave_delegacional');
        $this->db->join('catalogo.categorias cc ', 'cc.clave_categoria= hd.clave_categoria');
        $this->db->join('catalogo.departamentos_instituto cdep ', 'cdep.clave_departamental= hd.clave_departamental', 'left');
        $this->db->join('catalogo.unidades_instituto cuni ', 'cuni.id_unidad_instituto=cdep.id_unidad_instituto', 'left');

        $query = $this->db->get('censo.docente c');

        $this->db->flush_cache(); // limpiamos la cache
        $resultado = $query->free_result(); //Libera la memoria 

        return $resultado;
    }

    /**
     * @author LEAS
     * @fecha 05/07/2017
     * @param type $id_user
     * @param type $id_file identificador del archivo 
     * @return type array 'tp_msg' success si tuvo exito la transacción; danger 
     * si ocurrio un rollback o un error
     */
    public function delete_foto_perfil($id_user, $id_file)
    {
        $this->db->trans_begin();

        $this->db->where('id_usuario', $id_user);
        $this->db->where('id_file', $id_file);
        $this->db->update('sistema.usuarios', array('id_file' => null));


        if ($this->db->trans_status() === FALSE)
        {//ocurrio un error 
            $this->db->trans_rollback();
            $respuesta = array('tp_msg' => En_tpmsg::DANGER, 'mensaje' => '');
        } else
        {
            $this->db->where('id_file', $id_file);
            $this->db->delete('censo.files');
            if ($this->db->trans_status() === FALSE)
            {//ocurrio un error 
                $this->db->trans_rollback();
                $respuesta = array('tp_msg' => En_tpmsg::DANGER, 'mensaje' => '');
            } else
            {
                $this->db->trans_commit();
                $respuesta = array('tp_msg' => En_tpmsg::SUCCESS, 'mensaje' => '');
            }
        }
        return $respuesta;
    }

}
