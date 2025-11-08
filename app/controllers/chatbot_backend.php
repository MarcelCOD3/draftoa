<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $userMessage = $data['message'] ?? '';
    if (empty($userMessage)) {
        echo json_encode(['reply' => 'Por favor, escribe un mensaje.']);
        exit;
    }
    $geminiApiKey = "AIzaSyBr5wxFPYlPAs9auqd6eMyiSb91P3E9iyw"; 

    $geminiApiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $geminiApiKey;
    
    $system_prompt = "Eres Hugo, un chatbot experto y amigable del juego de mesa Draftosaurus. Tu único propósito es responder preguntas sobre las reglas, componentes o estrategias de Draftosaurus. Si te preguntan algo que no tiene nada que ver, responde amablemente que solo sabes sobre el juego Draftosaurus. Responde de forma concisa. Pregunta del usuario:";
    $payload = json_encode([
        "contents" => [
            [
                "parts" => [
                    ["text" => $system_prompt . " " . $userMessage]
                ]
            ]
        ]
    ]);

    $ch = curl_init($geminiApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $botResponse = ''; // Variable de la respuesta

    // --- Procesar la respuesta de la API ---
    if ($response !== false && $httpcode == 200) {
        $responseData = json_decode($response, true);
        // Respuesta de la estructura de datos de Gemini
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $botResponse = $responseData['candidates'][0]['content']['parts'][0]['text'];
        }
    }
    
    // --- Fallback por si la API falla ---
    if (empty($botResponse)) {
        $botResponse = "Lo siento, estoy teniendo problemas para conectarme en este momento. Por favor, inténtalo de nuevo más tarde.";
    }

    // --- Enviar la respuesta final al frontend ---
    echo json_encode(['reply' => $botResponse]);

} catch (Exception $e) {
    // Captura cualquier otro error inesperado
    http_response_code(500);
    echo json_encode(['reply' => "Error interno del servidor: " . $e->getMessage()]);
}
?>