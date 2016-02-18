<?php


namespace ShipsUnburned\Model\Entity;



class MatchList
{
    protected $Match0;
    protected $Match1;
    protected $Match2;
    protected $Match3;
    protected $Match4;
    
    //Matches need to be ordered by Date from the Table
    public function addMatchesFromTable($array)
    {
        for($i = 0; $i < count($array); $i++)
        {
            //Dynamically push array results into Properties!
            $this->{'Match' . $i} = $array[$i];
        }
    }
}
