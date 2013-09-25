<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mailchimp\Controller\Mailchimp' => 'Mailchimp\Controller\MailchimpController'
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'Mailchimp\Mapper\Mailchimp' => 'Mailchimp\Mapper\Mailchimp',
            'Mailchimp\Entity\Subscriber' => 'Mailchimp\Entity\Subscriber',
            'Mailchimp\Entity\MailingList' => 'Mailchimp\Entity\MailingList',
            'Mailchimp\Service\Subscriber' => 'Mailchimp\Service\Subscriber',
            'Zend\Stdlib\Hydrator\ClassMethods' => 'Zend\Stdlib\Hydrator\ClassMethods'
        ),
        'factories' => array(
            'MailchimpMapper' => 'Mailchimp\Service\MailchimpMapperServiceFactory',
            'MailchimpConfig' =>'Mailchimp\Service\MailchimpConfigFactory',
            'subscriber' => 'Mailchimp\Service\SubscriberServiceFactory',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mailchimp' => __DIR__ . '/../view',
        ),
    ),
);
