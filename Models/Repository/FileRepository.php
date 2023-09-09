<?php
namespace App\Models\Repository;

use App\Interfaces\InterfaceFileRepository;


class FileRepository implements InterfaceFileRepository
{
    /**
     * @var string
     */
    protected $file_name = "../file.txt";

    /**
     * @param string $code
     * @param string $url
     * @return bool
     */
    public function saveAll(string $code, string $url): bool {
        $filename = $this->getFileName();
        $data = $code . "  |  " . $url . PHP_EOL;
        $result = file_put_contents($filename, $data,FILE_APPEND | LOCK_EX);
        return $result;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function checkUrlFile(string $url): bool{
        $filename = $this->getFileName();
        $content = file_get_contents($filename);
        if(strpos($content, $url) !== false) {
            return false;
        }
        return true;
    }

    /**
     * @param string $code
     * @return string
     */
    public function getUrl(string $code): string{
        $filename = $this->getFileName();
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $parts = explode('  |  ', $line);
            if (count($parts) === 2 && trim($parts[0]) === $code) {
                $url = trim($parts[1]);
                return $url;
            }
        }
        return "Не удалось разкодировать.";
    }

    /**
     * @param string $url
     * @return string
     */
    public function getCode(string $url): string{
        $filename = $this->getFileName();
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $parts = explode(' | ', $line);
            if (count($parts) === 2 && trim($parts[1]) === $url) {
                $code = trim($parts[0]);
                return $code;
            }
        }
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->file_name;
    }

    /**
     * @param string $file_name
     */
    public function setFileName(string $file_name): void
    {
        $this->file_name = $file_name;
    }

}