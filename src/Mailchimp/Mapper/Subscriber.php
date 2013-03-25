<?php
namespace Mailchimp\Mapper;

use Mailchimp\Mapper\McAbstractMapper;
use Mailchimp\Mapper\Exception\MailchimpException as MailchimpException;

/**
 * Class Logger
 *
 * @package Logger\Mapper
 */
Class Subscriber extends McAbstractMapper
{
    /**
     * @var bool
     */
    protected $initialised = false;

    /**
     * @var
     */
    protected $entity;
    /**
     * @var
     */
    protected $hydrator;
    /**
     * @var
     */
    protected $defaults;

    /**
     * @var
     */
    protected $errorMessage;
    /**
     * @var
     */
    protected $errorCode;

    /**
     * @var array
     */
    protected $arrayMap = array(
        'email' => 'email',
        'merges' => 'mergeVars'
    );

    /**
     * @param bool $returnEntity
     * @return array|bool|mixed
     */
    public function get($returnEntity = false)
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["emailAddress"] = $entity->getEmailAddress();

        $data = $this->callServer("listMemberInfo", $params);
        $cleanData = $this->remap($data['data'][0]);

        $hydrator = $this->getHydrator();

        if (! is_object($cleanData)) {
            $entity = $hydrator->hydrate($cleanData, $this->getSubscriberEntity());
        } else {
            $entity = $data;
        }

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
            $this->batchSubscribe();
        }

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["emailAddress"] = $entity->getEmailAddress();
        $params["mergeVars"] = $entity->getMergeVars();
        $params["emailType"] = $entity->getEmailType();

        $params["doubleOptin"] = $this->getConfig('doubleOptin', 'subscribe');
        $params["updateExisting"] = $this->getConfig('updateExisting', 'subscribe');
        $params["replaceInterests"] = $this->getConfig('replaceInterests', 'subscribe');
        $params["sendWelcome"] = $this->getConfig('sendWelcome', 'subscribe');

        return $this->callServer("listSubscribe", $params);
    }

    /**
     * @return array|bool|mixed
     */
    public function batchSubscribe()
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();
        $batch = $entity->getBatch();

        if (! empty($batch)) {
            $this->batchSubscribe();
        }

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["batch"] = $entity->getBatch();

        $params["doubleOptin"] = $this->getConfig('doubleOptin', 'subscribe');
        $params["updateExisting"] = $this->getConfig('updateExisting', 'subscribe');
        $params["replaceInterests"] = $this->getConfig('replaceInterests', 'subscribe');
        $params["sendWelcome"] = $this->getConfig('sendWelcome', 'subscribe');

        return $this->callServer("listSubscribe", $params);
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
            $this->batchSubscribe();
        }

        $params = array();
        $params["id"] = $listEntity->getId();
        $params["email_address"] = $entity->getEmailAddress();
        $params["delete_member"] = $this->getConfig('deleteMember', 'unsubscribe');
        $params["send_goodbye"] = $this->getConfig('sendGoodbye', 'unsubscribe');
        $params["send_notify"] = $this->getConfig('sendNotify', 'unsubscribe');

        return $this->callServer("listUnsubscribe", $params);
    }

    /**
     * @return array|bool|mixed
     */
    public function update()
    {
        $entity = $this->getSubscriberEntity();
        $listEntity = $this->getMailingListEntity();

        $params = array();
        $params["id"] = $id;
        $params["email_address"] = $entity->getEmailAddress();;
        $params["merge_vars"] = $entity->getMergeVars();;
        $params["email_type"] = $entity->getEmailType();;
        $params["replace_interests"] = $this->getConfig('replaceInterests', 'update');

        return $this->callServer("listUpdateMember", $params);
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
        $this->setMergeVars($mergeVars);
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
        $this->setBatch($batchVars);
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

    /**
     * @param $data
     * @return mixed
     */
    function remap($data)
    {
        $array_map = $this->arrayMap;

        foreach ($data as $key=>$value) {
            if (in_array($key, $array_map)) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * @return mixed
     */
    function getMailingListEntity()
    {
        return $this->mailingListEntity;
    }

    /**
     * @param $entity
     * @return $this
     */
    function setMailingListEntity($entity)
    {
        $this->mailingListEntity = $entity;
        return $this;
    }

    /**
     * @return mixed
     */
    function getSubscriberEntity()
    {
        return $this->subscriberEntity;
    }

    /**
     * @param $entity
     * @return $this
     */
    function setSubscriberEntity($entity)
    {
        $this->subscriberEntity = $entity;
        return $this;
    }

    /**
     * @return mixed
     */
    function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @param $defaults
     * @return $this
     */
    function setDefaults($defaults)
    {
        parent::setDefaults($defaults);
        return $this;
    }

    /**
     * @param $values
     * @return $this
     */
    function setConfig($values)
    {
        parent::setConfig($values);
        return $this;
    }

}