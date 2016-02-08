<?php

namespace ShipsUnburned;

//use Zend\Db\ResultSet\ResultSet;
//use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use ShipsUnburned\Model\UserTable;
use ShipsUnburned\Service\PasswordService;
use ShipsUnburned\Model\User;
use Zend\Stdlib\Hydrator\ClassMethods;

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
            //Stellt automatisch ein TableAdapter bereit für jeden UserTable
            'factories' => array(
                'ShipsUnburned\Model\UserTable' => function($sm) {
                    $tableGateway = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTable($tableGateway, new ClassMethods(false), new User(), new PasswordService());
                    return $table;
                },
            ),
        );           
    }
}