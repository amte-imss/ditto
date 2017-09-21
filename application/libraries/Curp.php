<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase para identificar información del empleado con base en la CURP
 * @version 	: 1.0.0
 * @author      : Guagnelli Mike
 **/
class Curp {
   
    private $curp;
    private $genero;
    private $fecha_nac;
    private $edad;
    
    public function __construct($param=null) {
    	$this->CI =& get_instance();
//        pr($param);
        if(!is_null($param)){
            $this->curp = $param['curp'];
            $this->_explodeCURP();
        }
    }
    
    function _explodeCURP(){
        if(strlen($this->curp) < 10){
            return false;
        }
        $day = substr($this->curp,8,6);
        $month = substr($this->curp,6,2);
        $year = strftime("%Y",strtotime("1/1/".substr($this->curp,4,2)));
        //echo date("Y");
        $this->fecha_nac = strtotime("{$year}/{$month}/{$day}"); 
        $this->edad = date("Y")-$year;
        $this->genero = substr($this->curp,10,1);        
    }
    
    public function setCURP($curp){
        $this->curp = $curp;
        if(!$this->_explodeCURP()){
            return false;
        }
        return true;
    }
    
    public function getGenero(){
        if(is_null($this->genero)){
            return false;
        }
        $genero = array("H"=>"Masculino","M"=>"Femenino");
        return $genero[strtoupper($this->genero)];
    }
    
    public function getEdad(){
        return $this->edad;
    }
    
    public function getFechaNac(){
        return $this->fecha_nac;
    }
}  