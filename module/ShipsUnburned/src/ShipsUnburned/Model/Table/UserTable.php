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
                    
                    return array('user' => json_encode($user),
                                 'loginSuccess' => true,
                                 'errors' => array());
                }
                else
                {
                    return array('loginSuccess' => false,
                                 'errors' => array(
                                    'errorMessage' => 'User nicht aktiv'
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
}
