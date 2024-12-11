<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../ConexionBD.php';
include_once '../Libro.php';

$bd = new ConexionBD();
$conex = $bd->dameConexion();
$libro = new Libro($conex);

$datos = json_decode(file_get_contents("php://input"));

if (isset($datos->id) || isset($datos->titulo)) {

    if (isset($datos->id)) {
        $libro->id = $datos->id;
    }
    if (isset($datos->titulo)) {
        $libro->titulo = $datos->titulo;
    }
    if (isset($datos->autor)) {
        $libro->autor = $datos->autor;
    }
    if (isset($datos->genero)) {
        $libro->genero = $datos->genero;
    }
    if (isset($datos->estado)) {
        $libro->estado = $datos->estado;
    }
    if (isset($datos->fecha_prestamo)) {
        $libro->fecha_prestamo = $datos->fecha_prestamo;
    }

    if (isset($datos->estado) && !$libro->validarEstado($libro->estado)) {
        http_response_code(400);
        echo json_encode(["mensaje" => "El estado solo puede ser 'disponible' o 'prestado'."]);
        exit();
    }

    if ($libro->editar()) {
        http_response_code(200);
        echo json_encode(["mensaje" => "Libro actualizado exitosamente."]);
        exit();
    } else {
        http_response_code(404);
        echo json_encode(["mensaje" => "No se encontró el libro o no se pudo actualizar."]);
        exit();
    }
} else {
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan datos necesarios para actualizar el libro."]);
    exit();
}
?>
