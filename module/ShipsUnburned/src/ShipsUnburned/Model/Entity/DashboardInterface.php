<?php


namespace ShipsUnburned\Model\Entity;

interface DashboardInterface
{
    public function getMatchList();
    
    public function getStats();
    
    public function getHighscoreList();
}
