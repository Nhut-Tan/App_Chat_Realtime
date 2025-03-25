<?php
class ChatUser
{
	private $user_id;
	private $user_name;
	private $email;
	private $password;
	private $profile;
	private $status;
	private $created_on;
	private $verify_code;
	private $login_status;
	private $user_token;
	private $user_connection_id;
	public $connect;

	public function __construct()
	{
		require_once('config.php');
		$database_object = new Database_connection;
		$this->connect = $database_object->connect();
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setUserName($user_name)
	{
		$this->user_name = $user_name;
	}

	function getUserName()
	{
		return $this->user_name;
	}

	function setUserEmail($email)
	{
		$this->email = $email;
	}

	function getUserEmail()
	{
		return $this->email;
	}

	function setUserPassword($password)
	{
		$hass_pass=md5($password);
		$this->password = $hass_pass;
	}

	function getUserPassword()
	{
		return $this->password;
	}

	function setUserProfile($profile)
	{
		$this->profile = $profile;
	}

	function getUserProfile()
	{
		return $this->profile;
	}

	function setUserStatus($status)
	{
		$this->status = $status;
	}

	function getUserStatus()
	{
		return $this->status;
	}

	function setUserCreatedOn($created_on)
	{
		$this->created_on = $created_on;
	}

	function getUserCreatedOn()
	{
		return $this->created_on;
	}

	function setUserVerificationCode($verify_code)
	{
		$this->verify_code = $verify_code;
	}

	function getUserVerificationCode()
	{
		return $this->verify_code;
	}

	function setUserLoginStatus($login_status)
	{
		$this->login_status = $login_status;
	}

	function getUserLoginStatus()
	{
		return $this->login_status;
	}
	function setUserToken($user_token)
	{
		$this->user_token = $user_token;
	}

	function getUserToken()
	{
		return $this->user_token;
	}
	function setUserConnectionId($user_connection_id)
	{
		$this->user_connection_id = $user_connection_id;
	}

	function getUserConnectionId()
	{
		return $this->user_connection_id;
	}

	function make_avatar($character)
	{
	    $fullpath = "../images/". time() . ".png";
		$image = imagecreate(200, 200);
		$red = rand(0, 255);
		$green = rand(0, 255);
		$blue = rand(0, 255);
	    imagecolorallocate($image, $red, $green, $blue);  
	    $textcolor = imagecolorallocate($image, 255,255,255);

	    $font = '../vendor/font/arial.ttf';

	    imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);
	    imagepng($image, $fullpath);
	    imagedestroy($image);
		$dbPath = str_replace("../", "", $fullpath);
	    return $dbPath;
	}

	function get_user_data_by_email()
	{
		$query = "
		SELECT * FROM users 
		WHERE email = :email
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':email', $this->email);

		if($statement->execute())
		{
			$user_data = $statement->fetch(PDO::FETCH_ASSOC);
		}
		return $user_data;
	}

	function save_data()
	{
		$query = "
		INSERT INTO users (user_name, email, password, profile, status, created_on, verify_code) 
		VALUES (:user_name, :user_email, :user_password, :user_profile, :user_status, :user_created_on, :user_verification_code)
		";
		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_name', $this->user_name);

		$statement->bindParam(':user_email', $this->email);

		$statement->bindParam(':user_password',$this->password);

		$statement->bindParam(':user_profile', $this->profile);

		$statement->bindParam(':user_status', $this->status);

		$statement->bindParam(':user_created_on', $this->created_on);

		$statement->bindParam(':user_verification_code', $this->verify_code);

		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function is_valid_email_verification_code()
	{
		$query = "
		SELECT * FROM users 
		WHERE verify_code = :user_verification_code
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_verification_code', $this->verify_code);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function enable_user_account()
	{
		$query = "
		UPDATE users 
		SET status = :status 
		WHERE verify_code = :verify_code
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':status', $this->status);

		$statement->bindParam(':verify_code', $this->verify_code);

		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function update_user_login_data()
	{
		$query = "
		UPDATE users 
		SET login_status = :login_status, user_token = :user_token
		WHERE user_id = :user_id
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':login_status', $this->login_status);
		$statement->bindParam(':user_token', $this->user_token);
		$statement->bindParam(':user_id', $this->user_id);
		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_user_data_by_id()
	{
		$query = "
		SELECT * FROM users 
		WHERE user_id = :user_id";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_id', $this->user_id);

		try
		{
			if($statement->execute())
			{
				$user_data = $statement->fetch(PDO::FETCH_ASSOC);
			}
			else
			{
				$user_data = array();
			}
		}
		catch (Exception $error)
		{
			echo $error->getMessage();
		}
		return $user_data;
	}

	function upload_image($profile)
	{
		$extension = explode('.', $profile['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = 'images/' . $new_name;
		move_uploaded_file($profile['tmp_name'],'../'.$destination);
		return $destination;
	}

	function update_data()
	{
		$query = "
		UPDATE users 
		SET user_name = :user_name, 
		email = :email, 
		password = :password, 
		profile = :profile  
		WHERE user_id = :user_id
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_name', $this->user_name);

		$statement->bindParam(':email', $this->email);

		$statement->bindParam(':password', $this->password);

		$statement->bindParam(':profile', $this->profile);

		$statement->bindParam(':user_id', $this->user_id);

		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_user_all_data()
	{
		$query = "
		SELECT * FROM users 
		ORDER BY login_status DESC;
		";

		$statement = $this->connect->prepare($query);

		$statement->execute();

		$data = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}
	function get_all_user_with_status_count(){
		$query = "
		SELECT user_id, user_name, profile, login_status,
			(SELECT COUNT(*) 
			FROM chat_message
			WHERE to_user_id=:user_id AND from_user_id=users.user_id AND status='No')
		 	as count_status
		FROM users
		";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':user_id', $this->user_id);
		$statement->execute();
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	function update_user_connection_id(){
		$query="
		UPDATE users 
		SET user_connection_id = :user_connection_id
		WHERE user_token = :user_token
		";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':user_connection_id', $this->user_connection_id);
		$statement->bindParam(':user_token', $this->user_token);
		$statement->execute();
	}
	function get_userid_from_token(){
		$query="
		SELECT user_id 
		FROM users
		WHERE user_token=:user_token";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':user_token', $this->user_token);
		$statement->execute();
		$user_id= $statement->fetch(PDO::FETCH_ASSOC);
		return $user_id;
	}
}



?>