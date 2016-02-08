<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
/**
 * Controller for all actions regarding the userhandling
 */
class LoginController extends AbstractRestfulController 
{
    protected $userTable;
    //TODO add UserForm as Property and to the Factory. Construct UserFilter too

    public function __construct()
    {
    } 

    /**
     * create function for user who try to login
     * @return JsonModel
     */
    public function create()
    {
        $sm = $this->getServiceLocator();
        $this->userTable = $sm->get('ShipsUnburned\Model\UserTable');        
        
        //for testing purpose only:
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $data = \Zend\Json\Json::decode($request->getContent());
            
            if ($data != null)
            {
                $result = $this->userTable->verifyLoginByLoginNameAndPassword($data["loginName"], $data["password"]);
            }
        }
        return new JsonModel($result);
    }      
}
