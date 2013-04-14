<?php
namespace Mailchimp\Mapper;

use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Http\Response;
use Mailchimp\Mapper\Exception\MailchimpException as MailchimpException;

Class Mailchimp implements MailchimpInterface
{

    protected $defaults;
    protected $config;

    public function callServer($method, $params)
    {
        // Get the URI and Url Elements
        $apiUrl = $this->generateUrl($method);
        $requestUri = $apiUrl['uri'];

        // Convert the params to something MC can understand
        $params = $this->processParams($params);
        $params["apikey"] = $this->getConfig('apiKey');

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setUri($requestUri);
        $request->getHeaders()->addHeaders(array(
            'Host' => $apiUrl['host'],
            'User-Agent' => 'MCAPI/' . $this->getConfig('apiVersion'),
            'Content-type' => 'application/x-www-form-urlencoded'
        ));

        $client = NEW Client();
        $client->setRequest($request);
        $client->setParameterPost($params);
        $result = $client->send();

        if ($result->getHeaders()->get('X-MailChimp-API-Error-Code')) {
            $error = unserialize($result->getBody());

            if (isset($error['error'])) {
                throw new MailchimpException('The mailchimp API has returned an error (' . $error['code'] . ': ' . $error['error'] . ')');
                return false;
            } else {
                throw new MailchimpException('There was an unspecified error');
                return false;
            }
        }

        return $result->getBody();
    }

    protected function processParams($params)
    {
        $cleanParams = array();

        foreach ($params as $key => $value) {
            $key = preg_replace('~([A-Z])~', '_$1', $key);
            $key = strtolower($key);
            $cleanParams[trim($key, '_')] = $value;
        }

        return $cleanParams;
    }

    protected function generateUrl($method)
    {
        $apiUrl = parse_url("http://api.mailchimp.com/" . $this->getConfig('apiVersion') . "/?output=php");
        $dc = $this->getConfig('defaultDc');

        if (strstr($this->getConfig('apiKey'), "-")) {
            list($key, $dc) = explode("-", $this->getConfig('apiKey'), 2);
            if (! $dc) {
                $dc = $this->getConfig('defaultDc');
            }
        }

        $secure = ($this->getConfig('secure'))?'https://':'http://';

        $apiUrl['host'] = $dc . "." . $apiUrl["host"];
        $apiUrl['uri'] = $secure . $apiUrl['host'] . $apiUrl["path"] . "?" . $apiUrl["query"] . "&method=" . $method;

        return $apiUrl;
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