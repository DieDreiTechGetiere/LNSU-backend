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
    
    public function checkMatch($match)
    {
        return $this->gameTable->checkMatch($match);
    }
}
