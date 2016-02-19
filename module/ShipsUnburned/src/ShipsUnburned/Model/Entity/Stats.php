<?php

namespace ShipsUnburned\Model\Entity;


/**
 * Entity for an object of the table tblUser
 */
class Stats implements StatsInterface
{
    /**
     * Properties for the entities
     *
     * @var string 
     */
    public $id;
    public $totalMatches;
    public $wl;
    public $elo;
    
    /**
     * Function to fill the object with data from an array.
     * Property will be set to NULL if key is not available in the array.
     * 
     * @param array $array
     */
    public function exchangeArray($array)
    {
        $this->id               = (!empty($array['id'])) ? $array['id'] : null;
        $this->totalMatches     = (!empty($array['totalMatches'])) ? $array['totalMatches'] : null;
        $this->wl               = (!empty($array['wl'])) ? $array['wl'] : null;
        $this->elo              = (!empty($array['ELO'])) ? $array['ELO'] : null;
    }
    
    // Get and Set functions for the Properties
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getTotalMatches()
    {
        return $this->totalMatches;
    }    
    
    public function getWL()
    {
        return $this->wl;
    }

    public function getElo()
    {
        return $this->elo;
    }
    
    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setTotalMatches($totalMatches)
    {
        $this->totalMatches = $totalMatches;
    }    
    
    public function setWL($wl)
    {
        $this->wl = $wl;
    }

    public function setElo($elo)
    {
        $this->elo = $elo;
    }
}
