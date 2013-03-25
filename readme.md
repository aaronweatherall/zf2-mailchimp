ZF2 Mailchimp 1.3 API Wrapper 
================================

This module is an attempt to create a complete mailchimp API wrapper for Zend Framework 2.0

*This is very much a work in progress and functionality will be added as I have time and/or need.

Installation
--------------
Added the following requirement to your projects composer.json file.

```php
"aaron4m/zf2-mailchimp": "dev-master"
```

and run

```
php ./composer.phar update
```
and finally add Mailchimp to your modules list in config/application.php.

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
