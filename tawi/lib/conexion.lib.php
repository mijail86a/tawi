<?php
class conexion{
	/*
    private $host = "localhost";
    private $usuario = "edigital_user";
    private $clave = "2018*3d1g1t4l_11";
    private $database = "edigital_plan4us";
	*/
    private $host = "192.168.1.248";
    private $usuario = "tawi_admin";
    private $clave = "7Mdt&viY!X#-";
    private $database = "tawi_qas";
    public $conexion;
    
    function __construct(){
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->database);
        
        if ($this->conexion->connect_errno){
            echo "Fallo al conectar a MySQL: ". $this->conexion->connect_error;
            return;
        }
        $this->conexion->set_charset("utf8");
    }
}