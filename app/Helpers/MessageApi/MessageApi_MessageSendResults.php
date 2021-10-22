<?php

namespace Ozeki_PHP_Rest
{
	class MessageSendResults
    {
        public $TotalCount;
		
        public $SuccessCount;
		
        public $FailedCount;
		
        public $Results = array();
		
		
		public function __toString(){
			
            return "Total: " . TotalCount . ". Success: " . SuccessCount . ". Failed: " . FailedCount . ".";
        }
		
    }
 }
?>