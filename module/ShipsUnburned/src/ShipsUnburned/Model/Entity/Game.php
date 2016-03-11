<?php

namespace ShipsUnburned\Model\Entity;


class Game implements GameInterface
{
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
        $gamefield = $this->gamefield;
        
        //Go through the gamefield
        for ($i = 0; $i < count($gamefield); $i++)
        {
            //When array[$i] has values go into next for loop
            if ($array[$i] != null)
            {
                //Go through the value/s
                for ($j = 0; $k < count($array[$i]); $j++)
                {
                    //Set Gamefield = 1 where gamefield[$i] and the value of $array[$i][$j]
                    $gamefield[$i][$array[$i][$j]] = 1;
                }
            }
        }
    }
}
