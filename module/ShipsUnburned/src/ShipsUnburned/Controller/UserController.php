<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
/**
 * Controller for all actions regarding the userhandling
 */
class UserController extends AbstractRestfulController 
{
    protected $userTable;
    //TODO add UserForm as Property and to the Factory. Construct UserFilter too

    public function __construct(UserTable $userTable)
    {
        $realServiceLocator = new ServiceLocator();
        $userTable          = $realServiceLocator->get('ShipsUnburned\Model\UserTable');  
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
    /* Muss ausgelagert werden in einen eigenen Controller
    public function createRegister()
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
    */


    /**
     * FOR TESTING PURPOSE ONLY
     * @return JsonModel
     */
    public function getList()
    {   // Action used for GET requests without resource Id
        return new JsonModel(
            array('data' =>
                array(
                    array('id'=> 1, 'name' => 'Mothership', 'band' => 'Led Zeppelin'),
                    array('id'=> 2, 'name' => 'Coda',       'band' => 'Led Zeppelin'),
                )
            )
        );
    }


    /**
     * FOR TESTING PURPOSE ONLY
     * @param mixed $id
     * @return JsonModel
     */
    public function get($id)
    {
        // Action used for GET requests with resource Id
        return new JsonModel(array("data" => array('id'=> 2, 'name' => 'Coda', 'band' => 'Led Zeppelin')));
    }
     
}
