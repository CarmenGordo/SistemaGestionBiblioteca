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

if (isset($datos->titulo)) {

    $libro->titulo = $datos->titulo;
    $resultado = $libro->leer();

    if ($resultado->num_rows > 0) {
        $libroEncontrado = $resultado->fetch_assoc();
        http_response_code(200);
        echo json_encode($libroEncontrado);
        exit();
    } else {
        http_response_code(404);
        echo json_encode(["mensaje" => "No se encontró el libro con el título especificado."]);
        exit();
    }

} else {
    // si no lee todos
    $resultado = $libro->leer();

    if ($resultado->num_rows > 0) {
        $libros = [];
        while ($fila = $resultado->fetch_assoc()) {
            $libros[] = $fila;
        }
        http_response_code(200);
        echo json_encode($libros);
        exit();
    } else {
        http_response_code(404);
        echo json_encode(["mensaje" => "No se encontraron libros en la base de datos."]);
        exit();
    }
}
?>
