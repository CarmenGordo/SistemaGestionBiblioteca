<?php
class Libro {
    private $conn;
    private $tabla = "libros";

    public $id;
    public $titulo;
    public $autor;
    public $genero;
    public $estado;
    public $fecha_prestamo;

    function __construct($db) {
        $this->conn = $db;
    }

    function leer(){

		if (!empty($this->titulo)) {
            
			$stmt = $this->conn->prepare("
			    SELECT * FROM " . $this->tabla . " WHERE titulo = ?");
			$stmt->bind_param("s", $this->titulo);

		} else {
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->tabla);
		}

		$stmt->execute();
		$result = $stmt->get_result();

		return $result;
	}

    function anadir() {
        
        if (!$this->validarEstado($this->estado)) {
            //echo"El estado solo puede ser disponible o prestado. No puede ser: ".$this->estado;
            return false;
        }

        $stmt = $this->conn->prepare("
        INSERT INTO " . $this->tabla . " (`titulo`, `autor`, `genero`, `estado`, `fecha_prestamo`) 
        VALUES (?,?,?,?,?)");
        
        
        $this->titulo = strip_tags($this->titulo);
        $this->autor = strip_tags($this->autor);
        $this->genero = strip_tags($this->genero);
        $this->estado = strip_tags($this->estado);
        $this->fecha_prestamo = strip_tags($this->fecha_prestamo);

        $stmt->bind_param("sssss", $this->titulo, $this->autor, $this->genero, $this->estado, $this->fecha_prestamo);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function validarEstado($estado) {

        $validEstados = ['disponible', 'prestado'];
        return in_array($estado, $validEstados);
    }


    function editar() {

        if (!$this->validarEstado($this->estado)) {
            //echo"El estado solo puede ser disponible o prestado. No puede ser: ".$this->estado;
            return false;
        }

        $stmt = $this->conn->prepare("
            UPDATE " . $this->tabla . " SET titulo = ?, autor=?, genero=?, fecha_prestamo =?
            WHERE id = ? OR titulo = ?");

        $this->titulo = strip_tags($this->titulo);
        $this->autor = strip_tags($this->autor);
        $this->genero = strip_tags($this->genero);
        $this->estado = strip_tags($this->estado);
        $this->fecha_prestamo = strip_tags($this->fecha_prestamo);
        $this->id = strip_tags($this->id);

        $stmt->bind_param("sssssis", $this->titulo, $this->autor, $this->genero, $this->fecha_prestamo, $this->id, $this->titulo);

        if ($stmt->execute()) {
            //si no afecta a ninguna fila
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                //echo "No se ha encontrado libros con esos datos: " . $stmt->error;
                return false;
            }
        }
        return false;
    }

    function borrar() {
        $stmt = $this->conn->prepare("
            DELETE FROM " . $this->tabla . "
            WHERE id = ? OR titulo = ?");

        $this->id = strip_tags($this->id);
        $this->titulo = strip_tags($this->titulo);

        $stmt->bind_param("is", $this->id, $this->titulo);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>
