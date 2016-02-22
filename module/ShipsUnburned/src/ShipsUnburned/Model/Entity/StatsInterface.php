<?php

namespace ShipsUnburned\Model\Entity;

interface StatsInterface
{
    public function getID();
            
    public function getTotalMatches();
    
    public function getWins();
    
    public function getLoses();
    
    public function getELO();
}
