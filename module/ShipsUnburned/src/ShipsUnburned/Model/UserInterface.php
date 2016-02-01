<?php

namespace ShipsUnburned\Model;

interface UserInterface
{
    public function getID();
            
    public function getLoginName();
    
    public function getIngameName();
            
    public function getPassword();
            
    public function getAktiv();
            
    public function getRole();
}
