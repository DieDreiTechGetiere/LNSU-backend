<?php

namespace ShipsUnburned\Model\Entity;


/**
 * Entity for an object of the view view_highscore
 */
class Highscore implements HighscoreInterface
{
    /**
     * Properties for the entities
     *
     * @var string 
     */
    public $id;
    public $ingameName;
    public $elo;
    
    /**
     * Function to fill the object with data from an array.
     * Property will be set to NULL if key is not available in the array.
     * 
     * @param array $array
     */
    public function exchangeArray($array)
    {
        $this->id             = (!empty($array['id'])) ? $array['id'] : null;
        $this->ingameName     = (!empty($array['ingameName'])) ? $array['ingameName'] : null;
        $this->elo            = (!empty($array['elo'])) ? $array['elo'] : null;
    }
    
    // Get and Set functions for the Properties
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getIngameName()
    {
        return $this->ingameName;
    }    
    
    public function getELO()
    {
        return $this->elo;
    }
    
    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setIngameName($ingameName)
    {
        $this->ingameName = $ingameName;
    }    
    
    public function setELO($elo)
    {
        $this->elo = $elo;
    }
}
