<?php


namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class SearchGameController extends AbstractRestfulController
{
    protected $gameService;
    
    public function __construct()
    {
    }  
    
    public function create()
    {
        $sm = $this->getServiceLocator();
        $this->userTable = $sm->get('ShipsUnburned\Service\GameService');        
        
        //for testing purpose only:
        //new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            $result = $this->gameService->searchGame($request["id"]);
        }
        return new JsonModel($result);
    }    
}
