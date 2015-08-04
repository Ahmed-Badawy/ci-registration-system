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
			'created_at' => date('Y-m-j H:i:s'),
			'updated_at' => date('Y-m-j H:i:s'),
		);
		return ($this->db->insert($this->table_name,$data)) ? $this->db->insert_id() : false ;
	}

	public function get_user_by_id($id){
		$user = $this->find($id);
		$this->create_instance($user);
		return $this;
	}
	
	public function resolve_user_login($username, $password) {
		$this->db->select();
		$this->db->from($this->table_name);
		$this->db->where('username', $username);
		$user = $this->db->get()->row();
		if($user && $this->verify_password_hash($password, $user->password)){
			$this->create_instance($user);
			return $this;			
		} 
		else return false;
	}
	
	public function approve_login() {
		$update_data = array(
			'last_seen' => date('Y-m-j H:i:s'),
			'last_login' => date('Y-m-j H:i:s'),
		);
		$this->db->where($this->table_identifier,$this->id);
		$this->db->update($this->table_name,$update_data);
	}

	public function confirm_user(){
		$update_data = array(
			'is_confirmed' => 1,
		);
		$this->db->where($this->table_identifier,$this->id);
		$this->db->update($this->table_name,$update_data);	
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

	public function get_all_users(){
		return $this->db->get($this->table_name)->result();
	}


}
