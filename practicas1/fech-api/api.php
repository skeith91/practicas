<?php

// === CORS (ajusta el ORIGIN a tu frontend) ===
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowed = [
  'http://127.0.0.1:5500',
  'http://localhost:5500',
  'http://localhost',
];

if (in_array($origin, $allowed, true)) {
  header("Access-Control-Allow-Origin: $origin");
  header('Vary: Origin'); // para caches
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Si harás fetch con credentials (cookies/Authorization), descomenta:
// header('Access-Control-Allow-Credentials: true');

// Preflight para OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

// A partir de aquí tu lógica normal:
header('Content-Type: application/json; charset=utf-8');


// Conexión MySQL
$conexion = new mysqli("localhost", "root", "", "prueba");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta
$resultado = $conexion->query("SELECT id, user, nombre, email FROM users");

// Crear arreglo
$usuarios = [];
while ($fila = $resultado->fetch_assoc()) {
    $usuarios[] = $fila;
}

// Devolver JSON
header('Content-Type: application/json');
echo json_encode($usuarios);
