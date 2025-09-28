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

# Exclusions
if (!empty($_GET['excluir'])) {
	if (is_file($_GET['excluir'])) {
		unlink($_GET['excluir']);
	}
}

# Timezone
date_default_timezone_set('America/Sao_Paulo');

# Get Inputs
$content = file_get_contents('php://input');
$data = json_decode($content, true);

if (empty($content) AND empty($_POST) AND empty($_FILES)) {
	$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
	$host = $_SERVER['HTTP_HOST'] ?? '';
	$uri = $_SERVER['REQUEST_URI'] ?? '';
	$url_base = $protocolo . "://" . $host . $uri;
    echo '<strong>Teste CMD Windows:</strong> curl -X POST ' . $url_base . ' -H "Content-Type: application/json" -d "{\"message\": \"Hello, 
world!\"}"' . '<br>';
    echo '<strong>Teste CMD Linux:</strong> curl -X POST ' . $url_base . ' -H "Content-Type: application/json" -d \'{"message": "Hello, world!"}\'' . 
'<br><br>';
    include __DIR__ . '/list.php';
    exit();
}

$headers = apache_request_headers();

$all = json_encode([
	'url'		=> $_SERVER['REQUEST_URI'],
	'content' 	=> $content,
	'data' 		=> $data,
	'method' 	=> $_SERVER['REQUEST_METHOD'],
	'IP'		=> $_SERVER['REMOTE_ADDR'],
	'_REQUEST' 	=> $_REQUEST,
	'_FILES' 	=> $_FILES,
	'headers' 	=> $headers,
	'server'	=> $_SERVER
], JSON_PRETTY_PRINT);

if (strlen($all)>=32) {
    file_put_contents(__DIR__ . '/logs/' . date('YmdHis') . '_all.json',$all);
	if ($data) {
		file_put_contents(__DIR__ . '/logs/' . date('YmdHis') . '_body.json',json_encode($data, JSON_PRETTY_PRINT));
	}
	exit(json_encode(['status' => true], JSON_PRETTY_PRINT));
}
