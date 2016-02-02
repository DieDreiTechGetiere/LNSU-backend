<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
    )
);    