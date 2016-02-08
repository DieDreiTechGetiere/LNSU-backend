<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Di\ServiceLocator;
/**
 * Controller for all actions regarding the userhandling
 */
class RegisterController extends AbstractRestfulController 
{
    protected $userTable;

    public function __construct()
    {
        $realServiceLocator = new ServiceLocator();
        $this->userTable    = $realServiceLocator->get('ShipsUnburned\Model\UserTable');  
    } 

    public function create()
    {
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $data = Zend_Json::decode($request->getPost());

            if ($data != null)
            {
                $result = $this->userTable->registerUserByLoginName($data);
            }
        }
        return new JsonModel($result);
    }
}
