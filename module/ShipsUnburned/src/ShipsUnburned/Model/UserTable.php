<?php

namespace ShipsUnburned\Model;

use ShipsUnburned\Service\PasswordService;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class that opens DB-Connections and gets responses from it
 */
class UserTable
{
    protected $userPrototype;
    protected $dbAdapter;
    protected $passwordService;
    protected $hydrator;
    
    public function __construct(AdapterInterface $dbAdapter,
                                HydratorInterface $hydrator,
                                UserInterface $user,
                                PasswordService $passwordService)
    {
        $this->hydrator = $hydrator;
        $this->dbAdapter = $dbAdapter;
        $this->userPrototype = $user;
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
        $select->where(array('uLoginName = ?'=> $loginName));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows())
        {
            $result = $this->hydrator->hydrate($result->current(), $this->userPrototype);
            
            if ($this->passwordService->verify($password, $result->getHashedPassword(), $result->getTimestamp()))
            {
                if( $result->getAktiv() == 1 )
                {    
                    return array('login-success' => 1,
                                 'error-object' => array(
                                    'error-message' => 'no error'
                                    ));
                }
                else
                {
                    return array('login-success' => 0,
                                 'error-object' => array(
                                    'error-message' => 'User nicht aktiv'
                                ));
                }
            }
            else
            {
                return array('login-success' => 0,
                             'error-object' => array(
                                 'error-message' => 'Falsches Passwort'
                             ));
            }
        }
        return array('login-success' => 0,
                     'error-object' => array(
                        'error-message' => 'User nicht bekannt'
                    ));         
    }
    
    public function registerUserByLoginName($array)
    {
        $array["password"] = $this->passwordService->create($array["password"], $array["timestamp"]);
        
        $action = new Insert('tbluser');
        $action->values($array);
        
        $sql = new Sql($this->dbAdapter);
        $stmt= $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        
        if ($result instanceof ResultInterface)
        {
            
        }
    }
}
