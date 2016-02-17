<?php

namespace ShipsUnburned\Model;

use ShipsUnburned\Model\MatchList;
use ShipsUnburned\Model\HighscoreList;
use ShipsUnburned\Model\Stats;

class Dashboard implements DashboardInterface
{
    protected $matchList;
    protected $highscoreList;
    protected $stats;
    
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
