<?php

namespace Mailchimp\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Validator;

class SubscriptionForm extends Form
{
    public function __construct($name = 'mailchimp-sub-form', $options = array())
    {
        parent::__construct($name, $options);

        $firstName = new Element\Text('firstName');
        $firstName->setLabel('First Name');

        $lastName = new Element\Text('lastName');
        $lastName->setLabel('Last Name');

        $email = new Element\Email('email');
        $email->setLabel('Email Address');
        $emailValidator = new Validator\EmailAddress(array(
            'allow'  => Validator\Hostname::ALLOW_DNS,
            'domain' => true,
        ));
        $email->setValidator($emailValidator);

        $privacyPolicy = new Element\Checkbox('privacyPolicy');
        $privacyPolicy->setLabel('I accept the privacy policy and the terms of use');

        $csrf = new Element\Csrf('mcSubCSRF');

        $submit = new Element\Submit('submit');
        $submit->setValue('Subscribe');

        $this->add($firstName);
        $this->add($lastName);
        $this->add($email);
        $this->add($privacyPolicy);
        $this->add($csrf);
        $this->add($submit);

        $inputFilter = $this->getInputFilter();
        $inputFilter->get($firstName->getName())->setAllowEmpty(false)->setRequired(true);
        $inputFilter->get($lastName->getName())->setAllowEmpty(false)->setRequired(true);
    }

}
