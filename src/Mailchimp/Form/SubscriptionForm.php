<?php
/**
 *
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Mailchimp\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class SubscriptionForm extends Form
{
    public function __construct($name = 'mailchimp-sub-form', $options = array())
    {
        parent::__construct($name, $options);

        $firstName = new Element\Text('first-name');
        $firstName->setLabel('First Name');

        $lastName = new Element\Text('last-name');

        $csrf = new Element\Csrf('mc-sub-csrf');

        $submit = new Element\Submit('submit');

        $this->add(array(
            $firstName,
            $lastName,
            $csrf,
            $submit,
        ));
    }

}
