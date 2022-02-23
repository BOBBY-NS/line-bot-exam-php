<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'H5bUh6VbEuHQ0MeDykJlXIEBM3pk/+BiZpHPLi+Kf1INXB+H5xEIgF0Slu9hUzaMZswmrV6f0VfZMqkhKXqK/ANZcJSO5PzsjySA69Qgs9usMo5eSf8wYG3ngzz/W0Z6gerGWrCVxJ2E1ZLxOs8lZQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = 'http://172.29.226.11/NS/Support/BobbyCare/AddPushID?emID=' . $event['message']['text'] . '&pushID=' . $event['source']['userId'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = 	array(
				   'type' => 'imagemap',
				   'baseUrl' => 'https://images.unsplash.com/photo-1453728013993-6d66e9c9123a',
				   'altText' => 'this is an imagemap',
				   'baseSize' => 
				 array(
				     'width' => 1040,
				     'height' => 1040,
				  ),
				  'actions' => 
				  array (
				    0 => 
				    array(
				       'type' => 'uri',
				       'linkUri' => 'https://images.unsplash.com/photo-1453728013993-6d66e9c9123a',
				       'area' => 
				      array(
					 'x' => 0,
					 'y' => 586,
					 'width' => 520,
					 'height' => 454,
				      ),
				    ),   
				    array(
				       'type' => 'message',
				       'text' => 'hello',
				       'area' => 
				     array(
					 'x' => 520,
					 'y' => 586,
					 'width' => 520,
					 'height' => 454,
				      )
				    )
				  )
				);

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
