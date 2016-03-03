<?php

namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Entity\Game;
use ShipsUnburned\Model\Entity\MatchStep;
use ShipsUnburned\Model\Entity\Placement;

class GameValidationService
{
	public function validateMatchStep(Game $game, MatchStep $matchStep)
	{
		return array();
	}
	
	public function validatePlacementRound(Game $game, Placement $placement)
	{
		return array();
	}	
	//General validation
	protected function coordinatesInField()
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
