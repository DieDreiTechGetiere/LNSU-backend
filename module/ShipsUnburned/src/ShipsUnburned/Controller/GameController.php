<?php


namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class GameController extends AbstractRestfulController
{
    protected $gameService;
    
    public function __construct()
    {
    }  
    
    //POST Method finishing one round
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
            $result = $this->gameService->endRound($request);
        }
        return new JsonModel($result);
    }

    //PUT Method for polling while waiting!
    public function get($params)
    {
        $sm = $this->getServiceLocator();
        $this->gameService = $sm->get('ShipsUnburned\Service\GameService');
        
        $request = $this->getRequest();
        
        if ($request->isGet())
        {
            $exploded = explode(":", $params);
            
            //matchid userid round
            $result = $this->gameService->checkRound($exploded[0], $exploded[1], $exploded[2]);
        }
        
        return new JsonModel($result);
    }    
    
    //DELETE Method for forfeiting a Match
    public function delete($id)
    {
        $sm = $this->getServiceLocator();
        $this->gameService = $sm->get('ShipsUnburned\Service\GameService');
        
        $result = $this->gameService->forfeitGame($id);
        
        return new JsonModel($result);
    }
}
