<?php

namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Entity\Game;
use ShipsUnburned\Model\Entity\Ship;
use ShipsUnburned\Model\Entity\MatchStep;

class GameValidationService
{
    //Constants for Ships
    const SHIP_COUNT = 10;
    
    const SHIP1_4TIMES = 4;
    const SHIP2_3TIMES = 3;
    const SHIP3_2TIMES = 2;
    const SHIP4_1TIMES = 1;
    
    const SHIP_SIZE_1 = 1;
    const SHIP_SIZE_2 = 2;
    const SHIP_SIZE_3 = 3;
    const SHIP_SIZE_4 = 4;
    
    const SHIP_ERROR_1 = 'number of ships is not correct';

    protected $shipArray = array();
    protected $game;

    /*

        MAIN FUNCTIONS!

    */
    
    public function validateMatchStep(Game $game, MatchStep $matchStep)
    {
        return array();
    }

    /**
     * Main Function for the validation of the PlacementRound
     * @param Game $game
     * @param array $array
     * @return array
     */
    public function validatePlacementRound(Game $game, array $array)
    {
        $this->game = $game;

        //insert ships into game
        $this->game->insertShipsIntoGameField($array);

        //Find all Ships and fill shipArray with all the ones found
        $this->findShipsOnGamefield();
        
        //Check if the number of ships is correct
        if ($this->numberOfShipsAreValid() == true)
        {
            if($this->numberOfDifferentShipsIsValid() == true)
            {
                //TODO: Validate the positions of the ships
            }
            else
            {
                return array('error' => $this->SHIP_ERROR_1);
            }
        }
        else
        {
            return array('error' => $this->SHIP_ERROR_1);
        }
    }

    /*

        VALIDATION FUNCTIONS!

    */


    protected function spaceBetweenShipsIsValid()
    {
            //TODO: Ships need one empty space between one another!!!
    }

    protected function numberOfShipsAreValid()
    {
        if (count($this->shipArray) == $this->SHIP_COUNT)
        {
            return true;
        }
        return false;
    }
    
