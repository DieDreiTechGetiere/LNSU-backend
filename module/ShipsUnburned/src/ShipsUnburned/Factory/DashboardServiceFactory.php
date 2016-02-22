<?php

namespace ShipsUnburned\Factory;

use ShipsUnburned\Service\DashboardService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DashboardServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DashboardService($serviceLocator->get('ShipsUnburned\Model\Table\DashboardTable'));
    }
}
