<?php

include_once '../config/db_connection.php';
include '../config/core.php';


class LoginRegisterController extends DB_Connect
{
//__check if email exists ________________________________________________________
	public function check_email($email)
	{
		$check_email = "SELECT `email` FROM `users` WHERE `email` = '".$this->getconn()->real_escape_string($email)."'";
		$get_email = $this->getconn()->query($check_email);

		if ($get_email->num_rows == 1) {
			return true;		
		}
		else if ($get_email->num_rows == 0){
			return false;
		}
	}
//__check if password matches with the email ____________________________________________
	public function login($email, $password)
	{
		$query = "SELECT `id`, `title` FROM `users` WHERE `email` = '".$this->getconn()->real_escape_string($email)."' AND `password` = '".$this->getconn()->real_escape_string($password)."'";
		$result = $this->getconn()->query($query);

		if ($result->num_rows == 1) 
		{
			$user = $result->fetch_assoc();
			$_SESSION['u_id'] = $user['id'];
			$_SESSION['title'] = $user['title'];
			return true;			
		}
		else if($result->num_rows == 0){
			return false;
		}
	}

//__REGISTER A USER ______________________________________________________________________

	public function create_user($email, $password, $firstname, $lastname){
		$query = "INSERT INTO `users` VALUES ('', '$firstname', '$lastname', '$email', '$password', 'user', 'now()')";
		$query_run = $this->getconn()->query($query);
	}

//__log user in by directing to home.php ___________________________________________________
	public function getuserinfo($field)
	{
		$get_info = "SELECT `$field` FROM `users` WHERE `id`='".$this->get_session('u_id')."'";
		if ($info = $this->getconn()->query($get_info)) {
			if($userinfo = $info->fetch_assoc()){
				if ($field == 'firstname') {
					return $userinfo['firstname'];
				}else{
					return $userinfo['lastname'];
				}
				
			}
		}
	}

//__login check_____________________________________________________
	public function loggedin($key){
		if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
			return true;
		}
		else{
			return false;
		}
	}
	
//__title check ______________________________________________________________________
	public function check_title($key) {
		if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
			if($_SESSION[$key] == 'admin'){
				return 1;
			}
			else if($_SESSION[$key] == 'user') {
				return 2;
			}
		}
		else{
			return 0;
		}
	}

//__sessions__________________________________________________
	public function start_session(){
		echo "It works. ";
	}

	public function destroy_session($http_referer){
		session_destroy();
		header('Location: '.$http_referer);
	}

	public function get_session($key){
		return $_SESSION[$key];
	}

}

?>