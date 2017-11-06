<?php
/**
 *@description : the curl operation class
 *@copyright   : Copyright 2017 Stephen Mo <stephen@iot-sw.net> M.D.C
 */

class CurlHelper
{
    
    CONST GET_METHOD  = 'GET';
    CONST POST_METHOD = 'POST';
    CONST PUT_METHOD  = 'PUT';
    CONST DEL_METHOD  = 'DELETE';

    static private $_instance;  

    private $errors = array();    

    private $response = null;

    public $client = null;

    public $time_out = 30;
    
    public $user_agent = 'curl';

    public $method;

    public $return_style;
    
    public function __construct($method='') 
    {
        if (!empty($method) && in_array($method,$this->getMethods())) {
            $this->method = $method;
        }
    }
    
    public function getMethods() 
    {
        return [self::GET_METHOD,self::POST_METHOD,self::PUT_METHOD,self::DEL_METHOD];
    }

    static public function getInstance() 
    {
        if (!isset(self::$_instance) || empty(self::$_instance)) 
        {
            $className = __CLASS__;
            self::$_instance = new $className();
        }

        return self::$_instance;
    }
    
    public function request($requestUrl,Array $parameters=array(),$method='',$returnStyle='') 
    {
        $this->check($requestUrl,$parameters,$method,$returnStyle);
        
        if (!empty($this->errors)) {
            return $this->getErrors;
        }

        $this->{strtolower($this->method)}();

        return $this->getResult();
    }

    private function check($requestUrl,$parameters,$method,$returnStyle) 
    {
        if (!preg_match('/http(s)?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$requestUrl)) 
        {
            $this->errors[] = '访问的URL无效';
        }

        $this->url = $requestUrl;

        if (!empty($method) && in_array(strtoupper($method),$this->getMethods())) 
        {
            $this->method = $method;
        }
        elseif (empty($this->method)) 
        {
            $this->method = self::GET_METHOD;
        }

        if (empty($returnStyle)) 
        {
            $this->return_style = 'json';
        }
        else 
        {
            $this->return_style = $returnStyle;
        }

        if (!empty($parameters)) 
        {
            $this->parameters = http_build_query($parameters);
        }

        $this->content_type = 'application/x-www-form-urlencoded';

        $this->charset = 'UTF-8';
    }

    private function getErrors() 
    {
        return array('status'=>false,$this->errors);
    }

    public function getResult() 
    {
        if (!isset($this->results) || empty($this->results)) 
        { 
            return array('status'=>false,$this->errors);
        }

        return $this->results;
    }

    public function get() 
    {
        if (!empty($this->parameters)) 
        {
            $connector = (strpos('?',$this->url) === FALSE) ? '?' : '&';
            $this->url .= "{$connector}{$this->parameters}";
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$this->method);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type:'.$this->content_type.';charset='.$this->charset));
        curl_setopt($ch,CURLOPT_USERAGENT,$this->user_agent);
        curl_setopt($ch,CURLOPT_TIMEOUT,$this->time_out);
        
        $curlResponse = curl_exec($ch);
        $curlErrors = curl_error($ch);

        curl_close($ch);
        
        $this->formatResponse($curlResponse,$curlErrors);
    }

    public function post() 
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this->parameters);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$this->method);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type:'.$this->content_type.';charset='.$this->charset));
        curl_setopt($ch,CURLOPT_USERAGENT,$this->user_agent);
        curl_setopt($ch,CURLOPT_TIMEOUT,$this->time_out);
        
        $curlResponse = curl_exec($ch);
        $curlErrors = curl_error($ch);

        curl_close($ch);
        
        $this->formatResponse($curlResponse,$curlErrors);
    }

    public function put() 
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this->parameters);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$this->method);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type:'.$this->content_type.';charset='.$this->charset.';X-HTTP-Method-Override:'.$this->method));
        curl_setopt($ch,CURLOPT_USERAGENT,$this->user_agent);
        curl_setopt($ch,CURLOPT_TIMEOUT,$this->time_out);
        
        $curlResponse = curl_exec($ch);
        $curlErrors = curl_error($ch);

        curl_close($ch);
        
        $this->formatResponse($curlResponse,$curlErrors);

    }

    public function delete() 
    {
        if (!empty($this->parameters)) 
        {
            $connector = (strpos('?',$this->url) === FALSE) ? '?' : '&';
            $this->url .= "{$connector}{$this->parameters}";
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$this->method);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type:'.$this->content_type.';charset='.$this->charset));
        curl_setopt($ch,CURLOPT_USERAGENT,$this->user_agent);
        curl_setopt($ch,CURLOPT_TIMEOUT,$this->time_out);
        
        $curlResponse = curl_exec($ch);
        $curlErrors = curl_error($ch);

        curl_close($ch);
        
        $this->formatResponse($curlResponse,$curlErrors);
    }

    public function formatResponse($response,$errors) 
    {
        $response = ($this->return_style=='xml') ? self::formatXmlToArray($response) : $response;
        
        $status = (empty($errors)) ? 1 : 0;

        $responseData = json_decode($response,true);

        $api_status   = (isset($responseData['head']['status'])) ? $responseData['head']['status'] : $status;
        $api_errors   = (isset($responseData['head']['errors'])) ? $responseData['head']['errors'] : $errors;
        $api_content  = (isset($responseData['body'])) ? $responseData['body'] : $responseData;

        $this->results = array(
                'status' => $api_status,
                'errors' => $api_errors,
                'content' => $api_content
            );
    }

    static public function formatXmlToArray($response) 
    {
        $charset = mb_detect_encoding($xml,array('UTF-8','GB2312','GBK','BIG5','ASCII'));

        switch($charset) 
        {
            case 'UTF-8':
                break;
            case 'GBK':
                $xml = mb_convert_encoding($xml,'UTF-8','GBK'); 
                break;
            case 'BIG5':
                $xml = mb_convert_encoding($xml,'UTF-8','BIG5');
                break;
            case 'GB2312':
            default:
                $xml = mb_convert_encoding($xml,'UTF-8','GB2312');
        }

        if (empty($xml)) 
        {
            return array();
        }

        libxml_disable_entity_loader(true);

        $result = json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA));
        
        return $result;
    }

}

