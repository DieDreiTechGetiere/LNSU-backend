<?php

namespace ShipsUnburned\Model\Table;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use ShipsUnburned\Model\Entity\Stats;
use ShipsUnburned\Model\Entity\Match;

class DashboardTable
{
    protected $dbAdapter;
    
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function getMatchList($id)
    {
        $sql = new Sql($this->dbAdapter);
        //Creating OR Statement!!
        $where = new \Zend\Db\Sql\Where();
        $where
            ->nest()
            ->equalTo('tblmatch.User1', $id)
            ->or
            ->equalTo('tblmatch.User2', $id)
            ->unnest();
        //Inserting Statement into Select
        $select = $sql->select()->where($where);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())   
        {
            $return = array();
            $match = new Match();
            
            $match->exchangeArray($result->current());
            array_push($return, $match);
            // Minus 1 Because we already pushed 1 MenuObject into the Array
            for($count = $result->count() - 1; $count > 0; $count--)
            {
                $match = new Match();
                $match->exchangeArray($result->next());
                array_push($return, $match);
            }      
            return $return;
        }
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
