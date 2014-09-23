<?php
    include 'dbclass.php';
	
	class dec extends db{
		
        public function decy($tb){
            $ret = "";
            
            $ret = $this->decode($tb);
            
            return $ret;
        }
		
	}
	
?>