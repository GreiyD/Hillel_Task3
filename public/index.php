<?php
use App\Helpers\Validation\UrlValidator;
use App\Models\Entities\UrlConverter;
use App\Models\Repository\FileRepository;

require_once __DIR__ . '/../autoload.php';

$number_char_code = 7;
$code_salt = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$url_string = "https://laravel.su";
//$url_string = "https://www.google.com.ua";
//$url_string = "https://www.adidas.ua";
//$code_string = "wguFAot";
$code_string = "/h3rHva";

echo $url_string."<br>";

$converter = new UrlConverter(
    new UrlValidator,
    new FileRepository,
    $number_char_code,
    $code_salt
);

echo $converter -> encode($url_string);
echo "<br>"."------------------------"."<br>";

echo $code_string."<br>";
echo $converter -> decode($code_string);