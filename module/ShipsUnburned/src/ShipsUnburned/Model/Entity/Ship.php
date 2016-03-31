<?php

namespace Shipsunburned\Model\Entity;

class Ships implements ShipInterface
{
    protected $x;
    protected $y;
    protected $length;
    protected $direction;
    protected $coordinatesX = array();
    protected $coordinatesY = array();    
    
    const RIGHT = 0;
    const DOWN = 1;
    
    public function __construct($x, $y, $length, $direction)
    {
        $this->x      = $x;
        $this->y      = $y;
        $this->length = $length;
        
        if($direction == 0)
        {
            $this->direction = $this->RIGHT;
        }
        else
        {
            $this->direction = $this->DOWN;
        }
    }
    
    /**
     * generates X and Y Coordinates of the whole ship
     */
    public function generateCoordinates()
    {
        //For direction Right
        if($this->direction == 0)
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