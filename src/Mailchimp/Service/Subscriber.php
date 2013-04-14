<?php

namespace Mailchimp\Service;

use Mailchimp\Service\McAbstractService;


class Subscriber extends McAbstractService {

    protected $subscriberEntity;
    protected $mailingListEntity;

    protected $arrayMap = array(
        'email' => 'email',
        'merges' => 'mergeVars'
    );

    /**
     * @return array|bool|mixed
     */
    public function update()
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('mailList' => $listEntity, 'subscriber'=> $entity));

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["email_address"] = $entity->getEmailAddress();;
        $params["merge_vars"] = $entity->getMergeVars();;
        $params["email_type"] = $entity->getEmailType();;
        $params["replace_interests"] = $this->getConfig('replaceInterests', 'update');

        if ($this->getMapper()->callServer("listUpdateMember", $params) ) {
            return true;
        }

        return false;
    }

    /**
     * @param bool $returnEntity
     * @return array|bool|mixed
     */
    public function get($returnEntity = false)
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('mailList' => $listEntity, 'subscriber'=> $entity));

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["emailAddress"] = $entity->getEmailAddress();

        $data = $this->getMapper()->callServer("listMemberInfo", $params);
        $cleanData = $this->remap($data['data'][0]);

        $hydrator = $this->$this->getMapper()->getHydrator();

        if (! is_object($cleanData)) {
            $entity = $hydrator->hydrate($cleanData, $this->getSubscriberEntity());
        } else {
            $entity = $data;
        }

        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('entity' => $entity));

        if ($returnEntity) {
            return $entity;
        }

        return $hydrator->extract($entity);
    }

    /**
     * @return array|bool|mixed
     */
    public function subscribe()
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();
        $batch = $entity->getBatch();

        if (! empty($batch)) {
            return $this->batchSubscribe();
        }

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('mailList' => $listEntity, 'subscriber'=> $entity));

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["emailAddress"] = $entity->getEmailAddress();
        $params["mergeVars"] = $entity->getMergeVars();
        $params["emailType"] = $entity->getEmailType();
        $params["doubleOptin"] = $this->getConfig('doubleOptin', 'subscribe');
        $params["updateExisting"] = $this->getConfig('updateExisting', 'subscribe');
        $params["replaceInterests"] = $this->getConfig('replaceInterests', 'subscribe');
        $params["sendWelcome"] = $this->getConfig('sendWelcome', 'subscribe');

        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('entity' => $entity));

        if ($this->getMapper()->callServer("listSubscribe", $params) ) {
            return true;
        }

        return false;
    }

    /**
     * @return array|bool|mixed
     */
    public function batchSubscribe()
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('mailList' => $listEntity, 'subscriber'=> $entity));

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["batch"] = $entity->getBatch();
        $params["doubleOptin"] = $this->getConfig('doubleOptin', 'subscribe');
        $params["updateExisting"] = $this->getConfig('updateExisting', 'subscribe');
        $params["replaceInterests"] = $this->getConfig('replaceInterests', 'subscribe');
        $params["sendWelcome"] = $this->getConfig('sendWelcome', 'subscribe');

        if ($this->getMapper()->callServer("listBatchSubscribe", $params) ) {
            return true;
        }

        return false;
    }

    /**
     * @return array|bool|mixed
     */
    public function unsubscribe()
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();
        $batch = $entity->getBatch();

        if (! empty($batch)) {
            return $this->batchUnsubscribe();
        }

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('mailList' => $listEntity, 'subscriber'=> $entity));

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["email_address"] = $entity->getEmailAddress();
        $params["delete_member"] = $this->getConfig('deleteMember', 'unsubscribe');
        $params["send_goodbye"] = $this->getConfig('sendGoodbye', 'unsubscribe');
        $params["send_notify"] = $this->getConfig('sendNotify', 'unsubscribe');

        if ($this->getMapper()->callServer("listUnsubscribe", $params) ) {
            return true;
        }

        return false;
    }

    /**
     * @return array|bool|mixed
     */
    public function batchUnsubscribe()
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('mailList' => $listEntity, 'subscriber'=> $entity));

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["emails"] = $entity->getBatch();
        $params["delete_member"] = $this->getConfig('deleteMember', 'unsubscribe');
        $params["send_goodbye"] = $this->getConfig('sendGoodbye', 'unsubscribe');
        $params["send_notify"] = $this->getConfig('sendNotify', 'unsubscribe');

        if ($this->getMapper()->callServer("listBatchUnsubscribe", $params) ) {
            return true;
        }

        return false;
    }

    /**
     * @param $subscriberId
     * @return $this
     */
    public function id($subscriberId)
    {
        $entity = $this->getSubscriberEntity();
        $entity->setId($subscriberId);
        return $this;
    }

    /**
     * @param $listId
     * @return $this
     */
    public function listId($listId)
    {
        $entity = $this->getMailingListEntity();
        $entity->setId($listId);
        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function email($email)
    {
        $entity = $this->getSubscriberEntity();
        $entity->setEmailAddress($email);

        return $this;
    }

    /**
     * @param $emailType
     * @return $this
     */
    public function emailType($emailType)
    {
        $entity = $this->getSubscriberEntity();
        $entity->setEmailType($emailType);

        return $this;
    }

    /**
     * @param array $mergeVars
     * @return $this
     */
    public function mergeVars($mergeVars = array())
    {
        $entity = $this->getSubscriberEntity();
        $entity->setMergeVars($mergeVars);
        return $this;
    }

    /**
     * Batch Magic Method
     * Expects an array of structs for each address to import with two special keys: "EMAIL" for the email address,
     * and "EMAIL_TYPE" for the email type option (html or text)
     *
     * <code>
     * <?php
     * $subscribe->id('12345')->batch(array(
     *  array('EMAIL'=>'me@here.com', 'EMAIL_TYPE'=>'html', 'FNAME'=>'Aaron'),
     *  array('EMAIL'=>'me2@here.com', 'EMAIL_TYPE'=>'html', 'FNAME'=>'Bill'),
     * ));
     * ?>
     * </code>
     *
     * @param array $mergeVars
     * @return $this
     */
    public function batch($batchVars = array())
    {
        $entity = $this->getSubscriberEntity();
        $entity->setBatch($batchVars);
        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options($options = array())
    {
        $this->setConfig($options);
        return $this;
    }

    public function setMailingListEntity($mailingListEntity)
    {
        $this->mailingListEntity = $mailingListEntity;

        return $this;
    }

    public function getMailingListEntity()
    {
        return $this->mailingListEntity;
    }

    public function setSubscriberEntity($subscriberEntity)
    {
        $this->subscriberEntity = $subscriberEntity;
        return $this;
    }

    public function getSubscriberEntity()
    {
        return $this->subscriberEntity;
    }


}