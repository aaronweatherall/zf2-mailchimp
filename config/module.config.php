<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mailchimp\Controller\MailchimpController' => 'Mailchimp\Controller\MailchimpController'
        ),
        'aliases' => array(
            'mailchimp' => 'Mailchimp\Controller\MailchimpController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            // @todo clean services up, most of these could be just instantiated inside factories
            'Mailchimp\Mapper\Mailchimp' => 'Mailchimp\Mapper\Mailchimp',
            'Mailchimp\Entity\Subscriber' => 'Mailchimp\Entity\Subscriber',
            'Mailchimp\Entity\MailingList' => 'Mailchimp\Entity\MailingList',
            'Mailchimp\Form\SubscriptionForm' => 'Mailchimp\Form\SubscriptionForm',
            'Zend\Stdlib\Hydrator\ClassMethods' => 'Zend\Stdlib\Hydrator\ClassMethods'
        ),
        'factories' => array(
            'Mailchimp\Service\Subscriber' => 'Mailchimp\Service\SubscriberServiceFactory',
            'MailchimpMapper' => 'Mailchimp\Service\MailchimpMapperServiceFactory',
            'MailchimpConfig' =>'Mailchimp\Service\MailchimpConfigFactory',
        ),
        'aliases' => array(
            'subscriber' => 'Mailchimp\Service\Subscriber',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mailchimp' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'mailchimp-subscribe' => array(
                'type'      => 'Literal',
                'options'   => array(
                    'route'    => '/subscribe',
                    'defaults' => array(
                        'controller' => 'mailchimp',
                        'action'     => 'subscribe',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'thank-you' => array(
                        'type'      => 'Literal',
                        'options'   => array(
                            'route'    => '/thank-you',
                            'defaults' => array(
                                'controller' => 'mailchimp',
                                'action'     => 'thank-you',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type' => 'phpArray',
                'base_dir'      => __DIR__ . '/../language',
                'pattern'       => '%s/mailchimp.php',
            ),
        ),
    ),
);
