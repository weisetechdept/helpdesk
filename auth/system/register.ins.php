<?php 
    require_once '../../db-conn.php';

    $request = json_decode(file_get_contents('php://input'));
    $fname = $request->f_name;
    $lname = $request->l_name;
    $dept = $request->department;

    echo $fname . ' ' . $lname . ' ' . $dept;