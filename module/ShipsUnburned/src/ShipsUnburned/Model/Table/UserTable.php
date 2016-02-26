<?php

namespace ShipsUnburned\Model\Table;

use ShipsUnburned\Service\PasswordService;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use ShipsUnburned\Model\Entity\User;

/**
 * Class that opens DB-Connections and gets responses from it
 */
class UserTable
{
    protected $dbAdapter;
    protected $passwordService;
    
    public function __construct(AdapterInterface $dbAdapter,
                                PasswordService $passwordService)
    {
        $this->dbAdapter = $dbAdapter;
        $this->passwordService = $passwordService;
    }
    
    /**
     * Verifies the Login of a User by checking it against the Database
     * 
     * @param string $loginName
     * @param string $password
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function verifyLoginByLoginNameAndPassword($loginName, $password)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbluser');
        $select->where(array('loginName = ?'=> $loginName));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())
        {
            $user = new User();
            $user->exchangeArray($result->current());
            
            //\Zend\Debug\Debug::dump($password, $label = null, $echo = true);
            if ($this->passwordService->verify($password, $user->getHashedPassword(), $user->getTimestamp()))
            {
                if( $user->getAktiv() == 1 )
                {   
                    return array('user' => $user,
                                 'loginSuccess' => true,
                                 'errors' => array());
                }
                else
                {
                    return array('loginSuccess' => false,
                                 'errors' => array(
                                    'errorMessage' => 'user not active'
                                ));
                }
            }
            else
            {
                return array('loginSuccess' => false,
                             'errors' => array(
                                 'errorMessage' => 'wrong username or password'
                             ));
            }
        }
        return array('loginSuccess' => false,
                     'errors' => array(
                        'errorMessage' => 'wrong username or password'
                    ));         
    }
    /**
     * Method to Insert a new User into the Database
     * 
     * @param array $array
     * @return array
     */
    public function registerUserByLoginName($array)
    {
        $array["password"] = $this->passwordService->create($array["password"], $array["timestamp"]);
        $values["password"] = $array["password"];
        $values["loginName"] = $array["loginName"];
        $values["ingameName"] = $array["ingameName"];
        $values["timestamp"] = $array["timestamp"];
        
        $action = new Insert('tbluser');
        $action->values($values);
        
        $sql = new Sql($this->dbAdapter);
        $stmt= $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface)
        {
            if($newID = $result->getGeneratedValue())
            {
                return array('registerSuccess' => true
                            );
            }
        }
        return array('registerSuccess' => false,
                     'errors' => array(
                         'errorMessage' => 'Database error'
                    ));
    }
    
    /**
     * Gets all inactive Users and returns an array of Userobjects
     * @return array
     */
    public function getAllInactiveUsers()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tbluser');
        $select->where('freigeschaltet = 1')
               ->order('Date ASC');        
        
        $stmt= $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())
        {
            $array = array();
            $user = new User();
            
            $user->exchangeArray($result->current());
            array_push($array, $user);
            
            // Minus 1 Because we already pushed 1 UserObject into the Array
            for($count = $result->count() - 1; $count > 0; $count--)
            {
                $user = new User();
                $user->exchangeArray($result->next());
                array_push($array, $user);
            }

            return $array;
        }
    }
    
    /**
     * Sets all Users with ID's in array to active and returns all inactive users
     * @param array $array
     * @return array
     */
    public function setUsersActive($array)
    {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('tbluser');
        
        //Set active to 1 where id IN(array)
        $update->set(array('freigeschaltet = ?' => 1))
                ->where->in('id', $array);
        
        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())
        {
            //Return all inactive Users after update
            return $this->getAllInactiveUsers();
        }

    }
}
