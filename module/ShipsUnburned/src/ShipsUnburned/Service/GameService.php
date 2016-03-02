<?php


namespace ShipsUnburned\Service;

use ShipsUnburned\Model\Table\GameTable;

class GameService
{
    protected $gameTable;
    
    public function __construct(GameTable $gameTable)
    {
        $this->gameTable = $gameTable;
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
    
    public function endRound($array)
    {
        return array();
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
