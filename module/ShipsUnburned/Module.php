<?php

namespace ShipsUnburned;

//use Zend\Db\ResultSet\ResultSet;
//use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

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
    
//    public function getServiceConfig()
//    {
//        return array(
//            
//            //Stellt automatisch ein TabelGateway bereit für jeden NewsTable
//            'factories' => array(
//                'MedSurv\Model\NewsTable' => function($sm) {
//                    $tableGateway = $sm->get('NewsTableGateway');
//                    $table = new NewsTable($tableGateway);
//                    return $table;
//                },
//            
//            //Alle ResultSets im NewsTable werden automatisch zu News-Entitäten umgewandelt            
//            'NewsTableGateway' => function($sm) {
//                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//                    $resultSetPrototype = new ResultSet();
//                    $resultSetPrototype->setArrayObjectPrototype(new News());
//                    return new TableGateway('news', $dbAdapter, null, $resultSetPrototype);
//                },
//            ),
//        );           
//    }    
}