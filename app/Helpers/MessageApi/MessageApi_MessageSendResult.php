<?php

namespace Ozeki_PHP_Rest
{
	class MessageSendResult
    {
        public $Message;       

        public $StatusMessage;

		public function __toString(){
			return $this -> StatusMessage . ", " . strval($this -> Message);
		}
	}
 }
?>