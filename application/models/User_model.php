<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends Base_model {
	
	public $table_name = "users";
	public $table_identifier = "id";


	public function create_user($username, $email, $password) {
		$data = array(
			'username'   => $username,
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'created_at' => $this->mysql_date('now'),
			'updated_at' => $this->mysql_date('now'),
		);
		return $this->my_create($data);
	}
	
	public function resolve_user_login($username, $password) {
		$user = $this->my_where(['username'=>$username]);
		if($user && $this->verify_password_hash($password, $user->password)) return $user;			
		return false;
	}
	
	public function approve_login() {
		$update_array = array(
			'last_seen' => $this->mysql_date('now'),
			'last_login' => $this->mysql_date('now'),
		);
		return $this->my_update($update_array);
	}

	public function set_random_password() {
		$new_password = uniqid();
		$this->my_set_to('password',$this->hash_password($new_password));
		return $new_password;
	}

	public function prepare_user_data(){
		$user_data = new stdClass();
		$user_data->user_id 		= (int)$this->id;
		$user_data->username 		= (string)$this->username;
		$user_data->email 			= (string)$this->email;
		$user_data->avatar 			= (string)$this->avatar;
		$user_data->is_admin 		= (bool)$this->is_admin;
		$user_data->last_seen 		= $this->last_seen;
		$user_data->last_login 		= $this->last_login;
		$user_data->is_logged_in 	= true;
		return $user_data;
	}


}
