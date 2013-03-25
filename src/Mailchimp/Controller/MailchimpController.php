<?php
namespace Mailchimp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MailchimpController extends AbstractActionController
{
    public function indexAction()
    {
        return;
    }

    public function subscribeAction()
    {
        $mailchimp = $this->getServiceLocator()->get('subscriber');
        $subscribed = $mailchimp->email('me@here.com')
            ->listId('29bc73c393')
            ->emailType('html')
            ->subscribe();

        if ($subscribed) {
            return $this->setDefaultView('Subscription Successful');
        }

        return setDefaultView();
    }

    public function unsubscribeAction()
    {
        $mailchimp = $this->getServiceLocator()->get('subscriber');
        $subscribed = $mailchimp->email('me@here.com')
            ->listId('29bc73c393')
            ->unsubscribe();

        if ($subscribed) {
            return $this->setDefaultView('Unsubscription Successful');
        }

        return setDefaultView();
    }

    public function getAction()
    {
        $mailchimp = $this->getServiceLocator()->get('subscriber');
        $subscriberDetails = $mailchimp->email('me@here.com')
            ->listId('29bc73c393')
            ->get();

        var_dump($subscriberDetails);
        die();
        return setDefaultView();
    }


    protected function setDefaultView($returnData)
    {
        $viewModel = NEW ViewModel();
        $viewModel->setTemplate('mailchimp/mailchimp/index');
        $viewModel->setVariable('content', $returnData);
        return $viewModel;
    }
}
