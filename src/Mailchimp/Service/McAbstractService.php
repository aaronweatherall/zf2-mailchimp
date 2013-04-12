<?php

namespace Mailchimp\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class McAbstractService implements ServiceManagerAwareInterface, EventManagerAwareInterface{

    protected $mapper;
    protected $arrayMap;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * Set the event manager instance
     *
     * @param  EventManagerInterface $events
     * @return AnnotationManager
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_class($this),
        ));
        $this->events = $events;

        return $this;
    }

    /**
     * Retrieve event manager
     *
     * Lazy loads an instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }

        return $this->events;
    }
    /**
     * @param $data
     * @return mixed
     */
    function remap($data)
    {
        $array_map = $this->arrayMap;

        foreach ($data as $key=>$value) {
            if (in_array($key, $array_map)) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        return $this->mapper;
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }


}