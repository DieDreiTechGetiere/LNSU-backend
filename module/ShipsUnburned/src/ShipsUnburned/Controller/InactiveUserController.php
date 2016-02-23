<?php


namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class InactiveUserController extends AbstractRestfulController
{
    protected $userTable;
    
    public function __construct()
    {
    }  
    
    //POST Method for setting User active
    public function create()
    {
        $sm = $this->getServiceLocator();
        $this->gameService = $sm->get('ShipsUnburned\Table\UserTable');        

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            $result = $this->userTable->setUsersActive($request);
        }
        return new JsonModel($result);
    }

    //GET Method getting all inactive Users
    public function getList()
    {
        $sm = $this->getServiceLocator();
        $this->gameService = $sm->get('ShipsUnburned\Table\UserTable');
        
        $request = $this->getRequest();
        
        if ($request->isGet())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            $result = $this->userTable->getAllInactiveUsers();
        }
        
        return new JsonModel($result);
    }    
}
