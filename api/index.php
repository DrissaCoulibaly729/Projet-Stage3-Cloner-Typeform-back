<?php
header("Content-Type: application/json");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER["REQUEST_URI"];

// Simple routing
switch ($requestUri) {
    case '/api/resource':
        if ($requestMethod == 'GET') {
            // Handle GET request for /api/resource
            echo json_encode(['message' => 'GET request received']);
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;
    default:
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Not Found']);
        break;
}
