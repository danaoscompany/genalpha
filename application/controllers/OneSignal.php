<?php

class OneSignal extends CI_Controller {
	
	public static function send_message($playerID, $title, $body) {
		$content = array(
        	"en" => 'Testing Message'
        );
    	$fields = array(
        	'app_id' => "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxxx",
        	'included_segments' => array('All'),
        	'data' => array("foo" => "bar"),
        	'large_icon' =>"ic_launcher_round.png",
        	'contents' => $content
    	);
    	$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, FALSE);
	    curl_setopt($ch, CURLOPT_POST, TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
	    $response = curl_exec($ch);
	    curl_close($ch);
	}
}
