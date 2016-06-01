<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ShipsUnburned\Service;

/**
 * Description of ShipService
 *
 * @author Jakob
 */
class ShipService 
{
    public function checkIfShipGotHit($ship, $x, $y)
    {
        $newShip = NULL;
        $newShip = $ship;
        $newShip->generateCoordinates();
        
        //X or Y is being Hit now determine if the other coordinate is Hit
        if ($x == $newShip->getX())
        {
            for($i = 0; $i < $newShip->length; $i++)
            {
                if($newShip->coordinatesY[$i] == $y)
                {
                    return 1;
                }
            }
        }
        elseif ($y == $newShip->getY())
        {
            for($i = 0; $i < $newShip->length; $i++)
            {
                if($newShip->coordinatesX[$i] == $y)
                {
                    return 1;
                }
            }
        }
        return 0;
    }
}
