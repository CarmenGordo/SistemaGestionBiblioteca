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

if (isset($datos->titulo) && isset($datos->autor) && isset($datos->genero) && isset($datos->estado)) {
    $libro->titulo = $datos->titulo;
    $libro->autor = $datos->autor;
    $libro->genero = $datos->genero;
    $libro->estado = $datos->estado;
    $libro->fecha_prestamo = $datos->fecha_prestamo;

    if (!$libro->validarEstado($libro->estado)) {
        http_response_code(400);
        echo json_encode(["mensaje" => "El estado solo puede ser 'disponible' o 'prestado'."]);
        exit();
    }

    if ($libro->anadir()) {
        http_response_code(200);
        echo json_encode(["mensaje" => "Libro añadido exitosamente."]);
        exit();
    } else {
        http_response_code(503);
        echo json_encode(["mensaje" => "No se pudo crear el libro. Error en la base de datos."]);
        exit();
    }
} else {
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan datos necesarios para crear el libro."]);
    exit();
}
?>
