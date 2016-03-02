<?php

namespace ShipsUnburned\Model\Entity;


class Game implements GameInterface
{
    public $gamefield;
    
    public function getGameField()
    {
        return $this->gamefield;
    }
    
    public function setGameField(Array $gamefield)
    {
        $this->gamefield = $gamefield;
    }
}
