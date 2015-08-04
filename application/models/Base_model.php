<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	protected function hash_password($password) {
		return password_hash($password, PASSWORD_BCRYPT);
	}
	
	protected function verify_password_hash($password, $hash) {
		return password_verify($password, $hash);
	}

	protected function create_instance($row){
		$properties_array = get_object_vars($row);
		foreach($properties_array as $key=>$val){
			$this->$key = $val;
		}
	}

	protected function find($identifier_value) {
		$table_identifier = isset($this->table_identifier) ? $this->table_identifier : 'id';
		$this->db->select();
		$this->db->from($this->table_name);
		$this->db->where($table_identifier,$identifier_value);
		$ans = $this->db->get()->row();
		return $ans;
	}

	

}
