<?php

namespace ShipsUnburned\Model\Table;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use ShipsUnburned\Model\Entity\Match;
use ShipsUnburned\Model\Entity\User;
use ShipsUnburned\Model\Entity\Ship;
use ShipsUnburned\Model\Entity\Hit;
use ShipsUnburned\Service\ShipService;
use Zend\Db\Sql\Expression;

class GameTable
{   
    protected $dbAdapter;
    protected $shipService;
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->shipService = new ShipService();
    }
    
    public function searchGame($id)
    {
        $user = $this->getUser($id);
        
        $sql = new Sql($this->dbAdapter);
        
        //Creating WHERE OR Statement!!
        $where = new \Zend\Db\Sql\Where();
        $where
            ->nest()
            ->equalTo('tblmatch.User1', 0)
            ->or
            ->equalTo('tblmatch.User2', 0)
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
                return array('match' => $match,
                             'foundOpponent' => true);                
            }
            else
            {
                //Insert new Match with current userID, ELO and Date
                $match = $this->createNewMatch($user);
                //Need to wait for an opponent
                return array('match' => $match,
                             'foundOpponent' => false);
                
            }
        }
    }
    
    public function checkMatch($id)
    {   
        $match = $this->getMatch($id);
        
        //Check if both player are set and the game can start
        if ($match->getUser1() && $match->getUser2())
        {
            return array ('match' => $match,
                          'foundOpponent' => true);
        }
        else
        {
            return array ('match' => $match,
                          'foundOpponent' => false);
        }
    }
    
    /**
     * Delete current Match for cancelation
     * @param Integer $id
     * @return array
     */
    public function cancelMatch($id)
    {
        $sql = new Sql($this->dbAdapter);
        $delete = $sql->delete('tblmatch');
        $delete->where(array('matchID = ?' => $id));
        
        $stmt = $sql->prepareStatementForSqlObject($delete);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface)
        {
            return array('canceled' => true);
        }
        
        return array('canceled' => false);
    }
    
    /**
     * Inserts all ships into tblshipposition
     * @param type $userID
     * @param type $matchID
     * @param array $ships
     * @return array
     */
    public function insertPlacementPhase($userID, $matchID, array $ships)
    {
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('tblshipposition');
        //Insert all Ships in the array $ships
        for($i = 0; $i < count($ships); $i++)
        {
            $insert->values(array('spMatchID' => $matchID,
                                    'spUserID' => $userID,
                                    'spLength' => $ships[$i]->getLength(),
                                    'spX' => $ships[$i]->getX(),
                                    'spY' => $ships[$i]->getY(),
                                    'spDirection' => $ships[$i]->getDirection()));    
            $stmt = $sql->prepareStatementForSqlObject($insert);
            $result = $stmt->execute();     
            
            if(!($result instanceof ResultInterface))
            {
                return array('error' => 'Database error');
            }
        }
        
        return $this->checkIfOpponentIsFinishedWithPlacement($matchID, $userID);      
    }
    
    public function insertMatchStep($userID, $matchID, $x, $y)
    {
        $isHit = $this->checkIfShipIsHit($userID, $matchID, $x, $y);
        $isFinished = false;
        
        if($isHit == false)
        {
            $isFinished = true;
        }
        
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('tblmatchsteps')
                ->values(array('mMatchID' => $matchID,
                                'mUserID' => $userID,
                                'mRow' => $x,
                                'mColumn' => $y,
                                'mState' => $isHit,
                                'mRoundFinished' => $isFinished));
        
    }
    
    /**
     * Checks if Opponent is finished with his placement
     * @param integer $matchID
     * @param integer $userID
     * @return array
     */
    public function checkIfOpponentIsFinishedWithPlacement($matchID, $userID)
    {
        $sql = new Sql($this->dbAdapter);
        
        //Check if Opponent has inserted Ships into the Table
        $where = new \Zend\Db\Sql\Where();
        $where
            ->nest()
            ->notEqualTo('tblshipposition.spUserID', $userID)
            ->and
            ->equalTo('tblshipposition.spMatchID', $matchID)
            ->unnest(); 
        $select = $sql->select('tblshipposition')
                      ->where($where);        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();  
        
        //If I got affected Rows he has inserted so the Match can start
        if ($result->getAffectedRows() > 0)
        {
            return array('OpponentReady' => true,
                         'OpponentWon' => false);
        }
        //Else you should wait
        return array('OpponentReady' => false,
                     'OpponentWon' => false);
    }
    /**
     * Check if Opponent has Finished his MatchStep(s)
     * @param type $matchID
     * @param type $userID
     * @return type
     */
    public function checkIfOpponentIsFinishedWithMatchStep($matchID, $userID)
    {
        $lastMSID = $this->getLastMatchStepID($userID, $matchID);
        
        $sql = new Sql($this->dbAdapter);
        
        //Check if Opponent has inserted a MatchStep that is finished
        $where = new \Zend\Db\Sql\Where();
        $where
            ->nest()
            ->notEqualTo('tblmatchsteps.mUserID', $userID)
            ->and->equalTo('tblmatchsteps.mMatchID', $matchID)
            ->and->greaterThan('tblmatchsteps.msID', $lastMSID)
            ->and->equalTo('tblmatchsteps.mRoundFinished', true)
            ->unnest(); 
        $select = $sql->select('tblmatchsteps')
                      ->where($where);        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();  
        
        //If I got affected Rows he has inserted so the Match can start
        if ($result->getAffectedRows() > 0)
        {
            $opponent = $result->current();
            $opponentID = $opponent['mUserID'];
            if ($this->checkForWin($matchID, $opponentID) == true)
            {
                $hits = $this->getAllHitShips($matchID, $opponentID, $lastMSID);
                
                $this->setMatchWinner($opponentID, $matchID);
                
                return array('OpponentReady' => true,
                             'OpponentWon' => true,
                             'Hits' => $hits);
            }
            
            $hits = $this->getAllHitShips($matchID, $opponentID, $lastMSID);
            return array('OpponentReady' => true,
                         'OpponentWon' => false,
                         'Hits' => $hits);
        }
        $hits = $this->getAllHitShips($matchID, $opponentID, $lastMSID);
        $miss = $this->getLastMiss($matchID, $opponentID, $lastMSID);
        
        //Else you should wait
        return array('OpponentReady' => false,
                     'OpponentWon' => false,
                     'Hits' => $hits,
                     'Miss' => $miss);
    }  
    /**
     * Gets the last MatchStep and returns it as an array
     * @param type $matchID
     * @param type $opponentID
     * @param type $lastMSID
     * @return array
     */
    protected function getLastMiss($matchID, $opponentID, $lastMSID)
    {
        $sql = new Sql($this->dbAdapter);
        $where = new \Zend\Db\Sql\Where();
        $where->nest()->equalTo('tblmatchsteps.mUserID', $opponentID)
              ->and->equalTo('tblmatchsteps.mMatchID', $matchID)
              ->and->equalTo('tblmatchsteps.mState', false)
              ->and->greaterThan('tblmatchsteps.msID', $lastMSID)->unnest();
        $select = $sql->select('tblmatchsteps')->where($where);
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        $miss = array('x' => $result->current()['mRow'],
                      'y' => $result->current()['mColumn']);
        
        return $miss;
    }
    
    /**
     * Checks if any Ship got Hit in this Round
     * @param type $userID
     * @param type $matchID
     * @param type $x
     * @param type $y
     */
    protected function checkIfShipIsHit($userID, $matchID, $x, $y)
    {
        $sql = new Sql($this->dbAdapter);
        $where = new \Zend\Db\Sql\Where();
        $where->nest()
              ->notEqualTo('tblshipposition.spUserID', $userID)
              ->and->equalTo('tblshipposition.spMatchID', $matchID)
              ->and->nest()->equalTo('tblshipposition.spX', $x)
                    ->or->equalTo('tblshipposition.spY', $y)
              ->unnest()->unnest();
        
        $select = $sql->select('tblshipposition')->where($where);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute(); 
        
        $ship = new Ship();
        $ship->exchangeArray($result->current());
        
        if ($this->shipService->checkIfShipGotHit($ship, $x, $y) == false)
        {
            for ($count = $result->count() - 1; $count > 0; $count--)
            {
                $nextResult = $result->next();
                $ship = new Ship();
                $ship->exchangeArray($result->current());
                
                if($this->shipService->checkIfShipGotHit($ship, $x, $y) == true)
                {
                    return true;
                }
            }
            return false;
        }
        return true;
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
        $stmt->execute();
        //return updated Match
        return $this->getMatch($match->getID());
    }
    
    /**
     * Inserts new Match into tblMatch
     * @param User $user
     * @return Match
     */
    protected function createNewMatch(User $user)
    {
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('tblmatch');
        $insert->values(array('User1' => $user->getID(),
                                'User1ELO' => $user->getELO(),
                                'Date' => new \Zend\Db\Sql\Expression("NOW()")));
        
		
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $newMatch = $stmt->execute();

        return $this->getMatch($newMatch->getGeneratedValue());
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
        $user->exchangeArray($result->current());
        return $user;
    }
    
    /**
     * Gets Match by ID
     * @param Integer $id
     * @return Match match
     */
    protected function getMatch($id)
    {
        $sql = new Sql($this->dbAdapter);
        
        $select = $sql->select('tblmatch');
        $select->where(array('matchID = ?'=> $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        $match = new Match();
        $match->exchangeArray($result->current());
        return $match;
    }
    /**
     * Gets Last MatchStepID of current Match and User
     * @param type $userID
     * @param type $matchID
     * @return type
     */
    protected function getLastMatchStepID($userID, $matchID)
    {
        $sql = new Sql($this->dbAdapter);
        
        $where = new \Zend\Db\Sql\Where();
        $where->nest()
              ->equalTo('tblmatchsteps.mUserID', $userID)
              ->and->equalTo('tblmatchsteps.mMatchID', $matchID)
              ->unnest();
        $select = $sql->select('tblmatchsteps')
                ->columns(array('maxMSID' => new Expression('MAX(msID)')))
                      ->where($where);  

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        

        //If I dont have a MatchStepID return -1
        if ($result->current()["maxMSID"] == null)
        {  
            return -1;
        }
        
        return $result->current();
    }
    /**
     * Checks if $userID has won the Match
     * @param type $matchID
     * @param type $userID
     * @return boolean
     */
    protected function checkForWin($matchID, $userID)
    {
        $sql = new Sql($this-dbAdapter);
        
        $where = new \Zend\Db\Sql\Where();
        $where->nest()
              ->equalTo('tblmatchsteps.mUserID', $userID)
              ->and->equalTo('tblmatchsteps.mMatchID', $matchID)
              ->and->equalTo('tblmatchsteps.mState', true)
              ->unnest();
        $select = $sql->select()->columns(array('COUNT(tblmatchsteps.mState)'))
                      ->where($where);
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        //If he hit 20 times
        if ($result->current == 20)
        {
            return true;
        }
        
        return false;
        
    }
    /**
     * Get all Coordinates of the ships that got hit
     * @param type $matchID
     * @param type $opponentID
     * @param type $lastMSID
     * @return array
     */
    protected function getAllHitShips($matchID, $opponentID, $lastMSID)
    {
        $sql = new Sql($this->dbAdapter);
        $where = new \Zend\Db\Sql\Where();
        $where->nest()->equalTo('tblmatchsteps.mUserID', $opponentID)
              ->and->equalTo('tblmatchsteps.mMatchID', $matchID)
              ->and->equalTo('tblmatchsteps.mState', true)
              ->and->greaterThan('tblmatchsteps.msID', $lastMSID)->unnest();
        $select = $sql->select('tblmatchsteps')->where($where);
        
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        $hits = array();
        $newHit = new Hit();
        $currentResult = $result->current();
        
        if ($currentResult['mRow'] == null || $currentResult['mColumn'] == null)
        {
            return array();
        }
        
        $newHit->setX($currentResult['mRow']);
        $newHit->setY($currentResult['mColumn']);
        
        array_push($hits, $newHit);
        
        for ($count = $result->count() - 1; $count > 0; $count--)
        {
            $nextResult = $result->next();
            $nextHit = new Hit();
            
            $nextHit->setX($nextResult['mRow']);
            $nextHit->setY($nextResult['mColumn']);
            
            array_push($hits, $nextHit);
        }
        
        return $hits;
    }
    /**
     * Set Winner Column to $userID
     * @param type $userID
     * @param type $matchID
     */
    protected function setMatchWinner($userID, $matchID)
    {
        $sql = new Sql($this-dbAdapter);
        $where = new \Zend\Db\Sql\Where();
        
        $where->nest()
              ->equalTo('tblmatch.matchID', $matchID)
              -unnest();
        
        $update = $sql->update('tblmatch')->where($where);
        $update->set(array('Winner' => $userID));    
        
        $stmt = $sql->prepareStatementForSqlObject($update);
        $stmt->execute();        
    }
    
    /*

        TEST FUNCTIONS
        
    */
    
    public function createTestMatch()
    {
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('tblmatch');
        $insert->values(array('User1' => 91,
                                'User1ELO' => 1000,
                                'Date' => new \Zend\Db\Sql\Expression("NOW()")));
        
		
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $newMatch = $stmt->execute();
        
        if ($newMatch->getAffectedRows() > 0)
        {
            return array('success' => true);
        }
        
        return array('success' => false);       
    }
}
