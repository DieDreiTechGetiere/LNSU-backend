<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
/**
 * Controller for all actions regarding the userhandling
 */
class RegisterController extends AbstractRestfulController 
{
    protected $userTable;

    public function __construct()
    {} 

    public function create()
    {
        $sm = $this->getServiceLocator();
        $this->userTable = $sm->get('ShipsUnburned\Model\UserTable');
        
        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $data = \Zend\Json\Json::decode($request->getContent());
            
            if ($data != null)
            {
                $result = $this->userTable->registerUserByLoginName($data);
            }
        }
        return new JsonModel($result);
    }
}
