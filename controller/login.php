<?php
session_start();
if(isset($_SESSION['user_data']))
{
    header('location:../chatroom.php');
}

if(isset($_POST['login']))
{
    require_once('../database/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserEmail($_POST['user_email']);

    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0)
    {
        if($user_data['status'] == 'Enable')
        {
            if($user_data['password'] == md5($_POST['user_password']))
            {
                $user_object->setUserId($user_data['user_id']);
                $user_object->setUserLoginStatus('Login');
                $user_token=md5(uniqid());
                $user_object->setUserToken($user_token);
                if($user_object->update_user_login_data())
                {
                    $_SESSION['user_data'][$user_data['user_id']] = [
                        'id'    =>  $user_data['user_id'],
                        'name'  =>  $user_data['user_name'],
                        'profile'   =>  $user_data['profile'],
                        'token'=> $user_token
                    ];
                    header('location:../chatroom.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'Wrong Password';
                header('location:../login.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'Please Verify Your Email Address';
            header('location:../login.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'Wrong Email Address';
        header('location:../login.php');
    }
}

?>