<?php

namespace ShipsUnburned\Model\Entity;


class Game implements GameInterface
{
    const LENGTH = 12;
	
    public $gamefield;
    
    public function getGameField()
    {
        return $this->gamefield;
    }
    
    public function setGameField()
    {
        $a = array(); 
        $b = array(); 
        $b = array_pad($b,12,0); 
        $a = array_pad($a,12,$b); 
        
        $this->gamefield = $a;
    }
    /**
     * Insert Ships into the 2 dimensional array
     * @param array $array
     */
    public function insertShipsIntoGameField(array $array)
    {
        //Go through the gamefield X
        for ($i = 0; $i < $this->LENGTH; $i++)
        {
            //Go through the gamefield Y
            for ($j = 0; $j < $this->LENGTH; $j++)
            {
                //Check if Ship is in that position
                if($array[$i][$j] == 1)
                {
                    //Set gamefield to 1 if Ship exists
                    $this->gamefield[$i][$j] = 1;
                }
            }
        }
    }
}
