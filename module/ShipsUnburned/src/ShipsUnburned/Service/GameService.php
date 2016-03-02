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
    
    public function checkMatch($id)
    {
        return $this->gameTable->checkMatch($id);
    }
    
    public function cancelMatch($id)
    {
        return $this->gameTable->cancelMatch($id);
    }
}
