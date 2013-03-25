<?php
namespace Mailchimp\Mapper;

use Mailchimp\Mapper\Exception\MailchimpException as MailchimpException;

/**
 * Class Logger
 *
 * @package Logger\Mapper
 */
Class McAbstractMapper
{
    protected $defaults;
    protected $config;

    protected function callServer($method, $params) {
        $apiUrl = $this->generateUrl();
        $params["apikey"] = $this->getConfig('apiKey');

        $params = $this->processParams($params);

        $this->errorMessage = "";
        $this->errorCode = "";

        $separator_changed = false;

        //sigh, apparently some distribs change this to &amp; by default
        if (ini_get("arg_separator.output")!="&"){
            $separator_changed = true;
            $original_separator = ini_get("arg_separator.output");
            ini_set("arg_separator.output", "&");
        }
        $postVars = http_build_query($params);

        if ($separator_changed){
            ini_set("arg_separator.output", $original_separator);
        }

        $payload = $this->generatePayload($apiUrl, $method, $postVars);
        $serverResponse = $this->getResponse($apiUrl, $payload);

        if ($serverResponse['info']["timed_out"]) {
            throw new MailchimpException("Could not read response (timed out)");
            return false;
        }

        list($headers, $serverResponse['response']) = explode("\r\n\r\n", $serverResponse['response'], 2);
        $headers = explode("\r\n", $headers);
        $errored = false;

        foreach($headers as $h){
            if (substr($h,0,26)==="X-MailChimp-API-Error-Code"){
                $errored = true;
                $error_code = trim(substr($h,27));
                break;
            }
        }

        if(ini_get("magic_quotes_runtime")) {
            $serverResponse['response'] = stripslashes($serverResponse['response']);
        }

        $serial = unserialize($serverResponse['response']);
        if($serverResponse['response'] && $serial === false) {
            $response = array("error" => "Bad Response.  Got This: " . $response, "code" => "-99");
        } else {
            $response = $serial;
        }
        if($errored && is_array($response) && isset($response["error"])) {
            throw new MailchimpException('An error has occurred (' . $response['code'] . ': ' . $response['error'] . ')');
            return false;
        } elseif($errored){
            throw new MailchimpException('There was an unspecified error');
            return false;
        }

        return $response;
    }

    protected function processParams($params)
    {
        $cleanParams = array();

        foreach ($params as $key=>$value) {
            $key = preg_replace('~([A-Z])~', '_$1', $key);
            $key = strtolower($key);
            $cleanParams[trim($key, '_')] = $value;
        }

        return $cleanParams;
    }

    protected function generateUrl()
    {
        $apiUrl = parse_url("http://api.mailchimp.com/" . $this->getConfig('apiVersion') . "/?output=php");
        $dc = $this->getConfig('defaultDc');

        if (strstr($this->getConfig('apiKey'),"-")){
            list($key, $dc) = explode("-",$this->getConfig('apiKey'),2);
            if (!$dc) {
                $dc = $this->getConfig('defaultDc');
            }
        }

        $apiUrl['host'] = $dc.".".$apiUrl["host"];

        return $apiUrl;
    }

    protected function getResponse($apiUrl, $payload)
    {
        ob_start();
        if ($this->getConfig('secure')){
            $sock = fsockopen("ssl://".$apiUrl['host'], 443, $errno, $errstr, 30);
        } else {
            $sock = fsockopen($apiUrl['host'], 80, $errno, $errstr, 30);
        }

        if(!$sock) {
            throw new MailchimpException("Could not connect (ERR $errno: $errstr)");
            ob_end_clean();
            return false;
        }

        $response = "";
        fwrite($sock, $payload);
        stream_set_timeout($sock, $this->getConfig('timeout'));
        $info = stream_get_meta_data($sock);
        while ((!feof($sock)) && (!$info["timed_out"])) {
            $response .= fread($sock, $this->getConfig('chunkSize'));
            $info = stream_get_meta_data($sock);
        }
        fclose($sock);
        ob_end_clean();

        return array('info'=>$info, 'response'=>$response);
    }

    protected function generatePayload($apiUrl, $method, $postVars)
    {
        $payload = "POST " . $apiUrl["path"] . "?" . $apiUrl["query"] . "&method=" . $method . " HTTP/1.0\r\n";
        $payload .= "Host: " . $apiUrl['host'] . "\r\n";
        $payload .= "User-Agent: MCAPI/" . $this->getConfig('apiVersion') ."\r\n";
        $payload .= "Content-type: application/x-www-form-urlencoded\r\n";
        $payload .= "Content-length: " . strlen($postVars) . "\r\n";
        $payload .= "Connection: close \r\n\r\n";
        $payload .= $postVars;

        return $payload;
    }

    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
        return $this;
    }

    public function getConfig($configKey, $section = 'general')
    {
        if (isset($this->config[$section][$configKey])) {
            return $this->config[$section][$configKey];
        }

        return $this->defaults[$section][$configKey];
    }

    public function getHydrator()
    {
        return $this->hydrator;
    }

    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
    }
}