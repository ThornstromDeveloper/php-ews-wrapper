# php-ews-wrapper
A simple wrapper for jamesiarmes/php-ews library


# Installation
```
composer require amirsanni/php-ews-wrapper
```


# Features
* Send Email
* Create Draft
* Get Inbox Messages
* Get Sent Items
* Get Outbox Items
* Get Draft Items
* Get Contacts
* Get Deleted Messages
* Get Archived Messages
* Get Messages in Favorites Folder
* Get Junk Messages
* Get Tasks
* Get Conversation History


# How to use
### Instantiate

```
use amirsanni\phpewswrapper\PhpEwsWrapper;

$mail = new PhpEwsWrapper('email', 'password', 'optionalServerAddress', 'optionalVersion');
```

**Note:** Server address defaults to _outlook.office365.com_  
**Supported Versions: 2007, 2009, 2010, 2013, 2016**. _Defaults to 2016_.



## Send Email
```
$mail->sender_name = "John Doe";
$mail->subject = "Test email";
$mail->message = "This is a test email";
$mail->recipient = 'abc@example.com'; //['abc@xyz.com', 'abc@example.com']
$mail->recipient_name = "Amir Sanni";
$mail->cc = ['abc@xyz.com', 'abc@example.com']; //'abc@example.com'
$mail->bcc = 'abc@example.com'; //['abc@xyz.com', 'abc@example.com']
$mail->attach = ['file1', 'file2', 'file3']; //'file'
$mail->send_as_email = 'abc@xyz.com';

$mail->send();
```



## Create Draft
```
$mail->sender_name = "Foo Bar";
$mail->subject = "Test email";
$mail->message = "This is a test email";
$mail->recipient = 'abc@example.com'; //['abc@xyz.com', 'john.doe@example.com']
$mail->recipient_name = "Amir Sanni";
$mail->cc = ['abc@xyz.com', 'abc@example.com']; //'abc@example.com'
$mail->bcc = 'abc@example.com'; //['abc@xyz.com', 'abc@example.com']
$mail->attach = ['file1', 'file2', 'file3']; //'file'
$mail->send_as_email = 'abc@xyz.com';

$mail->createDraft();
```



## Get Messages
```
require "vendor/autoload.php";

use amirsanni\phpewswrapper\PhpEwsWrapper;

$mail = new PhpEwsWrapper('amir.sanni@mainone.net', 'Razafindrakoto10');

$mail->limit = 30;

//each of the methods takes an optional page_number of type int
$mail->getInboxMessages();//Messages in inbox
$mail->getSentItems(3);
$mail->getDraftItems();
$mail->getOutboxItems(1);
$mail->getConversationHistory();
$mail->getFavourites();
$mail->getJunkItems();
$mail->getDeletedMessages();
$mail->getArchivedMessages();
$mail->getContacts();
$mail->getTasks();
```


## Send Message From Draft
```
require "vendor/autoload.php";

use amirsanni\phpewswrapper\PhpEwsWrapper;

$mail = new PhpEwsWrapper('amir.sanni@mainone.net', 'Razafindrakoto10');

$mail->limit = 30;

$mail->getDraftItems();

```