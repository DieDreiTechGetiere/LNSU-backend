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
        $ship->generateCoordinates();
        
        //X or Y is being Hit now determine if the other coordinate is Hit
        if ($x == $ship->getX())
        {
            for($i = 0; $i < $ship->length; $i++)
            {
                if($ship->coordinatesY[$i] == $y)
                {
                    return true;
                }
            }
        }
        else
        {
            for($i = 0; $i < $ship->length; $i++)
            {
                if($ship->coordinatesX[$i] == $y)
                {
                    return true;
                }
            }
        }
        return false;
    }
}
