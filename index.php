<?php
    require 'vendor/autoload.php';
    $router = new \Bramus\Router\Router();

    $router->get( '/', function() {
        require '404.html';
    });

    $router->get( '/404', function() {
        require '404.html';
    });

    /* Auth */

    $router->get( '/login', function() {
        require 'auth/pages/login.php';
    });

    $router->get( '/register', function() {
        require 'auth/pages/register.php';
    });

    /* user section */

    $router->get( '/user/add-ticket', function() {
        require 'user/pages/add-ticket.php';
    });

    $router->get( '/user/list', function() {
        require 'user/pages/list.php';
    });

    $router->get( '/user/de/(.*)', function($id) {
        require 'user/pages/detail.php';
    });

/*
    $router->get( '/mgr/agent/(.*)', function($page) {
        require 'mgr/pages/agent.php';
    });
*/
    

    $router->run();
    



