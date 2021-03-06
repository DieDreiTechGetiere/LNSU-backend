<?php

namespace ShipsUnburned\Model\Entity;

interface UserInterface
{
    public function getID();
            
    public function getLoginName();
    
    public function getIngameName();
            
    public function getHashedPassword();
            
    public function getAktiv();
            
    public function getRole();
    
    public function getELO();
    
    public function getTimestamp();
}
