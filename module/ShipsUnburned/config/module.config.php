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
            'user' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'ShipsUnburned\Controller\UserController',
                    ),
                ),
//                'type'    => 'literal',
//                'options' => array(
//                    'route'    => '/register',
//                    'defaults' => array(
//                        'controller' => 'ShipsUnburned\Controller\UserController',
//                    ),
//                ),
            ),
        ),
    ) 
);    
