<?php


namespace ShipsUnburned\Model;

interface DashboardInterface
{
    public function getMatchList();
    
    public function getStats();
    
    public function getHighscoreList();
}
