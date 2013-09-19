<?php

namespace Mailchimp\Controller;

use Mailchimp\Form\SubscriptionForm;
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
     * @var SubscriptionForm
     */
    protected $subscriptionForm;

    /**
     * @var string
     */
    protected $listId;

    /**
     * @return ViewModel
     */
    public function subscribeAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('mailchimp/subscribe');

        $form = $this->getSubscriptionForm();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $this->getSubscriber()->email($data['email'])
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
     * @return Subscriber
     */
    public function getSubscriber()
    {
        if (!$this->subscriber) {
            $this->subscriber = $this->getServiceLocator()->get('Mailchimp\Entity\Subscriber');
        }

        return $this->subscriber;
    }

    /**
     * @param Subscriber $subscriber
     */
    public function setSubscriber(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @return SubscriptionForm
     */
    public function getSubscriptionForm()
    {
        if (!$this->subscriptionForm) {
            $this->subscriptionForm = $this->getServiceLocator()->get('Mailchimp\Form\SubscriptionForm');
        }

        return $this->subscriptionForm;
    }

    /**
     * @param  SubscriptionForm $form
     * @return MailchimpController
     */
    public function setSubscriptionForm(SubscriptionForm $form)
    {
        $this->subscriptionForm = $form;

        return $this;
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
