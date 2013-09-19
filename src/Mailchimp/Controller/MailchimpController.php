<?php
/**
 *
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

namespace Mailchimp\Controller;

use Mailchimp\Form;
use Mailchimp\Service\Subscriber;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MailchimpController extends AbstractActionController
{
    /**
     * @var Subscriber
     */
    protected $subscriber;

    /**
     * @var Form\SubscriptionForm
     */
    protected $subscriptionForm;

    /**
     * @var string
     */
    protected $listId;

    /**
     * @param Subscriber $subscriber
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @param  Form\SubscriptionForm $form
     * @return MailchimpController
     */
    public function setSubscriptionForm(Form\SubscriptionForm $form)
    {
        $this->subscriptionForm = $form;

        return $this;
    }

    /**
     * @return Form\SubscriptionForm
     */
    public function getSubscriptionForm()
    {
        return $this->subscriptionForm;
    }

    /**
     * @return ViewModel
     */
    public function subscribeAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('mailchimp/subscribe');

        $form = $this->subscriptionForm;

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $this->subscriber->email($data['email'])
                    ->listId($this->getListId())
                    ->mergeVars(array(array(
                        'FNAME' => $data['firstName'],
                        'LNAME' => $data['lastName'],
                    )))
                    ->subscribe();

                $this->redirect()->toRoute('mailchimp-subscribe/thank-you');
            }
        }

        $viewModel->subscriptionForm = $form;

        return $viewModel;
    }

    public function thankYouAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('mailchimp/thank-you');

        return $viewModel;
    }

    /**
     * @return string
     */
    public function getListId()
    {
        if (!$this->listId) {
            $moduleConfig = $this->getServiceLocator()->get('MailchimpConfig');
            $this->listId = $moduleConfig['general']['listId'];
        }

        return $this->listId;
    }

    /**
     * @param string $listId
     * @return $this
     */
    public function setListId($listId)
    {
        $this->listId = $listId;

        return $this;
    }
}
