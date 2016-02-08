<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Di\ServiceLocator;
/**
 * Controller for all actions regarding the userhandling
 */
class LoginController extends AbstractRestfulController 
{
    protected $userTable;
    //TODO add UserForm as Property and to the Factory. Construct UserFilter too

    public function __construct()
    {
        $realServiceLocator = new ServiceLocator();
        $this->userTable    = $realServiceLocator->get('ShipsUnburned\Model\UserTable');  
    } 

    /**
     * create function for user who try to login
     * @return JsonModel
     */
    public function create()
    {
        //for testing purpose only:
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $data = Zend_Json::decode($request->getPost());
            
            if ($data != null)
            {
                $result = $this->userTable->verifyLoginByLoginNameAndPassword($data["loginName"], $data["password"]);
            }
        }
        return new JsonModel($result);
    }      
}