<?php

namespace ShipsUnburned\Model\Table;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use ShipsUnburned\Model\Entity\Match;
use ShipsUnburned\Model\Entity\User;

class GameTable
{   
    protected $dbAdapter;
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function searchGame($id)
    {
        $user = $this->getUser($id);
        
        $sql = new Sql($this->dbAdapter);
        
        //Creating WHERE OR Statement!!
        $where = new \Zend\Db\Sql\Where();
        $where
            ->nest()
            ->equalTo('tblmatch.User1', NULL)
            ->or
            ->equalTo('tblmatch.User2', NULL)
            ->unnest();        
        $select = $sql->select('tblmatch')
                      ->where($where)
                      ->order('Date ASC');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult())
        {
            //Checking if a Match with only one User exists or not
            if ($result->getAffectedRows() > 0)
            {
                //Update that match with current userID and ELO
                $match = $this->insertUserIDifMatchExists($result, $user);
                //Match can start
                return array('match' => json_encode($match),
                             'foundOpponent' => true);                
            }
            else
            {
                //Insert new Match with current userID, ELO and Date
                $match = $this->createNewMatch($user);
                //Need to wait for an opponent
                return array('match' => json_encode($match),
                             'foundOpponent' => false);
                
            }
        }
    }
    
    public function checkMatch($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tblmatch')
                      ->where(array('matchID = ?' => $id));
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult())
        {
            $newMatch = new Match();
            $newMatch->exchangeArray($result->current());
            //Check if both player are set and the game can start
            if ($newMatch->getUser1() && $newMatch->getUser2())
            {
                return array ('match' => json_encode($newMatch),
                              'foundOpponent' => true);
            }
            else
            {
                return array ('match' => json_encode($newMatch),
                              'foundOpponent' => false);
            }
        }
    }
    
    /**
     * Updates Match by ID
     * @param ResultSet $result
     * @param User $user
     * @return Match
     */
    protected function insertUserIDifMatchExists($result, $user)
    {
        $match = new Match();
        $match->exchangeArray($result->current());

        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('tblmatch');

        $update->where(array('matchID = ?' => $match->getID()));
        
        //Updates User1 or User2 depending on which is empty
        if($match->getUser1())
        {
            $update->set(array('User2' => $user->getID(),
                                'User2ELO' => $user->getELO()));    
        }
        else
        {
            $update->set(array('User1' => $user->getID(),
                                'User1ELO' => $user->getELO()));
        }      
        $stmt = $sql->prepareStatementForSqlObject($update);
        $updatedMatch = $stmt->execute();
        
        //return updated Match
        return $match->exchangeArray($updatedMatch->getGeneratedValue());
    }
    
    /**
     * Inserts new Match into tblMatch
     * @param User $user
     * @return Match
     */
    protected function createNewMatch($user)
    {
        $match = new Match();
        
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('tblmatch');
        $insert->columns(array('User1' => $user->getID(),
                                'User1ELO' => $user->getELO(),
                                'Date' => new \DateTime()));
        
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $newMatch = $stmt->execute();
        
        return $match->exchangeArray($newMatch->getGeneratedValue());
    }
    
    /**
     * Get current User as Object
     * @param int $id
     * @return User
     */
    protected function getUser($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbluser');
        $select->where(array('id = ?'=> $id));
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();        
        
        $user = new User();
        return $user->exchangeArray($result->current);
    }
}
