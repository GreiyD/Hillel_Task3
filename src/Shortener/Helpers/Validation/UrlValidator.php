<?php

namespace App\Shortener\Helpers\Validation;

use App\Shortener\Interfaces\InterfaceUrlValidator;
use App\Shortener\Exceptions\ExceptionHandler;


class UrlValidator implements InterfaceUrlValidator
{

    /**
     * @param string $url
     * @return string
     */
    public function validation(string $url): string
    {
        try {
            if (file_get_contents($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                return http_response_code(200);
            } else {
                throw new ExceptionHandler("URL не существует или недоступен.");
            }
        } catch (ExceptionHandler $e) {
            die ($e->getMessage());
        }
    }
}