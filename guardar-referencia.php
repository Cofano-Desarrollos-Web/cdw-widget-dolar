<?php
// guardar-referencia.php
// Script autónomo para generar guardar-referencia.json diariamente con hora de guardado
// Solo ejecutable por cron (CLI) o con clave secreta en URL

// 🔑 Clave secreta
$clave_secreta = "LeoIndy191223@";

// Verificación de acceso
if (php_sapi_name() !== 'cli') {
    if (!isset($_GET['key']) || $_GET['key'] !== $clave_secreta) {
        http_response_code(403);
        exit('Acceso no autorizado');
    }
}

// Forzar zona horaria a Argentina (UTC-3)
date_default_timezone_set('America/Argentina/Buenos_Aires');

$fechaHoy = date("Y-m-d");
$horaAhora = date("H:i:s");

$base = __DIR__;
$archivoReferencia = $base . '/guardar-referencia.json';

// --- Obtener datos de las APIs ---
// Oficial (DólarAPI)
$oficialJson = @file_get_contents("https://dolarapi.com/v1/dolares/oficial");
$oficialData = json_decode($oficialJson, true);

// Blue (Bluelytics)
$blueJson = @file_get_contents("https://api.bluelytics.com.ar/v2/latest");
$blueData = json_decode($blueJson, true);

// Validar datos
if (!$oficialData || !$blueData) {
    error_log("[$fechaHoy $horaAhora] Error: no se pudieron obtener datos de las APIs");
    exit;
}

// Armar referencia
$referencia = [
    'fecha' => $fechaHoy,
    'hora_guardado' => $horaAhora,
    'oficial' => [
        'compra' => $oficialData['compra'] ?? null,
        'venta'  => $oficialData['venta'] ?? null,
        'fuente' => 'DolarAPI'
    ],
    'blue' => [
        'compra' => $blueData['blue']['value_buy'] ?? null,
        'venta'  => $blueData['blue']['value_sell'] ?? null,
        'last_update' => $blueData['last_update'] ?? null,
        'fuente' => 'Bluelytics'
    ]
];

// Guardar en archivo local
$ok = file_put_contents(
    $archivoReferencia,
    json_encode($referencia, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

if ($ok) {
    error_log("[$fechaHoy $horaAhora] Referencia guardada correctamente en $archivoReferencia");
    // Evitar cache en navegadores y CDN
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
	
	echo "Referencia guardada correctamente";
} else {
    error_log("[$fechaHoy $horaAhora] Error: no se pudo escribir $archivoReferencia");
    echo "Error al guardar referencia";
}
