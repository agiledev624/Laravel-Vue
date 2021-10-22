<?php
namespace Ozeki_PHP_Rest
{
require 'MessageApi/MessageApi.php';

		$configuration = new Configuration();
		
		$configuration -> Username = "mark";
		$configuration -> Password = "mark";
		$configuration -> ApiUrl = "http://localhost:9509/api";
		
		$msg = new Message();
		
		$msg -> ToAddress = "+61414556390";
		$msg -> Text = "This is from php code!";
			
		$api = new MessageApi($configuration);
		
		$result = $api -> SendSingle($msg);	
		
		echo strval($result);
}		
?>