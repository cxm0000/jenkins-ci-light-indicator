<?php

/**
 * Created by PhpStorm.
 * User: ming
 * Date: 03/03/16
 * Time: 08:52
 */
class JenkinsSynchronizer
{
    private $api;
    private $syncInterval = 10; // in seconds
    private $request = null;

    /**
     * JenkinsSynchronizer constructor.
     *
     * @param     $api
     * @param array|null $headers      HTTP headers to send
     *
     */
    public function __construct($api, array $headers)
    {
        $this->api = $api;
        $this->headers = $headers;

        $this->init();
    }

    /**
     * Send the request via curl
     *
     * @return stdClass
     */
    public function sync()
    {
        try {
            $data = curl_exec($this->request);

            return json_decode($data);
        } catch (Exception $e) {
            die($e);
        } finally {
            curl_close($this->request);
        }
    }

    private function init()
    {
        $this->request = curl_init();
        curl_setopt($this->request, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->request, CURLOPT_URL, $this->api);
        curl_setopt($this->request, CURLOPT_TIMEOUT, 3000);
        curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, 'GET');
        //curl_setopt($s, CURLOPT_USERPWD, "$userName:$password");
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    }

}