    protected function numberOfDifferentShipsIsValid()
    {
        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $count4 = 0;
        
        //TODO: 4x 1spaceShip, 3x 2spaceShip, 2x 3spaceShip, 1x 4spaceShip
        for ($i = 0; $i < $this->SHIP_COUNT; $i++)
        {
            //Check the length of each ship and add 1 to the correlating counter
            switch ($this->shipArray[$i]->getLength())
            {
                case 1:
                    $count1++;
                    break;
                case 2:
                    $count2++;
                    break;
                case 3:
                    $count3++;
                    break;
                case 4:
                    $count4++;
                    break;
            } 
        }
        
        //Check if the number of each different sized ship is correct
        if ($count1 == $this->SHIP1_4TIMES 
                && $count2 == $this->SHIP2_3TIMES 
                && $count3 == $this->SHIP3_2TIMES 
                && $count4 == $this->SHIP4_1TIMES)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*

        HELPER FUNCTIONS!

    */

    /**
     * find ships and add them to shipArray
     */
    protected function findShipsOnGamefield()
    {
        for ($i = 0; $i < $this->game->LENGTH; $i++)
        {
            for ($j = 0; $j < $this->game->LENGTH; $j++)
            {
                //Delete Ship if there is one
                if ($this->game->gamefield[$i][$j] == 1)
                {
                    //Add created Ships to array
                    array_push($this->shipArray, $this->createShip($i, $j));
                }
            }
        }
    }

    /**
     * Creates Ship Object with length, x, y and direction
     * @param int $x
     * @param int $y
     * @return Ship
     */
    protected function createShip(int $x, int $y)
    {
        $length = 1;

        //If direction is Right
        if ($this->checkForDirection($x, $y) == 1)
        {
            //First set direction to right
            $direction = 0;

            //Start the loop with a maximum of the ships length
            for ($i = 1; $i <= $this->SHIP_SIZE_4; $i++)
            {
               //Check for the length of the ship and add it to length
               if (($this->game->gamefield[$x + $i][$y] == 1) && ($x + $i < $this->game->LENGTH))
                {
                    $length++;
                } 
            }
            //Create Ship with all the known parameters
            return new Ship($x, $y, $length, $direction);
        }
        //If direction is Down
        else if ($this->checkForDirection($x, $y) == 2)
        {
            //First set direction to down
            $direction = 1;

            //Start the loop with a maximum of the ships length
            for ($i = 1; $i <= $this->SHIP_SIZE_4; $i++)    
            {
                //Check for the length of the ship and add it to length
                if (($this->game->gamefield[$x][$y + $i] == 1) && ($y + $i < $this->game->LENGTH))
                {
                    $length++;                        
                }
            }
            //Create Ship with all the known parameters
            return new Ship($x, $y, $length, $direction);
        }
        //If the Ship has the Length 1 just create the object
        else
        {
            //Create Ship with all the known parameters
            return new Ship($x, $y, $length, $direction);               
        }
    }

    /**
     * Check for the Direction of the current Ship
     * 0 = no Direction
     * 1 = right
     * 2 = down
     * @param int $x
     * @param int $y
     * @return int
     */
    protected function checkForDirection(int $x, int $y)
    {
        if ($this->game->gamefield[$x + 1][$y] == 1)
        {
            return 1;
        }
        else if ($this->game->gamefield[$x][$y + 1] == 1)
        {
            return 2;
        }
        return 0;
    }    
    /**
     * Sets blocked space around Ship to 0
     * @param int $x
     * @param int $y
     * @param int $length
     */
    protected function setUnavailableSpace(int $x, int $y, int $length, int $direction)
    {
        if ($length == 1)
        {
            $this->game->gamefield[$x - 1][$y]      = 0;
            $this->game->gamefield[$x + 1][$y]      = 0;
            $this->game->gamefield[$x - 1][$y - 1]  = 0;
            $this->game->gamefield[$x + 1][$y - 1]  = 0;
            $this->game->gamefield[$x - 1][$y + 1]  = 0;
            $this->game->gamefield[$x + 1][$y + 1]  = 0;
            $this->game->gamefield[$x][$y - 1]      = 0;
            $this->game->gamefield[$x][$y + 1]      = 0;
        }
        else
        {
            //Direction Right
            if($direction == 1)
            {
                switch ($length)
                {
                    case 2:
                        $this->game->gamefield[$x - 1][$y]      = 0;
                        $this->game->gamefield[$x + 2][$y]      = 0;
                        $this->game->gamefield[$x][$y - 1]      = 0;  
                        $this->game->gamefield[$x][$y + 1]      = 0;  
                        $this->game->gamefield[$x - 1][$y - 1]  = 0;
                        $this->game->gamefield[$x + 1][$y - 1]  = 0;
                        $this->game->gamefield[$x + 2][$y - 1]  = 0;
                        $this->game->gamefield[$x + 2][$y + 1]  = 0;                        
                        $this->game->gamefield[$x - 1][$y + 1]  = 0;
                        $this->game->gamefield[$x + 1][$y + 1]  = 0;
                      
                        break;
                    case 3:
                        break;
                    case 4:
                        break;
                } 
            }
            //Direction Down
            else
            {
                switch ($length)
                {
                    case 2:
                        $this->game->gamefield[$x - 1][$y]      = 0;
                        $this->game->gamefield[$x + 1][$y]      = 0;
                        $this->game->gamefield[$x][$y - 1]      = 0;  
                        $this->game->gamefield[$x][$y + 2]      = 0;                        
                        $this->game->gamefield[$x - 1][$y - 1]  = 0;
                        $this->game->gamefield[$x + 1][$y - 1]  = 0;
                        $this->game->gamefield[$x + 1][$y + 2]  = 0; 
                        $this->game->gamefield[$x - 1][$y + 2]  = 0;                        
                        $this->game->gamefield[$x - 1][$y + 1]  = 0;
                        $this->game->gamefield[$x + 1][$y + 1]  = 0;
                        break;
                    case 3:
                        break;
                    case 4:
                        break;
                }                
            }
        }
    }
}
