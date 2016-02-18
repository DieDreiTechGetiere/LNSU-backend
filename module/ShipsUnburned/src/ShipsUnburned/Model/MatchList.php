<?php


namespace ShipsUnburned\Model;



class MatchList
{
    protected $Match1;
    protected $Match2;
    protected $Match3;
    protected $Match4;
    protected $Match5;
    
    //Matches need to be ordered by Date from the Table
    //TODO Test if this Works!!!!
    public function addMatchesFromTable($array)
    {
        for($i = 0; $i < $array.length(); $i++)
        {
            ${'this->Match' . $i} = $array[$i];
        }
    }
}
