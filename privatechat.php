<?php 
session_start();
if(!isset($_SESSION['user_data']))
{
    header('location:login.php');
}
require('database/ChatUser.php');
require('database/ChatRooms.php');
?>
<!DOCTYPE html>
<html>
<head>
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
	<style type="text/css">
		html,
		body {
		  height: 100%;
		  width: 100%;
		  margin: 0;
		}
		#wrapper
		{
			display: flex;
		  	flex-flow: column;
		  	height: 100%;
		}
		#remaining
		{
			flex-grow : 1;
		}
		#messages {
			height: 200px;
			background: whitesmoke;
			overflow: auto;
		}
		#chat-room-frm {
			margin-top: 10px;
		}
		#user_list
		{
			height:450px;
			overflow-y: auto;
		}

		#messages_area
		{
			height: 650px;
			overflow-y: auto;
			background-color:#e6e6e6;
		}

	</style>
</head>
<body>
	<div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-5" style="background-color:#f1f1f1; height:100vh;border-right:1px solid #ccc;">
                <?php
                    $login_user_id = '';
                    foreach($_SESSION['user_data'] as $key => $value)
                    {
                        $login_user_id = $value['id'];
                        $token=$value['token'];
                    ?>
                    <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
                    <input type="hidden" name="is_active_chat" id="is_active_chat" value="No"/>
                    <div class="mt-3 mb-3 text-center">
                        <img src="<?php echo $value['profile']; ?>" width="150" class="img-fluid rounded-circle img-thumbnail" />
                        <h3 class="mt-2"><?php echo $value['name']; ?></h3>
                        <a href="profile.php" class="btn btn-secondary mt-2 mb-2">Edit</a>
                        <input type="button" class="btn btn-primary mt-2 mb-2" name="logout" id="logout" value="Logout" />
                    </div>
                    <?php
                    }
                    $user_object=new ChatUser;
                    $user_object->setUserId($login_user_id);
                    $user_data=$user_object->get_all_user_with_status_count();
                    ?>
                     <div class="list-group" style="max-height:100vh; margin-bottom:10px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                <?php 
                   foreach($user_data as $key => $user)
                   {
                       $icon = '<i class="fa fa-circle text-danger"></i>';

                       if($user['login_status'] == 'Login')
                       {
                           $icon = '<i class="fa fa-circle text-success"></i>';
                       }

                       if($user['user_id'] != $login_user_id)
                       {
                          echo "<a class='list-group-item list-group-item-action select_user' style='cursor:pointer' data-userid='".$user['user_id']."'>
									<img src='".$user["profile"]."' class='img-fluid rounded-circle img-thumbnail' width='50' />
									<span class='ml-1'>
                                        <strong>
                                            <span id='list_user_name_".$user["user_id"]."'>".$user["user_name"]."</span>
                                            <span id='userid_".$user["user_id"]."'></span>
                                        </strong>
                                    </span>
									<span class='mt-2 float-right' id='userstatus_".$user['user_id']."'>".$icon."</span>
								</a>";
                       }
                   }
                ?>
            </div>
            </div>
           
            <div class="col-lg-9 col-sm-7" style="max-height=90vh;">
                <div class="mt-3" id="chat_area"></div>
            </div>
        </div>

    </div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        var receiver_userid='';

        var conn = new WebSocket('ws://localhost:8080?token=<?php echo $token;?>');
        conn.onopen = function(e) {
			console.log("Connection established!");
		};
        conn.onmessage=function(e){
            var data=JSON.parse(e.data);
            if(data.status_type=='Offline'){
                $('#userstatus_'+data.user_id_status).html('<i class="fa fa-circle text-danger"></i>');
            }
            else if(data.status_type=='Online'){
                $('#userstatus_'+data.user_id_status).html('<i class="fa fa-circle text-success"></i>');
            }
            else
            {
                var row_class='';
                var background_class='';
                var user_name='';
                if(data.from=='Me'){
                    row_class='row justify-content-end';
                    background_class='alert-primary';
                }
                else{
                    row_class='row justify-content-start';
                    background_class='text-dark alert-light';
                }
                var html_data='';
                if(receiver_userid==data.userId || data.from=='Me')
                {
                    if($('#is_active_chat').val()=='Yes')
                    {
                        html_data+=`
                        <div class="${row_class}">
                                <div class="col-sm-10">
                                    <div class="shadow-sm alert ${background_class}">
                                        <b>${data.from}</b>
                                        <br />${data.msg}
                                        <div class="text-right">
                                            <small><i>${data.datetime}</i></small>
                                        </div>
                                    </div>
                                </div>
                        </div>`;
                        $('#messages_area').append(html_data);
                        $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
                        $('#chat_message').val("");
                    }
                }
                else
                {
                    var count_chat=$('#userid_'+data.userId).text();
                    if(count_chat==''){
                        count_chat=0;
                    }
                    count_chat++;
                    $('#userid_'+data.userId).html('<span class="badge badge-danger badge-pill">'+count_chat+'</span>');
                }
            }
        };
        conn.onclose=function(e){
            console.log("Connection close");
        };
        function make_chat_area(user_name){
            var html=`
           <div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col col-sm-6">
							<b>Chat with <span class="text-danger" id="chat_user_name">`+user_name+`</span></b>
						</div>
						<div class="col col-sm-6 text-right">
							<a href="chatroom.php" class="btn btn-success btn-sm">Go to group chat</a>
                            <button type="button" class="close" id="close_chat_area" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times; </span>
                            </button>
						</div>
						</div>		
					</div>
					<div class="card-body" id="messages_area">
                    </div>
				</div>
			</div>
            <form method="post" id="chat_form" class="mb-4" data-parsley-errors-container="#validation_error">
				<div class="input-group mb-3">
					<textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
					<div class="input-group-append">
						<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
					</div>
				</div>
				<div id="validation_error"></div>
			</form>
            `;
            $('#chat_area').html(html);
            $('#chat_form').parsley();
        };
        $(document).on('click','.select_user',function(){
            receiver_userid=$(this).data('userid');
            var from_user_id=$('#login_user_id').val();
            var receiver_username=$('#list_user_name_'+receiver_userid).text();
            $('.select_user.active').removeClass('active');
            $(this).addClass('active');
            make_chat_area(receiver_username);
            $('#is_active_chat').val('Yes');
            $.ajax({
                url:"controller/action.php",
                method:"POST",
                data:{
                    action:'fetch_chat',
                    to_user_id:receiver_userid,
                    from_user_id: from_user_id
                },
                dataType:"JSON",
                success:function(data)
                {
                    if(data.length>0)
                    {
                        var html_data='';
                        for(var count=0;count<data.length;count++){
                            var row_class='';
                            var background_class='';
                            var user_name='';
                            if(data[count].from_user_id==from_user_id){
                                row_class='row justify-content-end';
                                background_class='alert-primary';
                                user_name='Me';
                            }
                            else{
                                row_class='row justify-content-start';
                                background_class='text-dark alert-light';
                                user_name=data[count].from_user_name;
                            }
                            html_data+=`
                            <div class="${row_class}">
                                <div class="col col-sm-10">
                                    <div class="shadow alert ${background_class}">
                                        <b>${user_name}</b>
                                        </br>
                                        ${data[count].chat_message}
                                        <div class="text-right">
                                            <small><i>${data[count].timestamp}</i></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        }
                        $('#userid_'+receiver_userid).html('');
                        $('#messages_area').html(html_data);
                        $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
                    }
                }

            })
        });
        //Handle click button close
        $(document).on('click','#close_chat_area',function(){
            $('#chat_area').html('');
            $('.select_user.active').removeClass('active');
        });

        $(document).on('submit','#chat_form',function(e){
            e.preventDefault();
            if($('#chat_form').parsley().isValid()){
                var user_id=$('#login_user_id').val();
                var message=$('#chat_message').val();
                var data={
                    userId: user_id,
                    msg: message,
                    receiver_userid:receiver_userid,
                    command:'private'
                };
                conn.send(JSON.stringify(data));
            }
        });
//Keydown Enter
 $(document).on("keydown", "#chat_form textarea", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        if ($("#send").length) {
            $("#send").click();
        }
    }
});
//AJAX Logout
$('#logout').click(function(){
			user_id = $('#login_user_id').val();
			$.ajax({
				url:"controller/action.php",
				method:"POST",
				data:{user_id:user_id, action:'leave'},
				success:function(data)
				{
					var response = JSON.parse(data);
					if(response.status == 1)
					{
                        conn.close();
						location = 'index.php';
					}
				}
			})
		});
})
</script>
</html>
