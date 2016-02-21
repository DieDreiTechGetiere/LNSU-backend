<?php

namespace ShipsUnburned;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use ShipsUnburned\Model\Table\UserTable;
use ShipsUnburned\Model\Table\DashboardTable;
use ShipsUnburned\Model\Table\GameTable;
use ShipsUnburned\Service\PasswordService;

class Module implements 
    AutoloaderProviderInterface, 
    ConfigProviderInterface
{
    public function getAutoloaderConfig() 
    {
        
        //Legt den Namespace fest auf ShipsUnburned/.../...
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__=> __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            //Stellt automatisch TableAdapter bereit
            'factories' => array(
                'ShipsUnburned\Model\Table\UserTable' => function($sm) {
                    $tableGateway = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTable($tableGateway, new PasswordService());
                    return $table;
                },
                'ShipsUnburned\Model\Table\DashboardTable' => function($sm) {
                    $tableGateway = $sm->get('Zend\Db\Adapter\Adapter');
                    //TODO Create DashboardTable class and change construct Parameters
                    $table = new DashboardTable($tableGateway);
                    return $table;
                },       
                'ShipsUnburned\Model\Table\GameTable' => function($sm) {
                    $tableGateway = $sm->get('Zend\Db\Adapter\Adapter');
                    //TODO Create DashboardTable class and change construct Parameters
                    $table = new GameTable($tableGateway);
                    return $table;
                },  
            ),
        );           
    }
}