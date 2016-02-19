<?php

namespace ShipsUnburned\Model\Entity;


/**
 * Entity for an object of the table tblUser
 */
class Match implements MatchInterface
{
    /**
     * Properties for the entities
     *
     * @var string 
     */
    public $id;
    public $user1;
    public $user2;
    public $date;
    public $winner;
    
    /**
     * Function to fill the object with data from an array.
     * Property will be set to NULL if key is not available in the array.
     * 
     * @param array $array
     */
    public function exchangeArray($array)
    {
        $this->id               = (!empty($array['matchID'])) ? $array['matchID'] : null;
        $this->user1            = (!empty($array['User1'])) ? $array['User1'] : null;
        $this->user2            = (!empty($array['User2'])) ? $array['User2'] : null;
        $this->date             = (!empty($array['Date'])) ? $array['Date'] : null;
        $this->winner           = (!empty($array['Winner'])) ? $array['Winner'] : null;
    }
    
    // Get and Set functions for the Properties
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getUser1()
    {
        return $this->user1;
    }    
    
    public function getUser2()
    {
        return $this->user2;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getWinner()
    {
        return $this->winner;
    }
    
    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setUser1($user1)
    {
        $this->user1 = $user1;
    }    
    
    public function setUser2($user2)
    {
        $this->user2 = $user2;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setWinner($winner)
    {
        $this->winner = $winner;
    } 
}
