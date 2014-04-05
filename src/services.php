<?php
	require_once("include/config.php");  
	require_once("android/GCMPushMessage.php"); 
	
	require_once("iphone/classes/class_APNS.php");
	require_once("iphone/classes/class_DbConnect.php");	
	
	// AUTOLOAD CLASS OBJECTS... YOU CAN USE INCLUDES IF YOU PREFER
	if(!function_exists("__autoload")){ 
		function __autoload($class_name){
			require_once('iphone/classes/class_'.$class_name.'.php');
		}
	}

//----------------------------------------------------------------------------------------	
function openAndroidDB(){

	$link = @mysql_connect(db_server, db_user, db_password);
	
	if(!$link) {
    	die("MSSQL Error");
    }
	
	@mysql_select_db (db_database, $link);
	
	return $link;
}
//----------------------------------------------------------------------------------------			
function CloseDB(&$link){
    mysql_close ($link); 
}
//----------------------------------------------------------------------------------------	
function removeAndroidDevice($token){
	$link = openAndroidDB();
	$query="DELETE FROM apns_devices WHERE devicetoken = '".$token."'";
	$result = @mysql_query($query,$link);
	$row = @mysql_fetch_assoc($result);
	CloseDB(&$link);
}
//----------------------------------------------------------------------------------------	
function addAndroidDevice($token,$clientid,$appname,$appversion,$devicename,$devicemodel,$deviceversion){
	$link = openAndroidDB();
	
	if(!isset($token) || $token==""){
		echo('{"Error":"token null"}');
		return;
	}
	
	$development = "production";
	if(isSandbox=="TRUE")
		$development = "sandbox";	
			
	$query="SELECT * FROM apns_devices WHERE devicetoken='$token'";
	$result = @mysql_query($query,$link);	

	if(mysql_num_rows($result)!=0)
		return;
		
	$query="INSERT INTO apns_devices (devicetoken,devicetype ,created,pushbadge,pushalert,pushsound,development,clientid,appname,appversion,devicemodel,deviceversion,modified,devicename) VALUES ('".$token."','Android', CURRENT_TIMESTAMP,'disabled','enabled','disabled','$development','$clientid','$appname','$appversion','$devicemodel','$deviceversion',CURRENT_TIMESTAMP,'$devicename')";
	$result = @mysql_query($query,$link);
	$row = @mysql_fetch_assoc($result);
	CloseDB(&$link);
}
//----------------------------------------------------------------------------------------	
function addIphoneDevice(){
	// CREATE DATABASE OBJECT ( MAKE SURE TO CHANGE LOGIN INFO IN CLASS FILE )
	$db = new DbConnect();
	$db->show_errors();
	
	// FETCH $_GET OR CRON ARGUMENTS TO AUTOMATE TASKS
	$args = (!empty($_GET)) ? $_GET:array('task'=>$argv[1]);
	
	// CREATE APNS OBJECT, WITH DATABASE OBJECT AND ARGUMENTS
	$apns = new APNS($db, $args);
}
//----------------------------------------------------------------------------------------	
function getDevices(){
	$link = openAndroidDB();
	$query="SELECT * FROM apns_devices ORDER BY created DESC";
	$result = @mysql_query($query,$link);

	$array = array();
	
	while($row = @mysql_fetch_assoc($result)){
		$device["date"]=$row["created"];
		$device["id"]=$row["devicetoken"];
		$device["devicetype"]=$row["devicetype"];
		$device["deviceversion"]=$row["deviceversion"];
		$device["appversion"]=$row["appversion"];
		$array[] = $device;
	}
	
	CloseDB(&$link);
	return json_encode($array);
}
//----------------------------------------------------------------------------------------	
function getMessages(){
	$link = openAndroidDB();
	$query="SELECT * FROM apns_messages GROUP BY created ORDER BY created DESC";
	$result = @mysql_query($query,$link);

	$array = array();
	
	while($row = @mysql_fetch_assoc($result)){
		$device["date"]=$row["created"];
		$device["status"]=$row["status"];
		$obj = json_decode($row["message"]);
		
		$device["message"]="";
		if(isset($obj) && isset($obj->aps) && isset($obj->aps->alert))
			$device["message"]=$obj->aps->alert;
		$array[] = $device;
	}
	
	CloseDB(&$link);
	return json_encode($array);
}
//----------------------------------------------------------------------------------------	
function sendMessageToIphones($msg,$badge,$index,$updateContent){
	
	// CREATE DATABASE OBJECT ( MAKE SURE TO CHANGE LOGIN INFO IN CLASS FILE )
	$db = new DbConnect();
	$db->show_errors();
	// FETCH $_GET OR CRON ARGUMENTS TO AUTOMATE TASKS
	$apns = new APNS($db);

	// Get a list of devices that want to receive updates
	$sql = "SELECT `pid` FROM `apns_devices` WHERE `status`='active';";
	$result = $db->query($sql);
	$pids = array();
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
  	 $pids[] = intval($row['pid']);
	}

	if(sizeof($pids)==0)
		return;
	
	//print_r($pids);
	
	// APPLE APNS EXAMPLE 1
	$apns->newMessage($pids,NULL,clientId,$updateContent);
	
	if(isset($msg) && $msg!="")
		$apns->addMessageAlert($msg);
		
	$apns->addMessageBadge($badge);
	$apns->addMessageSound('default');
	//$apns->addMessageSound('soft.caf');
	//Si le quiero pasar algun parametro a la app
	if($index!="")
		$apns->addMessageCustom('index', $index);
				
	$apns->queueMessage();
	$apns->processQueue();


}
//----------------------------------------------------------------------------------------	
function sendMessageToAndroids($message){
	$devices = array();
	$link = openAndroidDB();
	$query="SELECT devicetoken FROM apns_devices WHERE devicetype='Android'";
	$result = @mysql_query($query,$link);
	
	while($row = @mysql_fetch_assoc($result)){
		if(isset($row["devicetoken"]) && $row["devicetoken"]!="" && sizeof($row["devicetoken"])!=0){
			$devices[] = $row["devicetoken"];
		}
	}
	CloseDB(&$link);
	
	if(sizeof($devices)==0)
		return;
		
	$gcpm = new GCMPushMessage(android_apiKey);
	$gcpm->setDevices($devices);
	$response = $gcpm->send($message);
	
}
//----------------------------------------------------------------------------------------	
function sendMessage($message,$to="All",$updateContent){

	if($message!="" && ($to=="All" || $to=="Android")){
		sendMessageToAndroids($message);		
		
		if($to!="All" && $to=="Android"){
			$link = openAndroidDB();
			$msg = '{"aps":{"clientid":"'.clientId.'","alert":"'.$message.'","sound":"default"}}';
			$sql = "INSERT INTO `apns_messages` VALUES (NULL,'".clientId."','0','$msg',CURRENT_TIMESTAMP,'delivered',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);";
			$result = @mysql_query($sql,$link);
			CloseDB(&$link);
		}
	}

	if((($message=="" && ($updateContent=="1" || $updateContent=="true")) || $message!="") && ($to=="All" || $to=="Iphone")){
		sendMessageToIphones($message,"","",$updateContent);
	}
	
	echo("{}");
}
//----------------------------------------------------------------------------------------	
	
?>