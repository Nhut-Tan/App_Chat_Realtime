<?php
require_once '../vendor/mail/Mailer.php';
if(isset($_POST["register"]))
{
    session_start();
    if(isset($_SESSION['user_data']))
    {
        header('location:../chatroom.php');
    }
    require_once('../database/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserName($_POST['user_name']);

    $user_object->setUserEmail($_POST['user_email']);

    $user_object->setUserPassword($_POST['user_password']);

    $user_object->setUserProfile($user_object->make_avatar(strtoupper($_POST['user_name'][0])));

    $user_object->setUserStatus('Disable');

    $user_object->setUserCreatedOn(date('Y-m-d H:i:s'));

    $user_object->setUserVerificationCode(md5(uniqid()));

    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0)
    {
        $_SESSION['error'] = 'This Email Already Register';
        header("location: ../register.php");
    }
    else
    {
        if($user_object->save_data())
        {
            $_SESSION['success']='Verification Email sent to ' . $user_object->getUserEmail() . ', so before login first verify your email'; 
            $mail=new Mailer();
            $content_mail='
            <p>Thank you for registering for Chat Application Demo.</p>
                <p>This is a verification email, please click the link to verify your email address.</p>
                <p><a href="http://localhost/Chatapp_realtime/controller/verify.php?code='.$user_object->getUserVerificationCode().'">Click to Verify</a></p>
                <p>Thank you...</p>
            ';
            $mail->register_account($content_mail,$user_object->getUserEmail());
            header("location:../register.php");
            exit;
        }
        else
        {
            $_SESSION['error'] = 'Something went wrong try again';
            header("location:../register.php");
        }
    }

}


?>
