<?php

namespace ShipsUnburned\Model\Entity;

/**
 * Description of Hit
 *
 * @author jakob
 */
class Hit implements HitInterface
{
    public $x;
    public $y;
    
    public function getX() 
    {
        return $this->x;
    }
    
    public function getY() 
    {
        return $this->y;
    }
    
    public function setX($x)
    {
        $this->x = $x;
    }

        public function setY($y)
    {
        $this->y = $y;
    }
}
