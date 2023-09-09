<?php
namespace App\Helpers\Validation;

use App\Interfaces\InterfaceUrlValidator;

class UrlValidator implements InterfaceUrlValidator
{
    /**
     * @param string $url
     * @return string
     */
    public function validation(string $url): string{
        if (file_get_contents($url) && filter_var($url, FILTER_VALIDATE_URL)) {
            return http_response_code(200);
        } else {
            die ("URL не существует или недоступен.");
        }
    }
}