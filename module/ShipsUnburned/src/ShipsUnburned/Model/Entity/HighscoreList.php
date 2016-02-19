<?php


namespace ShipsUnburned\Model\Entity;


class HighscoreList
{
    protected $Highscore0;
    protected $Highscore1;
    protected $Highscore2;
    protected $Highscore3;
    protected $Highscore4;
    protected $Highscore5;
    protected $Highscore6;
    protected $Highscore7;
    protected $Highscore8;
    protected $Highscore9;    
    
    //Matches need to be ordered by Date from the Table
    public function addMatchesFromTable($array)
    {
        for($i = 0; $i < count($array); $i++)
        {
            //Dynamically push array results into Properties!
            $this->{'Highscore' . $i} = $array[$i];
        }
    } 
}
