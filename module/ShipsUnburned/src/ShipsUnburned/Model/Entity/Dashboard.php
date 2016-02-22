<?php

namespace ShipsUnburned\Model\Entity;

use ShipsUnburned\Model\Entity\MatchList;
use ShipsUnburned\Model\Entity\HighscoreList;
use ShipsUnburned\Model\Entity\Stats;

class Dashboard implements DashboardInterface
{
    public $matchList;
    public $highscoreList;
    public $stats;
    
    public function __construct(MatchList $matchList, 
                                Stats $stats, 
                                HighscoreList $highscoreList)
    {
        $this->matchList = $matchList;
        $this->stats = $stats;
        $this->highscoreList = $highscoreList;
    }
    
    public function getMatchList()
    {
        return $this->matchList;
    }
    
    public function getStats()
    {
        return $this->stats;
    }
    
    public function getHighscoreList()
    {
        return $this->highscoreList;
    }    
    
    public function setMatchList(MatchList $matchList)
    {
        $this->matchList = $matchList;
    }
    
    public function setStats(Stats $stats)
    {
        $this->stats = $stats;
    }
    
    public function setHighscoreList(HighscoreList $highscoreList)
    {
        $this->highscoreList = $highscoreList;
    }
}
