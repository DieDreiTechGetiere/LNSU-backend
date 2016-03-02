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
    
    //POST Method initial Gamesearch
    public function create()
    {
        $sm = $this->getServiceLocator();
        $this->gameService = $sm->get('ShipsUnburned\Service\GameService');        
        
        //for testing purpose only:
        //new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            $result = $this->gameService->searchGame($request["userId"]);
        }
        return new JsonModel($result);
    }

    //PUT Method for polling!
    public function get($id)
    {
        $sm = $this->getServiceLocator();
        $this->gameService = $sm->get('ShipsUnburned\Service\GameService');
        
        $request = $this->getRequest();
        
        if ($request->isGet())
        {
            $result = $this->gameService->checkMatch($id);
        }
        
        return new JsonModel($result);
    }    
    
    //DELETE Method for cancelling a Match
    public function delete($id)
    {
        $sm = $this->getServiceLocator();
        $this->gameService = $sm->get('ShipsUnburned\Service\GameService');
        
        $result = $this->gameService->cancelMatch($id);
        
        return new JsonModel($result);
    }
}
