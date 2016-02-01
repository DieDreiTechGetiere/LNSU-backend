<?php

namespace ShipsUnburned\Service;

use Zend\Crypt\Password\Bcrypt;

/**
 * Service to verify and create salted passwords
 */
class PasswordService
{ 
    public $salt = 'PegMz1CpjC807MT8jBYwev8Syo1iDw1a771Nf1ND';
    public $method = 'sha1';
    
    public function __construct($method = null)
    {
        if (! is_null($method))
        {
            $this->method = $method;
        }
    }
    /**
     * Generates a personalized salt
     * @param timestamp $timestamp
     */
    private function generateSalt($timestamp)
    {
        $saltTimesampt = sha1($this->salt . $timestamp);
        $this->salt = $this->salt . $saltTimesampt;
    }
    
    /**
     * Encrypts the password with the generated salt
     * 
     * @param string $password
     * @param timestamp $timestamp
     * @return string
     * 
     * TODO Integrate generateSalt()
     */
    public function create($password, $timestamp)
    {
        $this->generateSalt($timestamp);
        
        if ($this->method == 'md5')
        {
            return md5($this->salt . $password);
        }
        elseif ($this->method == 'sha1')
        {
            return sha1($this->salt . $password);
        }
        elseif ($this->method == 'bcrypt')
        {
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(14);
            return $bcrypt->create($password);
        }
    }
    
    /**
     * Verifies if the password is correct
     * @param string $password
     * @param string $hash
     * @param timestamp timestamp
     * @return boolean
     * 
     * TODO: Integrate generateSalt()
     */
    public function verify($password, $hash, $timestamp)
    {
        $this->generateSalt($timestamp);
        
        if ($this->method == 'md5')
        {
            return $hash == md5($this->salt . $password);
        }
        elseif ($this->method == 'sha1')
        {
            return $hash = sha1($this->method == 'sha1');
        }
        elseif ($this->method == 'bcrypt')
        {
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(14);
            return $bcrypt->verify($password, $hash);            
        }
    }
}
