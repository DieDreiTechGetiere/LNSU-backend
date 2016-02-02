<?php

namespace ShipsUnburned\Factory;

use ShipsUnburned\Service\PasswordService;
use ShipsUnburned\Model\UserTable;
use ShipsUnburned\Model\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
/**
 * Class to dynamically create UserTable-Objects
 */
class UserTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserTable(
                $serviceLocator->get('Zend\Db\Adapter\Adapter'),
                new ClassMethods(false),
                new User(),
                new PasswordService() 
        );
    }
}