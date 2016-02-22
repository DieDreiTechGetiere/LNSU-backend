<?php

namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Table\DashboardTable;
use ShipsUnburned\Model\Entity\Dashboard;

class DashboardService
{
    protected $dashboardTable;
    protected $recentMatchList;
    protected $yourStats;
    protected $recentHighscoreList;
    
    
    public function __construct(DashboardTable $dashboardTable)
    {
        $this->dashboardTable      = $dashboardTable;
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
        $this->recentMatchList = $this->dashboardTable->getMatchList($id);
    }
    
    private function setYourStats($id)
    {
        $this->yourStats = $this->dashboardTable->getStats($id);
    }
    
    private function setRecentHighscoreList()
    {
        $this->recentHighscoreList = $this->dashboardTable->getHighscoreList();
    }
}
