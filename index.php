<?php
    require 'vendor/autoload.php';
    $router = new \Bramus\Router\Router();

    $router->get( '/', function() {
        require '404.html';
    });

    $router->get( '/404', function() {
        require '404.html';
    });

    /* user section */

    $router->get( '/user/add-ticket', function() {
        require 'user/pages/add-ticket.php';
    });

/*
    $router->get( '/mgr/agent/(.*)', function($page) {
        require 'mgr/pages/agent.php';
    });
*/
    

    $router->run();
    



