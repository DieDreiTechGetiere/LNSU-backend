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
        //new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
        

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            //\Zend\Debug\Debug::dump($data, $label = null, $echo = true);
            $result = $this->userTable->verifyLoginByLoginNameAndPassword($request["loginName"], $request["password"]);
        }
        return new JsonModel($result);
    }      
}
