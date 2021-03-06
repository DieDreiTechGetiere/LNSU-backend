<?php


namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Table\GameTable;
use ShipsUnburned\Model\Table\ELOTable;
use ShipsUnburned\Service\GameValidationService;
use ShipsUnburned\Model\Entity\Game;

class GameService
{
    protected $gameTable;
    protected $eloTable;
    protected $gameValidationService;
    protected $ships;
    
    public function __construct(GameTable $gameTable,
                                GameValidationService $gameValidationService,
                                ELOTable $eloTable)
    {
        $this->gameTable = $gameTable;
        $this->eloTable = $eloTable;
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
        if ($array["placementphase"] == true)
        {
            //Initialize Game and set ships on the gamefield
            $game = new Game();
            $game->setGameField();
            
            //Validate the input given by the frontend
            $this->ships = $this->gameValidationService->validatePlacementRound($game, $array["ships"]);
            
            //If it returns an array of ships then insert the data into the db via the gametable
            if(!$this->ships == false)
            {
                return $this->gameTable->insertPlacementPhase($array["userID"], $array["matchID"], $this->ships);
            }
            //Else return errorobject
            return array('error' => 'Shipplacement is not valid');
        }
        else
        {
            //If Validation is true then insert an give back repsone
            if($this->gameValidationService->validateMatchStep($array["x"], $array["y"]))
            {
                $result = $this->gameTable->insertMatchStep($array["userID"], $array["matchID"], $array["x"], $array["y"]);
                
                if ($result['YouWon'] == false)
                {
                    return $result;
                }
                //ELO Berechnung und Gewinner setzen
                else
                {
                    $newELO = $this->eloTable->calculateNewELO($array["matchID"], $array["userID"]);
                    return array('YouWon' => $result['YouWon'],
                                 'IsHit' => $result['IsHit'],
                                 'NewELO' => $newELO);
                }
            }
            //Else return errorobject
            return array('error' => 'Matchstep is not valid');
        }
    }
    
    public function checkRound($matchID, $userID, $round)
    {
        //Round 1 means Placementphase
        if ($round == 1)
        {
            return $this->gameTable->checkIfOpponentIsFinishedWithPlacement($matchID, $userID);
        }
        //Else MatchStep
        else
        {
            $result = $this->gameTable->checkIfOpponentIsFinishedWithMatchStep($matchID, $userID);
            
            if ($result['OpponentWon'] == false)
            {
                return $result;
            }
            //ELO Berechnung und Gewinner setzen
            else
            {
                $newELO = $this->eloTable->calculateNewELO($matchID, $userID);
                
                return array('OpponentReady' => $result['OpponentReady'],
                             'OpponentWon' => $result['OpponentWon'],
                             'Hits' => $result['Hits'],
                             'NewELO' => $newELO);
            }
        }
    }
    
    public function forfeitGame($matchID)
    {
        return array();
    }
}
