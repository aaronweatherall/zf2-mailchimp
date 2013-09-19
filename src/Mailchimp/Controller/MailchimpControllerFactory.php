<?php

namespace Mailchimp\Controller;

use Mailchimp\Form\SubscriptionForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailchimpControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $controllerManager
     * @return MailchimpController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceManager = $controllerManager->getServiceLocator();

        $subscriber = $serviceManager->get('subscriber');
        $form = $serviceManager->get('Mailchimp\Form\SubscriptionForm');

        $controller = new MailchimpController($subscriber);
        $controller->setSubscriptionForm($form);

        return $controller;
    }

}
