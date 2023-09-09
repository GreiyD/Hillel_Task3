<?php
namespace App\Models\Entities;

use App\Interfaces\InterfaceUrlEncoder;
use App\Interfaces\InterfaceUrlDecoder;
use App\Models\Repository\FileRepository;
use App\Helpers\Validation\UrlValidator;

class UrlConverter implements InterfaceUrlDecoder, InterfaceUrlEncoder
{
    /**
     * @var UrlValidator
     */
    protected $validator;
    /**
     * @var FileRepository
     */
    protected $file_repository;
    /**
     * @var
     */
    protected $number_char_code;
    /**
     * @var
     */
    protected $code_salt;

    /**
     * @param UrlValidator $validator
     * @param FileRepository $file_repository
     * @param $number_char_code
     * @param $code_salt
     */
    public function __construct(UrlValidator $validator, FileRepository $file_repository, $number_char_code, $code_salt)
    {
        $this->validator= $validator;
        $this->file_repository= $file_repository;
        $this->number_char_code= $number_char_code;
        $this->code_salt= $code_salt;
    }

    /**
     * @param string $url
     * @return string
     */
    public function encode(string $url): string{
            $result = $this->prepareUrl($url);
            return $result;
    }

    /**
     * @param string $url
     * @return string
     */
    public function prepareUrl(string $url): string{
        $this->validator->validation($url);
        if(http_response_code() === 200){
            if($this->file_repository->checkUrlFile($url)){
                $code = $this->codingUrl($url);
                    if($this->file_repository->saveAll($code, $url)){
                        return $code;
                    }else{
                        return "Код и URL не были сохранены.";
                    }
            }else{
                return $this->file_repository->getCode($url);
            }
        }
    }

    /**
     * @param string $url
     * @return string
     */
    protected function codingUrl(string $url): string {
        $code_salt = $this->getCodeSalt();
        $number_char_code = $this->getNumberCharCode();

        $url = $url . $code_salt;
        $url_array = str_split($url);
        shuffle($url_array);
        $url_shuffled = implode('', $url_array);
        return mb_substr($url_shuffled, 0, $number_char_code);
    }

    /**
     * @param string $code
     * @return string
     */
    public function decode(string $code): string{
        return $this->file_repository->getUrl($code);
    }

    /**
     * @return mixed
     */
    public function getNumberCharCode()
    {
        return $this->number_char_code;
    }

    /**
     * @param mixed $number_char_code
     */
    public function setNumberCharCode($number_char_code): void
    {
        $this->number_char_code = $number_char_code;
    }

    /**
     * @return mixed
     */
    public function getCodeSalt()
    {
        return $this->code_salt;
    }

    /**
     * @param mixed $code_salt
     */
    public function setCodeSalt($code_salt): void
    {
        $this->code_salt = $code_salt;
    }
}