<?php

namespace ShipsUnburned\Factory;

use ShipsUnburned\Service\GameService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GameServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new GameService($serviceLocator->get('ShipsUnburned\Model\Table\GameTable'));
    }
}
