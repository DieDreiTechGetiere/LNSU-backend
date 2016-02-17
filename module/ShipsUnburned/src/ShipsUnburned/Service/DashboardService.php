<?php

namespace ShipsUnburned\Service;

use ShipsUnburned\Model\DashboardTable;
use ShipsUnburned\Model\MatchList;
use ShipsUnburned\Model\HighscoreList;
use ShipsUnburned\Model\Dashboard;
use ShipsUnburned\Model\Stats;

class DashboardService
{
    protected $dashboardTable;
    protected $recentMatchList;
    protected $yourStats;
    protected $recentHighscoreList;
    
    
    public function __construct(DashboardTable $dashboardTable,
                                MatchList $recentMatchList,
                                HighscoreList $recentHighscoreList,
                                Stats $yourStats)
    {
        $this->dashboardTable      = $dashboardTable;
        $this->recentMatchList     = $recentMatchList;
        $this->yourStats           = $yourStats;
        $this->recentHighscoreList = $recentHighscoreList;
    }
    
    public function getDashboardData($id)
    {
        $this->setRecentMatchList($id);
        $this->setYourStats($id);
        $this->setRecentHighscoreList();
        return new Dashboard($this->recentMatchList, $this->yourStats, $this->recentHighscoreList);
    }
    
    //Setter for Properties
    private function setRecentMatchList($id)
    {
        $this->recentMatchList->setList($this->dashboardTable->getMatchList($id));
    }
    
    private function setYourStats($id)
    {
        $this->yourStats->setStats($this->dashboardTable->getStats($id));
    }
    
    private function setRecentHighscoreList()
    {
        $this->recentHighscoreList->setList($this->dashboardTable->getHighscoreList());
    }
}
