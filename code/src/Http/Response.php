<?php

namespace App\Http;

class Response
{
    protected $_body;

    protected $_code;

    protected $_headers = [];

    /**
     * @param string $body
     * @param int $code
     * 
     * @return Response
     */
    public function setBody(string $body = '', int $code = ResponseCode::HTTP_SUCCESS)
    {
        $this->_body = $body;
        $this->_code = $code;
        return $this;
    }

    /**
     * Send Header and Content Response
     */
    public function send()
    {
        $this->mountHeaders();
        echo $this->_body;
    }

    /**
     * Define headers response
     */
    protected function mountHeaders()
    {
        http_response_code($this->_code);
        foreach ($this->_headers as $header => $value) {
            header("{$header}: {$value}");
        }
    }

    /**
     * Define header
     * 
     * @param string $header
     * @param string $value
     * 
     * @return Response
     */
    public function setHeader(string $header, string $value)
    {
        $this->_headers[$header] = $value;
        return $this;
    }

    /**
     * Apply header for json return
     * 
     * @param array $content,
     * @param int $code
     * 
     * @return Response;
     */
    public function setBodyWithJson(array $content = [], int $code = ResponseCode::HTTP_SUCCESS)
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->_body = json_encode($content, JSON_UNESCAPED_UNICODE);
        $this->_code = $code;
        return $this;
    }
}