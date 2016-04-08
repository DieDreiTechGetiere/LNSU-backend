<?php

namespace ShipsUnburned\Model\Entity;

interface MatchStepInterface
{
    public function getID();
            
    public function getMatchID();
    
    public function getUserID();
            
    public function getX();
            
    public function getY();
    
    public function getState();
    
    public function getRoundNumber();
    
    public function getRoundFinished();    
}
