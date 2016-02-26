<?php

namespace ShipsUnburned\Model\Table;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use ShipsUnburned\Model\Entity\Stats;
use ShipsUnburned\Model\Entity\Match;
use ShipsUnburned\Model\Entity\MatchList;
use ShipsUnburned\Model\Entity\Highscore;
use ShipsUnburned\Model\Entity\HighscoreList;

class DashboardTable
{
    protected $dbAdapter;
    
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    /**
     * Gets the 5 last Matches for User by ID
     * @param type $id
     * @return MatchList
     */
    public function getMatchList($id)
    {
        $sql = new Sql($this->dbAdapter);
        
        //Creating WHERE OR Statement!!
        $where = new \Zend\Db\Sql\Where();
        $where
            ->nest()
            ->equalTo('tblmatch.User1', $id)
            ->or
            ->equalTo('tblmatch.User2', $id)
            ->unnest();
        
        //Inserting Statement into Select with ORDER BY 'Date' DESC and TOP 5
        $select = $sql->select('tblmatch')
                      ->where($where)
                      ->order('Date DESC')
                      ->limit(5);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())   
        {
            $array = array();
            $match = new Match();
            
            $match->exchangeArray($result->current());
            array_push($array, $match);
            
            // Minus 1 Because we already pushed 1 MatchObject into the Array
            for($count = $result->count() - 1; $count > 0; $count--)
            {
                $match = new Match();
                $match->exchangeArray($result->next());
                array_push($array, $match);
            }
            
            //Add all Matches to the MatchList
            $matchList = new MatchList();
            $matchList->addMatchesFromTable($array);
            
            return $matchList;
        }
        return new MatchList();
    }
    
    /**
     * Gets the stats for user by ID
     * @param type $id
     * @return Stats
     */
    public function getStats($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('view_stats');
        $select->where(array('id = ?'=> $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())   
        {
            $stats = new Stats();
            $stats->exchangeArray($result->current());   
            return $stats;
        }
        return new Stats();
    }
    
    /**
     * Gets top 10 highest ranked users
     * @return HighscoreList
     */
    public function getHighscoreList()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('view_highscore');
        //Preparing Statement with ORDER BY elo DESC and TOP 10
        $select->order('elo DESC')->limit(10);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())   
        {
            $array = array();
            $highscore = new Highscore();
            
            $highscore->exchangeArray($result->current());
            array_push($array, $highscore);
            
            // Minus 1 Because we already pushed 1 HighscoreObject into the Array
            for($count = $result->count() - 1; $count > 0; $count--)
            {
                $highscore = new Highscore();
                $highscore->exchangeArray($result->next());
                array_push($array, $highscore);
            }
            
            //Add all Highscores to the HighscoreList
            $highscoreList = new HighscoreList();
            $highscoreList->addMatchesFromTable($array);
            
            return $highscoreList;
        }   
        return new HighscoreList();
    }
}
