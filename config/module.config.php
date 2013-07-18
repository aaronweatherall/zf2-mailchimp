<?php
return array(
    'controllers' => array(
        'factories' => array(
            'mailchimp' => 'Mailchimp\Controller\MailchimpControllerFactory'
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'Mailchimp\Mapper\Mailchimp' => 'Mailchimp\Mapper\Mailchimp',
            'Mailchimp\Entity\Subscriber' => 'Mailchimp\Entity\Subscriber',
            'Mailchimp\Entity\MailingList' => 'Mailchimp\Entity\MailingList',
            'Mailchimp\Service\Subscriber' => 'Mailchimp\Service\Subscriber',
            'Mailchimp\Form\SubscriptionForm' => 'Mailchimp\Form\SubscriptionForm',
            'Zend\Stdlib\Hydrator\ClassMethods' => 'Zend\Stdlib\Hydrator\ClassMethods'
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
