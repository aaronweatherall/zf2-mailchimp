<?php
namespace Mailchimp\Mapper;

/**
 * Class Logger
 *
 * @package Logger\Mapper
 */
interface MailchimpInterface
{

    function callServer($method, $params);
    function setDefaults($defaults);

}