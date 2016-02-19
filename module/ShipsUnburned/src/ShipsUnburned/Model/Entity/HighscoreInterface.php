<?php

namespace ShipsUnburned\Model\Entity;

interface HighscoreInterface
{
    public function getID();
    
    public function getIngameName();
            
    public function getELO();
}
