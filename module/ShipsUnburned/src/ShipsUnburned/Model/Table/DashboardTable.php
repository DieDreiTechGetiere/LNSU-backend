<?php

namespace ShipsUnburned\Model\Table;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use ShipsUnburned\Model\Entity\Stats;

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
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('view_Stats');
        $select->where(array('id = ?'=> $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())   
        {
            $stats = new Stats();
            $stats->exchangeArray($result->current());
            
            return $stats;
        }
    }
    
    public function getHighscoreList()
    {
        return array();
    }
}
