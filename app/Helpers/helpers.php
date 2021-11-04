<?php
include 'PhpSerial.php';

use Illuminate\Support\Facades\Auth;
require_once('Sms.php');
require_once('Sms/Interface.php');
require_once('Sms/Serial.php');
require_once('Sms/Http.php');
// require_once('Sms/gsm_send_sms.php');
<<<<<<< Updated upstream
// require_once('Sms/gsm_send_sms1.php');
$pin = 1234;
require_once('testHttp.php');
=======

// $pin = 1234;

>>>>>>> Stashed changes

if (!function_exists('send_rs232')) {
    function _str2hex($string) {
        $string = str_replace(' ', '', $string);
        $str = '';
        for ($i = 0; $i < strlen($string); $i += 2) {
           $str .= chr(hexdec(substr($string, $i, 2)));
        }
        return $str;
     }

    function send_rs232($port, $hex_cmd) {
        $serial = new PhpSerial;
        $serial->deviceSet("COM".$port);
        $serial->confBaudRate(9600);
        $serial->confParity("none");
        $serial->confCharacterLength(8);
        $serial->confStopBits(1);
        $serial->confFlowControl("none");
        if ($serial->deviceOpen()) {
            $serial->sendMessage(_str2hex($hex_cmd));
            $read = $serial->readPort();
            $serial->deviceClose();
            return true;
        }
        return false;
        // echo "Read Data:".$read;
    }

}
<<<<<<< Updated upstream

if (!function_exists('send_sms')) {
    function send_sms($port, $number, $msg) {
        try {
            


$serialEternetConverterIP = '127.0.0.1';
$serialEternetConverterPort = 5000;
$pin = 1234;

try {
    $sms = Sms::factory(new Sms_Http($serialEternetConverterIP, $serialEternetConverterPort));
    $sms->insertPin($pin);

    if ($sms->sendSMS(61414556390, "test Hi")) {
        echo "SMS Sent\n";
    } else {
        echo "Sent Error\n";
    }

    // Now read inbox
    foreach ($sms->readInbox() as $in) {
        echo"tlfn: {$in['tlfn']} date: {$in['date']} {$in['hour']}\n{$in['msg']}\n";

        // now delete sms
        if ($sms->deleteSms($in['id'])) {
            echo "SMS Deleted\n";
        }
    }
} catch (Exception $e) {
    switch ($e->getCode()) {
        case Sms::EXCEPTION_NO_PIN:
            echo "PIN Not set\n";
            break;
        case Sms::EXCEPTION_PIN_ERROR:
            echo "PIN Incorrect\n";
            break;
        case Sms::EXCEPTION_SERVICE_NOT_IMPLEMENTED:
            echo "Service Not implemented\n";
            break;
        default:
            echo $e->getMessage();
=======
// namespace Ozeki_PHP_Rest ;
    require 'MessageApi/MessageApi.php';
if (!function_exists('send_sms_via_gsm')) {
<<<<<<< Updated upstream
    function send_sms_via_gsm($number, $text) {
        
		$configuration = new Ozeki_PHP_Rest\Configuration();
		
		$configuration -> Username = "mark";
		$configuration -> Password = "mark";
		$configuration -> ApiUrl = "http://localhost:9509/api";
		
		$msg = new Ozeki_PHP_Rest\Message();
		
		$msg -> ToAddress = $number;
<<<<<<< Updated upstream
		$msg -> Text = $text;
			
		$api = new Ozeki_PHP_Rest\MessageApi($configuration);
		
		$result = $api -> SendSingle($msg);	
		
		// echo strval($result);
        return $result;
>>>>>>> Stashed changes
    }
}

// $serial = new PhpSerial;
//         $serial->deviceSet("COM".$port);
//         $serial->confBaudRate(9600);
//         $serial->confParity("none");
//         $serial->confCharacterLength(8);
//         $serial->confStopBits(1);
//         $serial->confFlowControl("none");
//         if ($serial->deviceOpen()) {
//             $serial->sendMessage(_str2hex($hex_cmd));
//             $read = $serial->readPort();
//             $serial->deviceClose();
//             return true;
//         }
//         return false;

//         $serial->deviceSet("COM1");
// $serial->confBaudRate(115200);

// // Then we need to open it
// $serial->deviceOpen();

// // To write into
// $serial->sendMessage("AT+CMGF=1\n\r"); 
// $serial->sendMessage("AT+cmgs=\"+61414556390\"\n\r");
// $serial->sendMessage("sms text\n\r");
// $serial->sendMessage(chr(26));

// //wait for modem to send message
// sleep(7);
// $read=$serial->readPort();
// $serial->deviceClose();

            // $gsm_send_sms = new gsm_send_sms();
            // $gsm_send_sms->debug = true;
            // $gsm_send_sms->port = 'COM'.$port;
            // $gsm_send_sms->baud = 9600;
            // $gsm_send_sms->init();

            // $status = $gsm_send_sms->send($number,$msg);
            // $gsm_send_sms->close();

            // $pin = 1234;
            // $serial = new Sms_Serial;
            // $serial->deviceSet("/dev/ttyS".$port);
            // $serial->confBaudRate(9600);
            // $serial->confParity('none');
            // $serial->confCharacterLength(8);
            
            // $sms = Sms::factory($serial)->insertPin($pin);

            // if ($sms->sendSMS($number, $msg)) {
            //     echo "SMS sent\n";
            // } else {
            //     echo "Sent Error\n";
            // }

            // Now read inbox
            
            // foreach ($sms->readInbox() as $in) {
            //     echo"tlfn: {$in['tlfn']} date: {$in['date']} {$in['hour']}\n{$in['msg']}\n";

            //     // now delete sms
            //     if ($sms->deleteSms($in['id'])) {
            //         echo "SMS Deleted\n";
            //     }
            // }
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case Sms::EXCEPTION_NO_PIN:
                    echo "PIN Not set\n";
                    break;
                case Sms::EXCEPTION_PIN_ERROR:
                    echo "PIN Incorrect\n";
                    break;
                case Sms::EXCEPTION_SERVICE_NOT_IMPLEMENTED:
                    echo "Service Not implemented\n";
                    break;
                default:
                    echo $e->getMessage();
            }
        }
    }
}