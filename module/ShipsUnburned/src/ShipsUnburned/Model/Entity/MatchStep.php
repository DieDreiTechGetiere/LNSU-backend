<?php

namespace ShipsUnburned\Model\Entity;


/**
 * Entity for an object of the table tblMatchStep
 */
class MatchStep implements MatchStepInterface
{
    /**
     * Properties for the entities
     *
     * @var string 
     */
    public $id;
    public $matchID;
    public $userID;
    public $X;
    public $Y;
    public $state;
    protected $roundNumber;
    protected $roundFinished;
    
    /**
     * Function to fill the object with data from an array.
     * Property will be set to NULL if key is not available in the array.
     * 
     * @param array $array
     */
    public function exchangeArray($array)
    {
        $this->id                  = (!empty($array['msID'])) ? $array['msID'] : null;
        $this->matchID             = (!empty($array['mMatchID'])) ? $array['mMatchID'] : null;
        $this->userID              = (!empty($array['mUserID'])) ? $array['mUserID'] : null;
        $this->X                   = (!empty($array['mRow'])) ? $array['mRow'] : null;
        $this->Y                   = (!empty($array['mColumn'])) ? $array['mColumn'] : null;
        $this->state               = (!empty($array['mState'])) ? $array['mState'] : null;
        $this->roundNumber         = (!empty($array['mRoundNumber'])) ? $array['mRoundNumber'] : null;
        $this->roundFinished       = (!empty($array['mRoundFinished'])) ? $array['mRoundFinished'] : null;
    }
    
    // Get and Set functions for the Properties
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getMatchID()
    {
        return $this->matchID;
    }    
    
    public function getUserID()
    {
        return $this->userID;
    }

    public function getX()
    {
        return $this->X;
    }

    public function getY()
    {
        return $this->Y;
    }
    
    public function getState()
    {
        return $this->state;
    }

    public function getRoundNumber()
    {
        return $this->roundNumber;
    }    
    
    public function getRoundFinished()
    {
        return $this->roundFinished;
    }
    
    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setMatchID($matchID)
    {
        $this->matchID = $matchID;
    }    
    
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    public function setX($x)
    {
        $this->X = $x;
    }

    public function setY($y)
    {
        $this->Y = $y;
    } 
    
    public function setState($state)
    {
        $this->state = $state;
    } 

    public function setRoundNumber($roundNumber)
    {
        $this->roundNumber = $roundNumber;
    }     
    
    public function setRoundFinished($roundFinished)
    {
        $this->roundFinished = $roundFinished;
    }  
}
