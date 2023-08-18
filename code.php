<?php 
session_start();
include 'dbcon.php';

if(isset($_POST['register_btn'])){
    $fullname = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userProperties = [
        'email' => $email,
        'emailVerified' => false,
        'phoneNumber' => '+63' .$phone,
        'password' => $password,
        'displayName' => $fullname,
    ];
    
    $createdUser = $auth->createUser($userProperties);

    if($createdUser){
        $_SESSION['status'] = "User Created Successfully";
        header('Location: motoristlogin.php');
        exit();
    }else{
        $_SESSION['status'] = "User Not Created";
        header('Location: motoristlogin.php');
        exit();
    }
}