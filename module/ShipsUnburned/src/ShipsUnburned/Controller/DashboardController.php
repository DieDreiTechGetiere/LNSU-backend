<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
//for testing purpose only!!!
use ShipsUnburned\Model\Entity\MatchList;
/**
 * Controller for all actions regarding the userhandling
 */
class DashboardController extends AbstractRestfulController 
{
    protected $dashboardService;

    public function __construct()
    {
    } 

    /**
     * getList for getting the Dashboard-Object
     * @return JsonModel
     */
    public function getList()
    {
        //TODO: For Testing purpose commented!!!!
        $sm = $this->getServiceLocator();
        $this->dashboardService = $sm->get('ShipsUnburned\Service\DashboardService');        
        
        //for testing purpose only:
        
//        $test = new MatchList();
//        $array = array('a', 'b', 'c', 'd');
//        $test->addMatchesFromTable($array);
//        \Zend\Debug\Debug::dump($test, $label = null, $echo = true); 

        $request = $this->getRequest();
        
        if ($request->isGet())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            $result = $this->dashboardService->getDashboardData($request["id"]);
             
        }
        return new JsonModel($result);
    }      
}
