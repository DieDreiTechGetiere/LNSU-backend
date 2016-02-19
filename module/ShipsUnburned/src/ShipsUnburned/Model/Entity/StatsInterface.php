<?php

namespace ShipsUnburned\Model\Entity;

interface StatsInterface
{
    public function getID();
            
    public function getTotalMatches();
    
    public function getWL();
    
    public function getScore();
}
