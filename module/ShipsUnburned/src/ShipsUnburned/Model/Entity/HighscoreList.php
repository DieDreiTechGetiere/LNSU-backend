<?php


namespace ShipsUnburned\Model\Entity;


class HighscoreList
{
    public $Highscore0;
    public $Highscore1;
    public $Highscore2;
    public $Highscore3;
    public $Highscore4;
    public $Highscore5;
    public $Highscore6;
    public $Highscore7;
    public $Highscore8;
    public $Highscore9;    
    
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
