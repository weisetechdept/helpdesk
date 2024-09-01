<?php
    require 'vendor/autoload.php';
    $router = new \Bramus\Router\Router();

    $router->get( '/', function() {
        require 'user/pages/404.php';
    });

    $router->get( '/404', function() {
        require 'user/pages/404.php';
    });
    

    /* Auth */

    $router->get( '/loginAuth', function() {
        require 'auth/pages/login.php';
    });

    $router->get( '/register', function() {
        require 'auth/pages/register.php';
    });

    /* user section */

    $router->get( '/user/add-ticket/(.*)', function($id) {
        require 'user/pages/add-ticket.php';
    });

    $router->get( '/user/list/(.*)', function($id) {
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

    $router->get( '/admin/logout', function() {
        require 'admin/pages/logout.php';
    });

    $router->get( '/admin/add-user', function() {
        require 'admin/pages/add-user.php';
    });

    $router->get( '/admin/auth', function() {
        require 'admin/pages/login.php';
    });

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

    $router->get( '/admin/dept/de/(.*)', function($id) {
        require 'admin/pages/dept-detail.php';
    });

    $router->get( '/admin/report', function() {
        require 'admin/pages/report.php';
    });

    $router->get( '/admin/type', function() {
        require 'admin/pages/type.php';
    });

    $router->get( '/admin/vendor', function() {
        require 'admin/pages/vendor.php';
    });

    $router->get( '/admin/assets-report', function() {
        require 'admin/pages/assets-report.php';
    });

    /* Verify */

    $router->get( '/verify/(.*)', function($id) {
        require 'verify/pages/verify.php';
    });

    $router->run();
    



