<?php

# Universal Catcher

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

# Dev Mode: Show Errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

# XDebug
ini_set('xdebug.var_display_max_depth', '-1');
ini_set('xdebug.var_display_max_children', '-1');
ini_set('xdebug.var_display_max_data', '-1');

# Timezone
date_default_timezone_set('America/Sao_Paulo');

# Get Inputs
$content = file_get_contents('php://input');
$data = json_decode($content, true);

if (empty($content) AND empty($_POST) AND empty($_FILES)) {
    echo '<strong>Teste CMD Windows:</strong> curl -X POST https://microframeworks.com/tools/catcher/ -H "Content-Type: application/json" -d "{\"message\": \"Hello, 
world!\"}"' . '<br>';
    echo '<strong>Teste CMD Linux:</strong> curl -X POST https://microframeworks.com/tools/catcher/ -H "Content-Type: application/json" -d \'{"message": "Hello, world!"}\'' . 
'<br><br>';
    if (!empty($_GET['list'])) {
        include __DIR__ . '/list.php';
    }
    exit();
}

$headers = apache_request_headers();

# Hold headers
ob_start();

$ssl = $_SERVER['SSL_CLIENT_CERT'] ?? null;

echo '<pre>';
var_dump([
	'url'		=> $_SERVER['REQUEST_URI'],
	'content' 	=> $content,
	'data' 		=> $data,
	'method' 	=> $_SERVER['REQUEST_METHOD'],
	'IP'		=> $_SERVER['REMOTE_ADDR'],
	'_REQUEST' 	=> $_REQUEST,
	'_FILES' 	=> $_FILES,
	'headers' 	=> $headers,
	'ssl'		=> $ssl
]);
if (!empty($json) AND empty($data)) {
	var_dump(['json_last_error' => json_last_error()]);
}
echo '</pre>';

$content_in_buffer = ob_get_clean();
$content_trimmed = trim($content_in_buffer);

if (strlen($content_trimmed)>=32) {
    file_put_contents(date('YmdHis') . '.html',$content_trimmed);
	if ($data) {
		file_put_contents(date('YmdHis') . '.json',json_encode($data, JSON_PRETTY_PRINT));
	}
	exit(json_encode(['status' => true], JSON_PRETTY_PRINT));
} else {
    $old_content = is_file('empty.html') ? file_get_contents('empty.html') : '';
    $new_content = date('Y-m-d H:i:s') . ' :: request vazia.<br>' . $old_content;
    file_put_contents('empty.html',$new_content);
}
