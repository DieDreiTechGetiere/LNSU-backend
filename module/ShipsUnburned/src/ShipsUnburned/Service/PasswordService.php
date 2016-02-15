<?php

namespace ShipsUnburned\Service;

use Zend\Crypt\Password\Bcrypt;

/**
 * Service to verify and create salted passwords
 */
class PasswordService
{ 
    public $salt = 'PegMz1CpjC807MT8jBYwev8Syo1iDw1a771Nf1ND';
    public $method = 'md5';
    
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
        $saltTimestamp = md5($this->salt . $timestamp);
        return $this->salt . $saltTimestamp;
    }
    
    /**
     * Encrypts the password with the generated salt
     * 
     * @param string $password
     * @param timestamp $timestamp
     * @return string
     */
    public function create($password, $timestamp)
    {
        $salt = $this->generateSalt($timestamp);
        
        if ($this->method == 'md5')
        {
            return md5($salt . $password);
        }
        elseif ($this->method == 'sha1')
        {
            return sha1($salt . $password);
        }
        elseif ($this->method == 'bcrypt')
        {
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(14);
            return $bcrypt->create($password, $timestamp);
        }
    }
    
    /**
     * Verifies if the password is correct
     * @param string $password
     * @param string $hash
     * @param timestamp timestamp
     * @return boolean
     */
    public function verify($password, $hash, $timestamp)
    {
        $salt = $this->generateSalt($timestamp);
        //\Zend\Debug\Debug::dump(md5($salt . $password), $label = null, $echo = true);
        //\Zend\Debug\Debug::dump($this->salt, $label = null, $echo = true);
        if ($this->method == 'md5')
        {
            return $hash == md5($salt . $password);
        }
        elseif ($this->method == 'sha1')
        {
            return $hash == sha1($salt == 'sha1');
        }
        elseif ($this->method == 'bcrypt')
        {
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(14);
            return $bcrypt->verify($password, $hash, $timestamp);            
        }
    }
}
