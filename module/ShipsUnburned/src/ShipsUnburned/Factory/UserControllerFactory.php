<?php

namespace ShipsUnburned\Factory;

use ShipsUnburned\Controller\UserController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Class to dynamically create UserController with the needed UserTable
 */
class UserControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $userTable          = $realServiceLocator->get('ShipsUnburned\Model\UserTable');
        
        return new UserController($userTable);
    }
}