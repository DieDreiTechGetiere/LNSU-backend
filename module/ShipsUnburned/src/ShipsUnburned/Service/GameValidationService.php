<?php

namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Entity\Game;
use ShipsUnburned\Model\Entity\MatchStep;

class GameValidationService
{
        //Constants for Ships
        const SHIP_SIZE_1 = 1;
        const SHIP_SIZE_2 = 2;
        const SHIP_SIZE_3 = 3;
        const SHIP_SIZE_4 = 4;
    
        protected $game;
    
	public function validateMatchStep(Game $game, MatchStep $matchStep)
	{
		return array();
	}
	
	public function validatePlacementRound(Game $game, array $array)
	{
		$this->game = $game;
		//Check if coordinates are correct
		$this->coordinatesInField($array);
		//insert ships into game
		$this->game->insertShipsIntoGameField($array);
		
		$this->spaceBetweenShipsIsValid();
		$this->numberOfShipsAreValid();
	}	
	//General validation
	protected function coordinatesInField(array $array)
	{
		//TODO: X and Y < 12!!!
	}
	
	protected function findShipByLength()
	{
		//TODO: Find Ships and use findShipsAndDelete() to delete them
	}
	
	protected function findShipsAndDelete()
	{
		for ($i = 0; $i < $this->game::LENGTH; $i++)
		{
			for ($j = 0; $j < $this->game::LENGTH; $j++)
			{
				//Delete Ship if there is one
				if ($this->game->gamefield[$i][$j] == 1)
				{
					$this->game->deleteShipsFromGameField($i, $j, SHIP_SIZE_1, true);
				}
			}
		}
	}
	
	protected function spaceBetweenShipsIsValid()
	{
		//TODO: Ships need one empty space between one another!!!
	}
	
	protected function numberOfShipsAreValid()
	{
		//TODO: Validate that you can only set as many ships as are allowed!!!
	}
}
