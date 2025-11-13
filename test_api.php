<?php

/**
 * Script para probar el API de autenticación
 * Ejecutar con: php test_api.php
 */

$baseUrl = 'http://127.0.0.1:8000/api';

// Función para hacer requests HTTP
function makeRequest($url, $method = 'GET', $data = null, $token = null) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        $token ? 'Authorization: Bearer ' . $token : ''
    ]);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    } elseif ($method === 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'body' => json_decode($response, true),
        'raw' => $response
    ];
}

echo "🧪 PROBANDO API DE AUTENTICACIÓN\n";
echo "==============================\n\n";

// 1. Prueba de Registro
echo "1️⃣ Probando REGISTRO...\n";
$registerData = [
    'name' => 'Juan Pérez',
    'email' => 'juan@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123'
];

$registerResponse = makeRequest($baseUrl . '/auth/register', 'POST', $registerData);
echo "Código HTTP: " . $registerResponse['code'] . "\n";
echo "Respuesta: " . $registerResponse['raw'] . "\n\n";

if ($registerResponse['code'] === 201) {
    echo "✅ Registro exitoso!\n";
    $token = $registerResponse['body']['data']['access_token'];
    echo "Token obtenido: " . substr($token, 0, 20) . "...\n\n";
    
    // 2. Prueba de obtener información del usuario
    echo "2️⃣ Probando GET /auth/me...\n";
    $meResponse = makeRequest($baseUrl . '/auth/me', 'GET', null, $token);
    echo "Código HTTP: " . $meResponse['code'] . "\n";
    echo "Respuesta: " . $meResponse['raw'] . "\n\n";
    
    // 3. Prueba de logout
    echo "3️⃣ Probando LOGOUT...\n";
    $logoutResponse = makeRequest($baseUrl . '/auth/logout', 'POST', null, $token);
    echo "Código HTTP: " . $logoutResponse['code'] . "\n";
    echo "Respuesta: " . $logoutResponse['raw'] . "\n\n";
    
} else {
    echo "❌ Error en el registro!\n";
    if (isset($registerResponse['body']['errors'])) {
        print_r($registerResponse['body']['errors']);
    }
}

// 4. Prueba de Login
echo "4️⃣ Probando LOGIN...\n";
$loginData = [
    'email' => 'juan@example.com',
    'password' => 'password123'
];

$loginResponse = makeRequest($baseUrl . '/auth/login', 'POST', $loginData);
echo "Código HTTP: " . $loginResponse['code'] . "\n";
echo "Respuesta: " . $loginResponse['raw'] . "\n\n";

if ($loginResponse['code'] === 200) {
    echo "✅ Login exitoso!\n";
    $newToken = $loginResponse['body']['data']['access_token'];
    echo "Nuevo token: " . substr($newToken, 0, 20) . "...\n\n";
} else {
    echo "❌ Error en el login!\n";
}

echo "🏁 Pruebas completadas!\n";

?>