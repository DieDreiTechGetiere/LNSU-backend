<?php

namespace ShipsUnburned\Service;


class ELOCalculatorService
{
    public function calculateNewELO($totalOppELO, $wins, $loses)
    {
        $totalMatches = (int)$wins + (int)$loses;
        $newELO = ((int)$totalOppELO + 400 * ((int)$wins - (int)$loses)) / $totalMatches;
        return $newELO;        
    }
}
