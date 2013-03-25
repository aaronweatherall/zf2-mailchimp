<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mailchimp\Controller\Mailchimp' => 'Mailchimp\Controller\MailchimpController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'mailchimp' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mailchimp[/:action][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Mailchimp\Controller\Mailchimp',
                        'action'     => 'index',
                    ),
                ),
            )
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'Mailchimp\Mapper\Subscriber' => 'Mailchimp\Mapper\Subscriber',
            'Mailchimp\Entity\Subscriber' => 'Mailchimp\Entity\Subscriber',
            'Mailchimp\Entity\Lists' => 'Mailchimp\Entity\Lists',
        ),
        'factories' => array(
            'subscriber' => function ($sm) {
                $mapper = new Mailchimp\Mapper\Subscriber;
                $mapper->setSubscriberEntity(new Mailchimp\Entity\Subscriber());
                $mapper->setMailingListEntity(new Mailchimp\Entity\MailingList());
                $mapper->setDefaults($sm->get('get_config'));
                $mapper->setHydrator(new Zend\Stdlib\Hydrator\ClassMethods);

                return $mapper;
            },
            'get_config' => function ($sm) {
                $config = $sm->get('Config');
                return $config['mailchimp'];
            },
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mailchimp' => __DIR__ . '/../view',
        ),
    ),
);