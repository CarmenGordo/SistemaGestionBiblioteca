<?php
class ConexionBD
{
    // se esta usando "LAMP 2"
	private $host = 'localhost';
	private $user = 'admin';
    //private $port = '3308';  
	private $password = 'Emis0KbKa4G3';
	private $bd = 'sistema_gestion_biblioteca';

	public function dameConexion(){
		
		try {
            $conn = new mysqli($this->host, $this->user, $this->password, $this->bd);

            //comprobar conexion
            if ($conn->connect_error) {
                throw new Exception("Error al conectar con MYSQL: " . $conn->connect_error);
            }

            //Config utf8
            $conn->set_charset("utf8");
			//echo "Conexion hecha a la base de datos!!!  \n";

            return $conn;
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            die("Error al conectar a la base de datos");
        }
	}
}

$ConexionBD = new ConexionBD();
$ConexionBD->dameConexion();
?>