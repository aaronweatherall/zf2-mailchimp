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
        ),
        'factories' => array(
            'MailchimpMapper' => 'Mailchimp\Service\MailchimpMapperServiceFactory',
            'MailchimpConfig' => function ($sm) {
                $config = $sm->get('Config');
                return $config['mailchimp'];
            },
            'subscriber' => 'Mailchimp\Service\SubscriberServiceFactory',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mailchimp' => __DIR__ . '/../view',
        ),
    ),
);