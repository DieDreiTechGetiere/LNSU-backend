<?php

namespace ShipsUnburned\Service;


class ELOCalculatorService
{
    public function calculateNewELO($totalOppELO, $wins, $loses)
    {
        $totalMatches = $wins + $loses;
        $newELO = ($totalOppELO + 400 * ($wins - $loses)) / $totalMatches;
        return $newELO;        
    }
}
