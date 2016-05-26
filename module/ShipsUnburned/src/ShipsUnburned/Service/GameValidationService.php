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

    const SHIP_SIZE_4 = 4;

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
        if($this->findShipsOnGamefield() == true)
        {
            //Check if the number of ships is correct
            if ($this->numberOfDifferentShipsIsValid() == true)
            {
                return $this->shipArray;
            }           
        }
        return false;
    }

    /*

        VALIDATION FUNCTIONS!

    */
    
    /**
     * Check if the number of ships per length are correct
     * @return boolean
     */
    protected function numberOfDifferentShipsIsValid()
    {
        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $count4 = 0;
        
        //Go through all ships
        for ($i = 0; $i < count($this->shipArray); $i++)
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
        if ($count1 == self::SHIP1_4TIMES 
                && $count2 == self::SHIP2_3TIMES 
                && $count3 == self::SHIP3_2TIMES 
                && $count4 == self::SHIP4_1TIMES)
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
     * @return boolean
     */
    protected function findShipsOnGamefield()
    {
        for ($i = 0; $i < 12; $i++)
        {
            for ($j = 0; $j < 12; $j++)
            {
                //Create Ship if there is one
                if ($this->game->gamefield[$i][$j] == 1)
                {
                    //Add created Ships to array
                    $ship = $this->createShip($j, $i);
                    
                    if(!$ship == false)
                    {
                        array_push($this->shipArray, $ship);
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Creates Ship Object with length, x, y and direction
     * @param int $x
     * @param int $y
     * @return Ship
     */
    protected function createShip($x, $y)
    {
        $length = 1;

        //If direction is RIGHT
        if ($this->checkForDirection($x, $y) == 1)
        {
            //First set direction to RIGHT
            $direction = 1;

            //Start the loop with a maximum of the ships length
            for ($i = 1; $i < self::SHIP_SIZE_4; $i++)
            {
               //Check for the length of the ship and add it to length
               if (($this->game->gamefield[$y][$x + $i] == 1) && ($x + $i < 12))
                {
                    $length++;
                }
                else
                {
                    break;
                }
            }
            //Create Ship with all the known parameters
            $ship = new Ship($x, $y, $length, $direction);

            //populate coordinatesX and coordinatesY
            $ship->generateCoordinates();
            
            //Delete Ship from gamefield
            $this->deleteShipFromGamefield($ship);
            
            if(!$this->checkForUnavailableSpace($ship) == false)
            {
                return $ship;
            }
        }
        //If direction is DOWN
        else if ($this->checkForDirection($x, $y) == 2)
        {
            //First set direction to DOWN
            $direction = 0;

            //Start the loop with a maximum of the ships length
            for ($i = 1; $i < self::SHIP_SIZE_4; $i++)    
            {
                //Check for the length of the ship and add it to length
                if (($this->game->gamefield[$y + $i][$x] == 1) && ($y + $i < 12))
                {
                    $length++;                        
                }
                else
                {
                    break;
                }
            }
            //Create Ship with all the known parameters
            $ship = new Ship($x, $y, $length, $direction);

            //populate coordinatesX and coordinatesY
            $ship->generateCoordinates();
            
            //Delete Ship from gamefield
            $this->deleteShipFromGamefield($ship);
            
            if(!$this->checkForUnavailableSpace($ship) == false)
            {
                return $ship;
            }   
        }
        //If the Ship has the Length 1 just create the object
        else
        {
            //Create Ship with all the known parameters
            $ship = new Ship($x, $y, $length, $direction);
            
            //populate coordinatesX and coordinatesY
            $ship->generateCoordinates();
            
            //Delete Ship from gamefield
            $this->deleteShipFromGamefield($ship);

            if(!$this->checkForUnavailableSpace($ship) == false)
            {
                return $ship;
            }              
        }
        return false;
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
    protected function checkForDirection($x, $y)
    {
        if ($this->game->gamefield[$y][$x + 1] == 1)
        {
            return 1;
        }
        else if ($this->game->gamefield[$y + 1][$x] == 1)
        {
            return 2;
        }
        return 0;
    }    

    /**
     * Checks for wrong ship placement
     * @param Ship $ship
     * @return boolean
     */
    protected function checkForUnavailableSpace(Ship $ship)
    {
        //Check surrounding of the Ship for other Ship placements
        for($i = 0; $i < $ship->length; $i++)
        {
            $x = $ship->coordinatesX[$i]; 
            $y = $ship->coordinatesY[$i];

            //Check surrounding of the current X and Y coordinate
            if ($this->game->gamefield[$y - 1][$x - 1] === 1 ||
                $this->game->gamefield[$y - 1][$x] === 1      ||
                $this->game->gamefield[$y - 1][$x + 1] === 1 ||
                $this->game->gamefield[$y][$x - 1] === 1     ||
                $this->game->gamefield[$y + 1][$x - 1] === 1 ||
                $this->game->gamefield[$y][$x + 1] === 1     ||
                $this->game->gamefield[$y + 1][$x + 1] === 1 ||
                $this->game->gamefield[$y][$x + 1] === 1)
            {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Deletes ship from gamefield
     * @param Ship $ship
     */
    protected function deleteShipFromGamefield(Ship $ship)
    {
        for($i = 0; $i < $ship->length; $i++)
        {
            
            // Need to turn x and y around because of the difference in the Ship class and the ValidationService
            $x = $ship->coordinatesX[$i]; 
            $y = $ship->coordinatesY[$i];

            $this->game->gamefield[$y][$x] = 0;
        }
    }
}
