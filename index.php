<?php
header("Content-Type: application/json");

require_once 'product.php';

// Obtener el método de la solicitud
$method = $_SERVER['REQUEST_METHOD'];

// Verificamos si se pasa el recurso en los parámetros GET
$resource = isset($_GET['resource']) ? $_GET['resource'] : '';

if ($resource != 'products') {
    echo json_encode(['message' => 'Resource not found']);
    http_response_code(404);
    exit;
}

$product = new Product();

// Lógica según el método HTTP
switch ($method) {
    case 'GET':
        // Si se pasa un ID en la URL, devolver un producto específico
        if (isset($_GET['id'])) {
            echo $product->getProduct($_GET['id']);
        } else {
            // Si no se pasa un ID, devolver todos los productos
            echo $product->getAllProducts();
        }
        break;

    case 'POST':
        // Crear un nuevo producto, los datos se reciben como JSON
        $input = json_decode(file_get_contents('php://input'), true);
        echo $product->createProduct($input);
        break;

    case 'PUT':
        // Actualizar un producto, el ID se pasa como parámetro GET
        if (isset($_GET['id'])) {
            $input = json_decode(file_get_contents('php://input'), true);
            echo $product->updateProduct($_GET['id'], $input);
        }
        break;

    case 'DELETE':
        // Eliminar un producto, el ID se pasa como parámetro GET
        if (isset($_GET['id'])) {
            echo $product->deleteProduct($_GET['id']);
        }
        break;

    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        http_response_code(405);
        break;
}
