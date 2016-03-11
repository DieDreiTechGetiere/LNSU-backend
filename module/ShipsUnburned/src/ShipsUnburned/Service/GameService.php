<?php


namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Table\GameTable;
use ShipsUnburned\Service\GameValidationService;
use ShipsUnburned\Model\Entity\Game;

class GameService
{
    protected $gameTable;
    protected $gameValidationService;
    
    public function __construct(GameTable $gameTable,
                                GameValidationService $gameValidationService)
    {
        $this->gameTable = $gameTable;
        $this->gameValidationService = $gameValidationService;
    }
    
    public function searchGame($id)
    {
        return $this->gameTable->searchGame($id);
    }
    
    public function checkMatch($matchID)
    {
        return $this->gameTable->checkMatch($matchID);
    }
    
    public function cancelMatch($matchID)
    {
        return $this->gameTable->cancelMatch($matchID);
    }
    
    /**
     * Checks for placementPhase and decides which steps to take next
     * @param array $array
     * @return array
     */
    public function endRound($array)
    {
        if ($array["placementPhase"] == true)
        {
            //Initialize Game and set ships on the gamefield
            $game = new Game();
            $game->setGameField()
                 ->insertShipsIntoGameField($array["ships"]);
            
            //If Validation is true then insert an give back repsone
            if($this->gameValidationService->validatePlacementRound($game))
            {
                return $this->gameTable->insertPlacementRound($game, $array["userId"], $array["matchId"]);
            }
            //Else return errorobject
            return array('error' => 'Shipplacement is not valid');
        }
        else
        {
            //If Validation is true then insert an give back repsone
            if($this->gameValidationService->validateMatchStep())
            {
                return $this->gameTable->insertMatchStep($array["userId"], $array["matchId"]);
            }
            //Else return errorobject
            return array('error' => 'Matchstep is not valid');
        }
    }
    
    public function checkRound($matchID)
    {
        return array();
    }
    
    public function forfeitGame($matchID)
    {
        return array();
    }
}
