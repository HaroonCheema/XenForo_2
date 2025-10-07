<?php

namespace FS\CallWhatsApp\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public function canCallNumber(){
        
        if(!$this->LastPost){
            
            return;
        }
        
        if(!$this->LastPost->message){
            
            return ;
        }
        
        preg_match('/(\+?\d[\d\s\-]{6,20}\d)/', $this->LastPost->message, $matches);
        $rawNumber = $matches[0] ?? '';

        if (!$rawNumber) {
            return null;
        }
        
        return $rawNumber;
    }
   
}
