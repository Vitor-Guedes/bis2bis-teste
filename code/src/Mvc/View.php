<?php

namespace App\Mvc;

use App\Http\Response;
use Exception;

class View
{
    protected $_dirTemplate;

    public function setTemplatePath(string $path = '')
    {
        if (is_dir($path)) {
            $this->_dirTemplate = $path;
        }
    }

    /**
     * @param Response $response
     * @param string $file - file name to render
     * @param array $param - parameters to insert in the rendered file
     * 
     * @return Response
     */
    public function render(Response $response, string $file, array $param = [])
    {
        $template = $this->_dirTemplate . $file;
        
        if (!file_exists($template)) {
            throw new Exception("Template: $template not exists.");
        }

        ob_start();

        extract($param);
        include_once($template);
        
        $content = ob_get_contents();

        ob_end_clean();

        $response->setBody($content);
        return $response;
    }
}