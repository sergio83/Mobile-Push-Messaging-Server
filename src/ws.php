<?php


require_once("services.php");  
	
$opc = isset($_GET["opc"])?$_GET["opc"]:"";

if($opc=="addIphone"){
	addIphoneDevice();
}else if($opc=="addAndroid"){
	$token = isset($_GET["token"])?$_GET["token"]:"";
	$clientid= isset($_GET["clientid"])?$_GET["clientid"]:"";
	$appname= isset($_GET["appname"])?$_GET["appname"]:"";
	$appversion= isset($_GET["appversion"])?$_GET["appversion"]:"";
	$devicemodel= isset($_GET["devicemodel"])?$_GET["devicemodel"]:"";
	$deviceversion= isset($_GET["deviceversion"])?$_GET["deviceversion"]:"";
	$devicename = isset($_GET["devicename"])?$_GET["devicename"]:"";

	addAndroidDevice($token,$clientid,$appname,$appversion,$devicename,$devicemodel,$deviceversion);

}else if($opc=="deleteAndroid"){
	$token = isset($_GET["token"])?$_GET["token"]:"";
	removeAndroidDevice($token);
}else if($opc=="devices"){
	echo(getDevices());
}else if($opc=="messages"){
	echo(getMessages());	
}else if($opc=="send"){
	$message = isset($_GET["message"])?$_GET["message"]:"";
	$to = isset($_GET["to"])?$_GET["to"]:"All";
	$updateContent = isset($_GET["update"])?$_GET["update"]:"0";
	sendMessage($message,$to,$updateContent);
}
?>