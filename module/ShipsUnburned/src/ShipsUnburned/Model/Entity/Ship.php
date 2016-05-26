<?php

namespace ShipsUnburned\Model\Entity;

class Ship implements ShipInterface
{
    public $x;
    public $y;
    public $length;
    public $direction;
    public $coordinatesX = array();
    public $coordinatesY = array();    
    
    const RIGHT = 1;
    const DOWN = 0;
    
    public function __construct($x, $y, $length, $direction)
    {
        $this->x      = $x;
        $this->y      = $y;
        $this->length = $length;
        
        if($direction == 0)
        {
            $this->direction = self::DOWN;
        }
        else
        {
            $this->direction = self::RIGHT;
        }
    }
    
    public function exchangeArray($array)
    {
        $this->x                    = (!empty($array['spX'])) ? $array['spX'] : null;
        $this->y                    = (!empty($array['spY'])) ? $array['spY'] : null;
        $this->length               = (!empty($array['spLength'])) ? $array['spLength'] : null;
        $this->direction            = (!empty($array['spDirection'])) ? $array['spDirection'] : null;
    }    
    
    /**
     * generates X and Y Coordinates of the whole ship
     */
    public function generateCoordinates()
    {
        //For direction Right
        if($this->direction == self::RIGHT)
        {
            for ($i = 0; $i < $this->length; $i++)
            {
                $this->coordinatesX[$i] = $this->x + $i;
                $this->coordinatesY[$i] = $this->y;
            }            
        }
        //For direction Down
        else
        {    
            for ($i = 0; $i < $this->length; $i++)
            {
                $this->coordinatesX[$i] = $this->x;
                $this->coordinatesY[$i] = $this->y + $i;
            }
        }    
    }
    // Get and Set functions for the Properties
    
    public function getX()
    {
        return $this->x;
    }
    
    public function getY()
    {
        return $this->y;
    }    
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function getDirection()
    {
        return $this->direction;
    }    
    
    public function setX($x)
    {
        $this->x = $x;
    }
    
    public function setY($y)
    {
        $this->y = $y;
    }    
    
    public function setLength($length)
    {
        $this->length = $length;
    }
    
    public function setLoses($direction)
    {
        $this->direction = $direction;
    }   
}