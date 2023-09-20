<?php

use App\Shortener\Helpers\Validation\UrlValidator;
use App\Shortener\Service\UrlConverter;
use App\Shortener\Repository\FileRepository;

require_once __DIR__ . '/../autoload.php';

$numberCharCode = 7;
$codeSalt = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$urlString = "https://laravel.su";
//$urlString = "https://www.google.com.ua";
//$urlString = "https://www.adidas.ua";
//$codeString = "wguFAot";
$codeString = "/h3rHva";

echo $urlString . "<br>";

$converter = new UrlConverter(
    new UrlValidator,
    new FileRepository,
    $numberCharCode,
    $codeSalt
);

echo $converter->encode($urlString);
echo "<br>" . "------------------------" . "<br>";

echo $codeString . "<br>";
echo $converter->decode($codeString);