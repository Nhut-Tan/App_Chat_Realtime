<?php
session_start();

if(!isset($_SESSION['user_data'])){
    header('location:index.php');
}
require('database/ChatUser.php');
$user_object=new ChatUser;
$user_id='';
foreach($_SESSION['user_data'] as $key=>$value){
    $user_id=$value['id'];
}
$user_object->setUserId($user_id);
$user_data=$user_object->get_user_data_by_id();
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
    <div class="containter">
        <div class="row justify-content-md-center mt-5"> 
            <div class="col-md-4">
                <div class="card">
                    <?php
                    if (isset($_SESSION['update_success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['update_success'] . '</div>';
                        unset($_SESSION['update_success']); 
                    }
                    ?>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">Profile</div>
                            <div class="col-md-6 text-right">
                                <a href="index.php" class="btn btn-primary btn-sm">Go to chat</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                  
                        <form action="controller/profile.php?id=<?php echo $user_id?>" method="post" id="profile_form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" value="<?php echo $user_data['user_name'] ?>"  />
                            </div>    
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="text" name="user_email" id="user_email" class="form-control" data-parsley-type="email" value="<?php echo $user_data['email'] ?>" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="user_password" id="user_password" class="form-control" value="<?php echo $user_data['password']?>"  />
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="user_profile" id="user_profile" class="form-control"/>
                                <br>
                                <img src="<?php echo $user_data['profile']?>" class="img-fluid img-thumbnail-mt-3" width="100"> 
                                <input type="hidden" name="hidden_user_profile" id="hidden_user_profile" class="form-control" value="<?php echo $user_data['profile'] ?>" />
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" name="edit" class="btn btn-primary" value="Edit" />
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>

</body>

</html>

