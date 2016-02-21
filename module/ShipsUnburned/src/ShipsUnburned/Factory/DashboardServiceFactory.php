<?php

namespace ShipsUnburned\Factory;

use ShipsUnburned\Service\DashboardService;
use ShipsUnburned\Model\Entity\MatchList;
use ShipsUnburned\Model\Entity\Stats;
use ShipsUnburned\Model\Entity\HighscoreList;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DashboardServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DashboardService(
                $serviceLocator->get('ShipsUnburned\Model\Table\DashboardTable'),
                new MatchList(),
                new Stats(),
                new HighscoreList()
        );
    }
}
