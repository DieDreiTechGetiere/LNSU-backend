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
            $request = $request->getPost();
            $request = json_decode(file_get_contents('php://input'), true);
//            \Zend\Debug\Debug::dump( $request['username'], $label = null, $echo = true);  
            $result = $this->userTable->registerUserByLoginName($request);

        }
        return new JsonModel($result);
    }
}
