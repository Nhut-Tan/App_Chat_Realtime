<?php 
session_start();

require('../database/ChatUser.php');
// include('../profile.php');
 $user_object=new ChatUser;
// $user_id='';
// foreach($_SESSION['user_data'] as $key=>$value){
//     $user_id=$value['id'];
// }
// $user_object->setUserId($user_id);
// $user_data=$user_object->get_user_data_by_id();


if(isset($_POST['edit'])){
    $user_id=$_GET['id'];
    $user_profile=$_POST['hidden_user_profile'];
    if($_FILES['user_profile']['name']!=''){
        $user_profile=$user_object->upload_image($_FILES['user_profile']);
        $_SESSION['user_data'][$user_id]['profile']=$user_profile;
    }
    $user_object->setUserName($_POST['user_name']);
    $user_object->setUserEmail($_POST['user_email']);
    $user_object->setUserPassword($_POST['user_password']);
    $user_object->setUserProfile($user_profile);
    $user_object->setUserId($user_id);
    if($user_object->update_data())
    {
        $_SESSION['user_data'][$user_id]=[ 
        'id'    =>  $user_id,
        'name'  =>  $_POST['user_name'],
        'profile'   => $user_profile
        ];
        $_SESSION['update_success'] = 'Update successfully!';
        header("location: ../profile.php");
        exit();
    }
}

?>