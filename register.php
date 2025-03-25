<?php 
session_start();
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
        
        <div class="row justify-content-md-center">
            <div class="col col-md-4 mt-5">
            <?php
                if(isset($_SESSION['error']))
                {
                    echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      '.$_SESSION['error'].'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    ';
                    unset($_SESSION['error']);
                }
                if(isset($_SESSION['success']))
                {
                    echo '
                    <div class="alert alert-success">
                    '.$_SESSION['success'].'
                    </div>
                    ';
                    unset($_SESSION['success']);
                }
                ?>
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">

                        <form action="controller/register.php" method="post" id="register_form">

                            <div class="form-group">
                                <label>Enter Your Name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                            </div>

                            <div class="form-group">
                                <label>Enter Your Email</label>
                                <input type="text" name="user_email" id="user_email" class="form-control" data-parsley-type="email" placeholder="abc@gmail.com" required />
                            </div>

                            <div class="form-group">
                                <label>Enter Your Password</label>
                                <input type="password" name="user_password" id="user_password" class="form-control" data-parsley-minlength="6" data-parsley-maxlength="12" data-parsley-pattern="^[a-zA-Z0-9]+$" required />
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" name="register" class="btn btn-success" value="Register" />
                            </div>

                        </form>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</body>
</html>

<script>
$(document).ready(function(){

    $('#register_form').parsley();

});
</script>