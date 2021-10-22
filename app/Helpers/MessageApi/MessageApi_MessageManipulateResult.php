<?php

namespace Ozeki_PHP_Rest
{	
	class MessageManipulateResult
    {
        public $Folder;
        public $MessageIds = array();        
		
		function GetMessageIdCount(){
			return count($this -> MessageIds);
		}
		
		public function __toString()
		{
            return "Updated count: " . $this -> GetMessageIdCount() . ". Folder: " . $this -> Folder . ".";
        }
    }
}
?>