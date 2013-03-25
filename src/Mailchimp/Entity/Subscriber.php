<?php

namespace Mailchimp\Entity;

/**
 * Mailchimp 1.3 API for ZF2
 *
 * @package Mailchimp\Entity
 */
class Subscriber
{
    protected $id;
    protected $emailAddress;
    protected $emailType;
    protected $mergeVars;
    protected $status;
    protected $ipOpt;
    protected $ipSignup;
    protected $memberRating;
    protected $campaignId;
    protected $lists;
    protected $webId;
    protected $clients;
    protected $language;
    protected $geo;
    protected $notes;
    protected $isGmonkey;
    protected $staticSegments;
    protected $timestampOpt;
    protected $timestampSignup;
    protected $infoChange;

    protected $batch;

    public function setCampaignId($campaignId)
    {
        $this->campaignId = $campaignId;

        return $this;
    }

    public function getCampaignId()
    {
        return $this->campaignId;
    }

    public function setClients($clients)
    {
        $this->clients = $clients;

        return $this;
    }

    public function getClients()
    {
        return $this->clients;
    }

    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    public function setEmailType($emailType)
    {
        $this->emailType = $emailType;

        return $this;
    }

    public function getEmailType()
    {
        return $this->emailType;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setInfoChange($infoChange)
    {
        $this->infoChange = $infoChange;

        return $this;
    }

    public function getInfoChange()
    {
        return $this->infoChange;
    }

    public function setIpOpt($ipOpt)
    {
        $this->ipOpt = $ipOpt;

        return $this;
    }

    public function getIpOpt()
    {
        return $this->ipOpt;
    }

    public function setIpSignup($ipSignup)
    {
        $this->ipSignup = $ipSignup;

        return $this;
    }

    public function getIpSignup()
    {
        return $this->ipSignup;
    }

    public function setLists($lists)
    {
        $this->lists = $lists;

        return $this;
    }

    public function getLists()
    {
        return $this->lists;
    }

    public function setMemberRating($memberRating)
    {
        $this->memberRating = $memberRating;

        return $this;
    }

    public function getMemberRating()
    {
        return $this->memberRating;
    }

    public function setMergeVars($mergeVars)
    {
        $this->mergeVars = $mergeVars;

        return $this;
    }

    public function getMergeVars()
    {
        return $this->mergeVars;
    }

    public function setStaticSegments($staticSegments)
    {
        $this->staticSegments = $staticSegments;

        return $this;
    }

    public function getStaticSegments()
    {
        return $this->staticSegments;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setWebId($webId)
    {
        $this->webId = $webId;

        return $this;
    }

    public function getWebId()
    {
        return $this->webId;
    }

    public function setGeo($geo)
    {
        $this->geo = $geo;

        return $this;
    }

    public function getGeo()
    {
        return $this->geo;
    }


    public function setIsGmonkey($isGmonkey)
    {
        $this->isGmonkey = $isGmonkey;

        return $this;
    }

    public function getIsGmonkey()
    {
        return $this->isGmonkey;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setTimestampOpt($timestampOpt)
    {
        $this->timestampOpt = $timestampOpt;

        return $this;
    }

    public function getTimestampOpt()
    {
        return $this->timestampOpt;
    }

    public function setTimestampSignup($timestampSignup)
    {
        $this->timestampSignup = $timestampSignup;

        return $this;
    }

    public function getTimestampSignup()
    {
        return $this->timestampSignup;
    }

    public function setBatch($batch)
    {
        $this->batch = $batch;

        return $this;
    }

    public function getBatch()
    {
        return $this->batch;
    }


}