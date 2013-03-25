<?php

namespace Mailchimp\Entity;

/**
 * Mailchimp 1.3 API for ZF2
 *
 * @package Mailchimp\Entity
 */
class MailingList
{
    protected $id;
    protected $webId;
    protected $name;
    protected $dateCreated;
    protected $emailTypeOption;
    protected $useAwesomebar;
    protected $defaultFromName;
    protected $defaultFromEmail;
    protected $defaultSubject;
    protected $defaultLanguage;
    protected $listRating;
    protected $stats;
    protected $modules;

    public function setWebId($webId)
    {
        $this->webId = $webId;

        return $this;
    }

    public function getWebId()
    {
        return $this->webId;
    }

    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDefaultFromEmail($defaultFromEmail)
    {
        $this->defaultFromEmail = $defaultFromEmail;

        return $this;
    }

    public function getDefaultFromEmail()
    {
        return $this->defaultFromEmail;
    }

    public function setDefaultFromName($defaultFromName)
    {
        $this->defaultFromName = $defaultFromName;

        return $this;
    }

    public function getDefaultFromName()
    {
        return $this->defaultFromName;
    }

    public function setDefaultLanguage($defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    public function setDefaultSubject($defaultSubject)
    {
        $this->defaultSubject = $defaultSubject;

        return $this;
    }

    public function getDefaultSubject()
    {
        return $this->defaultSubject;
    }

    public function setEmailTypeOption($emailTypeOption)
    {
        $this->emailTypeOption = $emailTypeOption;

        return $this;
    }

    public function getEmailTypeOption()
    {
        return $this->emailTypeOption;
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

    public function setListRating($listRating)
    {
        $this->listRating = $listRating;

        return $this;
    }

    public function getListRating()
    {
        return $this->listRating;
    }

    public function setModules($modules)
    {
        $this->modules = $modules;

        return $this;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStats($stats)
    {
        $this->stats = $stats;

        return $this;
    }

    public function getStats()
    {
        return $this->stats;
    }

    public function setUseAwesomebar($useAwesomebar)
    {
        $this->useAwesomebar = $useAwesomebar;

        return $this;
    }

    public function getUseAwesomebar()
    {
        return $this->useAwesomebar;
    }

}