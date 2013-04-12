ZF2 Mailchimp 1.3 API Wrapper 
================================

This module is an attempt to create a complete mailchimp API wrapper for Zend Framework 2.0
At the moment, this is loosely based on https://github.com/waynhall/CodeIgniter-Library-for-MailChimp-API-v1.3

*This is very much a work in progress and functionality will be added as I have time and/or need.

Contributing
------------
If you want to see this module move along faster, please feel free to pick a section, start coding and submit pull requests!
I'm interested in contributions for
- Unit Tests
- Rewriting the actual submit mechanism
- Add other sections not yet completed
- Code improvements (I'm still learning, so would appreciate feedback)

Installation
--------------
1) Add the following requirement to your projects composer.json file.

```php
"aaron4m/zf2-mailchimp": "dev-master"
```

2) Open up your command line and run

```
php ./composer.phar update
```

3) Copy vendor/aaron4m/zf2-mailchimp/config/mailchimp.local.php.dist to your /config/autoload folder and rename it to mailchimp.local.php
4) You *must* add your API key to this file and configure any global settings.

Usage Examples
===============

Subscribe (Single)
-------------------

```php
$mailchimp = $this->getServiceLocator()->get('subscriber');

$mailchimp->email('me@here.com.au')
  ->listId('29bc73c393')
  ->emailType('html')
  ->subscribe();
```

Subscribe (Bulk)
-------------------

```php
$mailchimp = $this->getServiceLocator()->get('subscriber');

$subscribe->listId('12345')
  ->batch(array(
    array('EMAIL'=>'me@here.com', 'EMAIL_TYPE'=>'html', 'FNAME'=>'Aaron'),
    array('EMAIL'=>'me2@here.com', 'EMAIL_TYPE'=>'html', 'FNAME'=>'Bill'),
  ))
  ->subscribe();
```

Unsubscribe (Single)
-------------------

```php
$mailchimp = $this->getServiceLocator()->get('subscriber');

$mailchimp->email('me@here.com.au')
    ->listId('29bc73c393')
    ->unsubscribe();
```


Unsubscribe (Bulk)
-------------------

```php
$mailchimp = $this->getServiceLocator()->get('subscriber');

$subscribe->listId('12345')
  ->batch(array(
    array('EMAIL'=>'me@here.com'),
    array('EMAIL'=>'me2@here.com'),
  ))
  ->unsubscribe();
```

Update (Single)
-------------------

```php
$mailchimp = $this->getServiceLocator()->get('subscriber');

$subscribe->listId('12345')
  ->email('me@here.com')
  ->mergeVars(array(
    array('FNAME'=>'Aaron'),
  ))
  ->update();
```

Update (Bulk)
-------------------

```php
$mailchimp = $this->getServiceLocator()->get('subscriber');

$subscribe->listId('12345')
  ->batch(array(
    array('EMAIL'=>'me@here.com', 'FNAME'=>'Aaron'),
    array('EMAIL'=>'me2@here.com', 'FNAME'=>'Billy'),
  ))
  ->update();
```

Get Member Info (Single)
-------------------
* You can return this as an array or a subscriber entity

```php
$mailchimp = $this->getServiceLocator()->get('subscriber');

$subscriberDetails = $mailchimp->email('aaron@4mation.com.au')
  ->listId('29bc73c393')
  ->get();
```
