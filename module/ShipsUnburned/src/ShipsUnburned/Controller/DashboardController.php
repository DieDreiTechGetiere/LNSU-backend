<?php

namespace ShipsUnburned\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
/**
 * Controller for all actions regarding the dashboardhandling
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
        $sm = $this->getServiceLocator();
        $this->dashboardService = $sm->get('ShipsUnburned\Service\DashboardService');        

        $request = $this->getRequest();
        
        if ($request->isGet())
        {
            $request = json_decode(file_get_contents('php://input'), true);
            //For testing purpose
//            $result = $this->dashboardService->getDashboardData("92");
            $result = $this->dashboardService->getDashboardData($request["id"]);
        }
        return new JsonModel((array)$result);
    }      
}
