<?php

namespace Ozeki_PHP_Rest
{	
	class MessageReceiveResult
    {	
		public $Folder;
		
		public $Limit;
		
		public $Messages = array();
		
		function GetMessageCount(){
			return count($this -> Messages);
		}
		
		public function __toString(){
			
            return "Message count: " . $this -> GetMessageCount() . ".";
        }	
	}
}
?>