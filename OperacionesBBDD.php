<?php
/*JOSEMIGUEL MORUNO GOMEZ*/
    class OperacionesBBDD
    {
        var $host;
        var $user;
        var $pass;
        var $bbdd;
        var $resultado;
        public $conexion;

        function __construct(){
            $this->host="localhost";
            $this->user="root";
            $this->pass="";
            $this->bbdd="escueladeportivadaw";
            /*meto qui la conexion para que se conecte cuando instancie el objeto*/
            $this->conexion=new mysqli($this->host, $this->user, $this->pass, $this->bbdd);

        }

        //Consultar la BD con METODO query
        function consultarBD($consulta){
            $this->resultado=$this->conexion->query($consulta);
        }

        //Devuelve una a una las filas de la consulta //METODO fetch_array()
        function devolverFilas(){
            return $this->resultado->fetch_array();
        }

        //Devuelve la cantidad de filas devueltas en la ultima consulta //ATRIBUTO num_rows;
        function numeroFilas(){
            return $this->resultado->num_rows; //es atributo no hay q pasarle nada
        }

        //Devuelve la cantidad de filas afectadas en la ultima consulta
        function filasAfectadas(){
            return $this->conexion->affected_rows;
        }
        //Devuelve un texto de error personalizado
        function comprobarError(){
            switch($this->conexion->errno)
            {
                case 0:
                    break;
                case 1062:
                    return "Ya existe un campo con ese nombre en nuestra BD";
                    break;
                case 1048:
                    return "Algun campo esta vacio";
                    break;
                case 1451:
                    return "Tiene hijos en otras tablas"; //caso del los delete o update sin cascade
                default:
                    return "Error al realizar la operacion";
            }
        }


    }
?>