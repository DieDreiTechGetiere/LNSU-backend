<?php

namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Entity\Game;
use ShipsUnburned\Model\Entity\MatchStep;

class GameValidationService
{
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
            
            $this->shipsNotOverlapping();
            $this->spaceBetweenShipsIsValid();
            $this->numberOfShipsAreValid();
	}	
	//General validation
	protected function coordinatesInField(array $array)
	{
		//TODO: X and Y < 12!!!
	}
	
	//Placement-Round validations
	protected function shipsNotOverlapping()
	{
		//TODO: Ships are not allowed to overlap!!!
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
