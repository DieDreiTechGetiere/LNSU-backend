<?php

namespace ShipsUnburned\Model\Table;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;

class DashboardTable
{
    protected $dbAdapter;
    
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function getMatchList($id)
    {
        return array();
    }
    
    public function getStats($id)
    {
        return array();
    }
    
    public function getHighscoreList()
    {
        return array();
    }
}
