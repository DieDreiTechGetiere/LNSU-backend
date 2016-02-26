<?php


namespace ShipsUnburned\Model\Entity;


class MatchList
{
    public $Match0;
    public $Match1;
    public $Match2;
    public $Match3;
    public $Match4;
    
    //Matches need to be ordered by Date from the Table
    public function addMatchesFromTable($array)
    {
        if ($array != null)
        {    
            for($i = 0; $i < count($array); $i++)
            {
                //Dynamically push array results into Properties!
                $this->{'Match' . $i} = $array[$i];
            }
        }
    }
}
