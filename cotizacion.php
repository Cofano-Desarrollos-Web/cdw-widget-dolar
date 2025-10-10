<?php
// cotizacion.php
// Devuelve cotizaciones en vivo en formato array con "casa"
// Oficial desde DólarAPI + Blue desde Bluelytics
// Evitar cache en navegadores y CDN
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Oficial (DólarAPI)
$oficialJson = @file_get_contents("https://dolarapi.com/v1/dolares/oficial");
$oficialData = json_decode($oficialJson, true);

// Blue (Bluelytics)
$blueJson = @file_get_contents("https://api.bluelytics.com.ar/v2/latest");
$blueData = json_decode($blueJson, true);

$resultado = [];

// Oficial
if ($oficialData) {
    $resultado[] = [
        "casa"   => "oficial",
        "compra" => $oficialData["compra"] ?? null,
        "venta"  => $oficialData["venta"] ?? null
    ];
}

// Blue
if ($blueData) {
    $resultado[] = [
        "casa"   => "blue",
        "compra" => $blueData["blue"]["value_buy"] ?? null,
        "venta"  => $blueData["blue"]["value_sell"] ?? null
    ];
}

echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


