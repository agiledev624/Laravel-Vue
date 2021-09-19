<?php
include 'PhpSerial.php';

use Illuminate\Support\Facades\Auth;

if (!function_exists('send_rs232')) {
    function _str2hex($string) {
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