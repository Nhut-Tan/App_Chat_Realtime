<?php

$error = '';

session_start();

if(isset($_GET['code']))
{
    require_once('../database/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserVerificationCode($_GET['code']);

    if($user_object->is_valid_email_verification_code())
    {
        $user_object->setUserStatus('Enable');

        if($user_object->enable_user_account())
        {
            $_SESSION['success_message'] = 'Your Email Successfully verify, now you can login into this chat Application';
            header('location:../login.php');
        }
        else
        {
            $error = 'Something went wrong try again....';
        }
    }
    else
    {
        $error = 'Something went wrong try again....';
    }
}

?>