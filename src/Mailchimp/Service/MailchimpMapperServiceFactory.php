<?php

namespace Mailchimp\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

/**
 * Simple authentication provider factory
 *
 * @author Ingo Walz <ingo.walz@googlemail.com>
 */
class MailchimpMapperServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mapper = $serviceLocator->get('Mailchimp\Mapper\Mailchimp') ;
        $mapper->setDefaults($serviceLocator->get('MailchimpConfig'));
        $mapper->setHydrator(new Hydrator);

        return $mapper;
    }

}
