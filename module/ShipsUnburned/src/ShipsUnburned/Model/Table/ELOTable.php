<?php

namespace ShipsUnburned\Model\Table;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;

class ELOTable
{
    protected $dbAdapter;
    protected $eloService;
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->eloService = new \ShipsUnburned\Service\ELOCalculatorService();
    }
    
    public function calculateNewELO($matchID, $userID)
    {
        $totalOppELO = $this->calculateNewTotalOppELO($matchID, $userID);
        
        $wins = $this->getWins($userID);
        $loses = $this->getLoses($userID);
        
        $newELO = $this->eloService->calculateNewELO($totalOppELO, $wins, $loses);
        
        $this->saveNewELOToDatabase($newELO, $userID);
        
        return $newELO;
    }
    /**
     * Returns new totalOppELO
     * @param type $matchID
     * @param type $userID
     * @return int
     */
    protected function calculateNewTotalOppELO($matchID, $userID)
    {
        $sql = new Sql($this->dbAdapter);
        
        $select = $sql
                ->select('tbluser')
                ->columns(array('totalOppELO'))
                ->where(array('id = ?' => $userID));
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        $OpponentELO = $this->getOpponentELOByMatchID($matchID, $userID);
        
        return (int)$result->current() + (int)$OpponentELO;
        
    }
    /**
     * Returns ELO of the Opponent from Match
     * @param type $matchID
     * @param type $userID
     * @return int
     */
    protected function getOpponentELOByMatchID($matchID, $userID)
    {
        $match = $this->getMatch($matchID);
        
        //Check where the ELO of the Opponent is written
        if ($match->getUser1() == $userID )
        {
            return $match->getUser2ELO();
        }
        else
        {
            return $match->getUser1ELO();
        }
    }
    /**
     * Get Wins from view_stats
     * @param int $userID
     * @return int
     */
    protected function getWins($userID)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('view_stats');
        $select->columns(array('wins'))->where(array('id = ?'=> $userID));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute(); 
        
        return $result->current();        
    }
     /**
     * Get Loses from view_stats
     * @param int $userID
     * @return int
     */
    protected function getLoses($userID)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('view_stats');
        $select->columns(array('loses'))->where(array('id = ?'=> $userID));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();  
        
        return $result->current();
    }
    
    /**
     * Gets a Match by ID
     * @param type $matchID
     * @return \ShipsUnburned\Model\Table\Match
     */
    protected function getMatch($matchID)
    {
        //REFACTORING NEEDED (SAME EXISTS IN GameTable Class)
        $sql = new Sql($this->dbAdapter);
        
        $select = $sql
                ->select('tblmatch')
                ->where(array('matchID = ?' => $matchID));
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();        
        
        $match = new Match();
        $match->exchangeArray($result->current());        
        
        return $match;
    }
    
    protected function saveNewELOToDatabase($newELO, $userID)
    {
        $sql = new Sql($this->dbAdapter);
        
        $where = new \Zend\Db\Sql\Where();
        $where->nest()
              ->equalTo('tbluser.id', $userID);
        
        $update = $sql
                ->update('tbluser')
                ->set(array('ELO' => $newELO))
                ->where($where);
        
        $stmt = $sql->prepareStatementForSqlObject($update);
        $stmt->execute(); 
    }
}
