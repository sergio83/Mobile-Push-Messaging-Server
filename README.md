Mobile-Push-Messaging-Server
============================

Basically this server allows recording device tokens and lets you push messages to mobile devices such as iPhone, iPad and Android.

First, the devices must be register in APNS or GSM to get the token and It should be recorded on the server so they can receive the push messages. 

Next the server can be used to send push notifications to users. The server sends the message to the APNS (Apple Push Notification Service) and/or GSM.

And finally APNS and GSM sends the push notification to the user’s device.


<br>
<a href='http://postimage.org/' target='_blank'><img src='http://s28.postimg.org/o8ega2la5/Captura_de_pantalla_2014_04_05_a_la_s_02_53_39.png' border='0' alt="Captura de pantalla 2014 04 05 a la(s) 02 53 39" /></a>
<br>


Requirements
==============
- Bootstrap 2.3.1
- PHP 5
- MySql 5.5
- Apache 2.2

Licence
==============
Harvest is licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
