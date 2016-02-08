<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ShipsUnburned\Model\UserTable' => 'ShipsUnburned\Factory\ShipsUnburnedFactory',
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        )
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ), 
    'controllers' => array(
        'factories' => array(
            'ShipsUnburned\Controller\User' => 'ShipsUnburned\Factory\UserControllerFactory'
        )
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
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/login'
                    ),
                    'defaults' => array(
                        'controller' => 'ShipsUnburned\Controller\UserController',
                    ),
                ),
            ),
        ),
);    
