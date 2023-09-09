<?php
namespace App\Interfaces;

interface InterfaceUrlValidator
{
    /**
     * @param string $url
     * @return string
     */
    public function validation(string $url): string;
}