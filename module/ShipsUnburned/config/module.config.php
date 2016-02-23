<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'ShipsUnburned\Service\DashboardService' => 'ShipsUnburned\Factory\DashboardServiceFactory',
            'ShipsUnburned\Service\GameService' => 'ShipsUnburned\Factory\GameServiceFactory'
        )
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ), 
    'controllers' => array(
        'invokables' => array(
            'ShipsUnburned\Controller\Login' => 'ShipsUnburned\Controller\LoginController',
            'ShipsUnburned\Controller\Register' => 'ShipsUnburned\Controller\RegisterController',
            'ShipsUnburned\Controller\Dashboard' => 'ShipsUnburned\Controller\DashboardController',
            'ShipsUnburned\Controller\SearchGame' => 'ShipsUnburned\Controller\SearchGameController',
            'ShipsUnburned\Controller\InactiveUser' => 'ShipsUnburned\Controller\InactiveUserController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                    ),
                ),
            ),
            'login' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user/login',
                    'defaults' => array(
                        'controller' => 'ShipsUnburned\Controller\Login',
                    ),
                ),
            ),
            'register' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user/register',
                    'defaults' => array(
                        'controller' => 'ShipsUnburned\Controller\Register',
                    ),
                ),
            ),
            'dashboard' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/dashboard',
                    'defaults' => array(
                        'controller' => 'ShipsUnburned\Controller\Dashboard',
                    ),
                ),
            ),
            'inactiveusers' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/dashboard/inactive',
                    'defaults' => array(
                        'controller' => 'ShipsUnburned\Controller\InactiveUser',
                    ),
                ),
            ),            
            'searchgame' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/game/search',
                    'defaults' => array(
                        'controller' => 'ShipsUnburned\Controller\SearchGame',
                    ),
                ),
            ),             
        ),
    ),
); 
    
