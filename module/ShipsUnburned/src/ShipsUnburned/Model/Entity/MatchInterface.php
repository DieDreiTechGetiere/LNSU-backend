<?php

namespace ShipsUnburned\Model\Entity;

interface MatchInterface
{
    public function getID();
            
    public function getUser1();
    
    public function getUser2();
            
    public function getDate();
            
    public function getWinner();
    
    public function getUser1ELO();
    
    public function getUser2ELO();
}
