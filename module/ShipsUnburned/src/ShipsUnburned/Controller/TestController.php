<?php


namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class TestController extends AbstractRestfulController
{
    protected $gameTable;
    
    public function __construct()
    {
    }  
    
    //POST Method finishing one round
    public function create()
    {
        $sm = $this->getServiceLocator();
        $this->gameTable = $sm->get('ShipsUnburned\Model\Table\GameTable');        
        
        //for testing purpose only:
        //new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            $result = $this->gameTable->createTestMatch();
        }
        return new JsonModel($result);
    }
}
