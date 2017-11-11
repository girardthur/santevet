<?php

namespace BoncoinBundle\Service;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Service to get DOM contents from URLS
 *
 * Class CurlService
 * @package BoncoinBundle\Service
 */
class CurlService
{
    /** Curl instance  */
    private $curl;

    /**
     * CurlService constructor.
     */
    public function __construct()
    {
        $this->setCurl(curl_init());
    }

    /**
     * Return DOM from an URL
     *
     * @param string $url
     * @return string
     */
    public function getUrlDOM(string $url)
    {
        $ch = $this->getCurl();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = utf8_encode(curl_exec($ch));

        // Check if curl request return content
        if (strlen($response) == 0) {
            throw new Exception("Incorrect URL " . $url);
        }
        return $response;
    }

    /**
     * @return resource
     */
    public function getCurl()
    {
        return $this->curl;
    }

    /**
     * @param $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }
}