<?php
error_reporting(0);
$tok = '1416253643:AAGTs3QWj3-evzo4QyEDB3cSDhk5VYhakKc';
function botaction($method, $data){
	global $tok;
	global $dadel;
	global $dueto;
    $url = "https://api.telegram.org/bot$tok/$method";
    $curld = curl_init();
    curl_setopt($curld, CURLOPT_POST, true);
    curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curld, CURLOPT_URL, $url);
    curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curld);
    curl_close($curld);
    $dadel = json_decode($output,true);
    $dueto = $dadel['description'];
    return $output;
}
function startsWith($content,$startString)
{
$con_arr = explode(' ',$content);
	if($con_arr['0'] == $startString)
	{
	return true;
	}
	else
	{
	return false;
	}
}

$update = file_get_contents('php://input');
$update = json_decode($update, true);


$mid = $update['message']['message_id'];
$cid = $update['message']['chat']['id'];
$uid = $update['message']['chat']['id'];
$cname = $update['message']['chat']['username'];
$fid = $update['message']['from']['id'];
$fname = $update['message']['from']['first_name'];
$lname = $update['message']['from']['last_name'];
$uname = $update['message']['from']['username'];
$typ = $update['message']['chat']['type'];
$texts = $update['message']['text'];
$text = strtolower($update['message']['text']);
$fullname = ''.$fname.' '.$lname.'';
##################NEW MEMBER DATA ################
$new_member = $update['message']['new_chat_member'];
$gname = $update['message']['chat']['title'];
$nid = $update['message']['new_chat_member']['id'];
$nfname = $update['message']['new_chat_member']['first_name'];
$nlname = $update['message']['new_chat_member']['last_name'];
$nuname = $update['message']['new_chat_member']['username'];
$nfullname = ''.$nfname.' '.$nlname.'';
#################################################
$lfname = $update['message']['left_chat_member']['first_name'];
$llname = $update['message']['left_chat_member']['last_name'];
$luname = $update['message']['left_chat_member']['username'];
$reply_message = $update['message']['reply_to_message'];
$reply_message_id = $update['message']['reply_to_message']['message_id'];
$reply_message_user_id = $update['message']['reply_to_message']['from']['id'];
$reply_message_text = $update['message']['reply_to_message']['text'];
$reply_message_user_fname = $update['message']['reply_to_message']['from']['first_name'];
$reply_message_user_lname = $update['message']['reply_to_message']['from']['last_name'];
$reply_message_user_uname = $update['message']['reply_to_message']['from']['username'];
#######################################################################################
###########################CALL BACK DATA##############################################
$callback = $update['callback_query'];
$callback_id = $update['callback_query']['id'];
$callback_from_id = $update['callback_query']['from']['id'];
$callback_from_uname = $update['callback_query']['from']['username'];
$callback_from_fname = $update['callback_query']['from']['first_name'];
$callback_from_lname = $update['callback_query']['from']['last_name'];
$callback_user_data = $update['callback_query']['data'];
$callback_message_id = $update['callback_query']['message']['id'];
$cbid = $update['callback_query']['message']['chat']['id'];
$cbmid = $update['callback_query']['message']['message_id'];
$thug_chat_id = '';
$chat_id = (string)$cid;
$forward_user_id = $reply_message['forward_from']['id'];
$owner_id = '801636048';


$messages = file_get_contents("http://rocket-raccoon-robot.tk/messages.txt");
$messages = explode("\n", $messages);
$messages = implode('&', $messages);
parse_str($messages,$messages);

$START_TEXT = "<b>Hey <a href='t.me/$uname'>$fname</a> Nice To Meet You!! 
Well, Let Me Introduce Myself To You... 
I am a Computer Operated Bot Which helps You To Talk To My Master.... Just Send Me The Message And I Will Forward It To My Master!!...
Remeber Not To Annoy My Master</b>

#SayNoToPmsBot";

if($text == '/start')

{

if($owner_id == $chat_id)
{
	botaction("sendMessage",['chat_id'=>$cid,'text'=>"Ya Master I Am Alive !!",'parse_mode'=>'HTML','reply_to_message_id'=>$mid,'disable_web_page_preview'=>'True']);
}
else
{
botaction("sendMessage",['chat_id'=>$cid,'text'=>$START_TEXT,'parse_mode'=>'HTML','reply_to_message_id'=>$mid,'disable_web_page_preview'=>'True']);
}

}

else
{
if($chat_id == $owner_id)
{
	if($reply_message)
	{
		$get_user_reply_id = (int)$reply_message_id - 1;
		$get_user_id = $messages["$get_user_reply_id"];
		botaction("copyMessage",['from_chat_id'=>$owner_id,'chat_id'=>$get_user_id,'message_id'=>$mid]);
		print_r($dadel);
	}
}

else
{
	botaction("forwardMessage",['from_chat_id'=>$cid,'chat_id'=>$owner_id,'message_id'=>$mid]);
	file_get_contents("http://rocket-raccoon-robot.tk/message_add.php?mid=$mid&uid=$uid");
}

}
