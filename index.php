
<?php

session_start();

$error = '';

if(isset($_SESSION['user_data']))
{
    header('location:chatroom.php');
}

if(isset($_POST['login']))
{
    require_once('database/ChatUser.php');

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
                    header('location:chatroom.php');
                }
            }
            else
            {
                $error = 'Wrong Password';
            }
        }
        else
        {
            $error = 'Please Verify Your Email Address';
        }
    }
    else
    {
        $error = 'Wrong Email Address';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
   	 <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="vendor/parsley/parsley.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/bootstrap/js/jquery/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor/parsley/parsley.min.js"></script>
</head>

<body>

<?php
include "login.php";
?>
</body>

</html>

<script>

$(document).ready(function(){
    
    $('#login_form').parsley();
    
});

</script>