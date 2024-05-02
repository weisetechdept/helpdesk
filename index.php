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

    /* MGR */

    $router->get( '/user/mgrList', function() {
        require 'user/pages/mgrList.php';
    });

    /* admin */

    $router->get( '/admin/home', function() {
        require 'admin/pages/list.php';
    });

    $router->get( '/admin/user', function() {
        require 'admin/pages/user.php';
    });

    $router->get( '/admin/dept', function() {
        require 'admin/pages/dept.php';
    });

    $router->get( '/admin/user/de/(.*)', function($id) {
        require 'admin/pages/user-detail.php';
    });

    $router->get( '/admin/de/(.*)', function($id) {
        require 'admin/pages/detail.php';
    });

    $router->run();
    



