Mobile-Push-Messaging-Server
============================

Basically this server allows recording device tokens and lets you push messages to mobile devices such as iPhone, iPad and Android.

First, the devices must be register in APNS or GSM to get the token and It should be recorded on the server so they can receive the push messages. 

Next the server can be used to send push notifications to users. The server sends the message to the APNS (Apple Push Notification Service) and/or GSM.

And finally APNS and GSM sends the push notification to the user’s device.

Requirements
==============
- Bootstrap 2.3.1
- PHP 5
- MySql 5.5
- Apache 2.2

Licence
==============
Harvest is licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
