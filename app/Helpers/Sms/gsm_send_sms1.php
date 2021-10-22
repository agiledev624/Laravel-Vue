<?php
require "php_serial.class.php";

function send_sms_final() {
$serial = new phpSerial;
$serial->deviceSet("COM1");
$serial->confBaudRate(115200);

// Then we need to open it
$serial->deviceOpen();

// To write into
$serial->sendMessage("AT+CMGF=1\n\r"); 
$serial->sendMessage("AT+cmgs=\"+61414556390\"\n\r");
$serial->sendMessage("sms text\n\r");
$serial->sendMessage(chr(26));

//wait for modem to send message
sleep(7);
$read=$serial->readPort();
$serial->deviceClose();
}
?>