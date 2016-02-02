<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
/**
 * Controller for all actions regarding the userhandling
 */
class UserController extends AbstractActionController
{
    protected $userTable;
    
    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
    }    
    /**
     * Actionfunction for user who try to login
     * @return JsonModel
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $result = 0;
        
        if ($request->isPost())
        {
            $data = Zend_Json::decode($request->getPost());
            
            if ($data != null)
            {
                $result = $this->userTable->verifyLoginByLoginNameAndPassword($data["loginName"], $data["password"]);
            }
        }
        
        return new JsonModel(array(
            'user' => $result
        ));
    }
    
    public function logoutAction()
    {
        
    }
    
    public function registerAction()
    {
        
    }
}
