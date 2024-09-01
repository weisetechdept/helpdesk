<?php 
//prgitadmin2024
//2024assetadmin
session_start();
require_once '../../db-conn.php';
date_default_timezone_set("Asia/Bangkok");

    $request = json_decode(file_get_contents('php://input'));
    $username = $request->username;
    $password = $request->password;

    if(!$username || !$password){

        $api = array(
            'status' => 'error',
            'message' => 'Username and password required'
        );
        exit;

    } else {

        $user = $db->where('admin_username', $username)->getOne('admin_user');
        $hashPass = $user['admin_password'];

        if(!$user){
            $api = array(
                'status' => 'error',
                'message' => 'Username not found'
            );
        } elseif (password_verify($password, $hashPass)){
            $_SESSION['adminName'] = $user['admin_firstname'].' '.$user['admin_lastname'];
            $_SESSION['userAdmin'] = $user;
            $_SESSION['adminGroup'] = $user['admin_role'];
            $api = array(
                'status' => 'success',
                'message' => 'Login success'
            );
        }else{
            $api = array(
                'status' => 'error',
                'message' => 'Login failed'
            );
        }

    }

    echo json_encode($api);

?>