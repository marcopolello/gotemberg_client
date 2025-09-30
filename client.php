<?php

require_once 'vendor/autoload.php';

use Gotenberg\Gotenberg;
use Gotenberg\Stream;


$apiUrl = 'https://demo.gotenberg.dev/'; // Your Gotenberg API URL.
//INSERIRE LA DIRECTORY DESIDERATA (salvataggio pdf)
$directory = '';
if (!is_dir($directory)) {
    mkdir($directory, 0777, true); // Create the directory if it doesn't exist
}

$request = Gotenberg::chromium($apiUrl)
    ->pdf()
    ->preferCSSPageSize()
    ->printBackground();

//var_dump($request);

$htmlFilePath = __DIR__ . '/index.html'; // Permette di ottenere il percorso assoluto del file .html nella stessa cartella di client.php
$htmlContent = file_get_contents($htmlFilePath);

$request = $request->html(Stream::string('index.html', $htmlContent));

$response = Gotenberg::send($request);

$filename = $directory . uniqid() . '.pdf';
file_put_contents($filename, $response->getBody()->getContents());