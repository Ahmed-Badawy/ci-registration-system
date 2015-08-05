<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->table_identifier = isset($this->table_identifier) ? $this->table_identifier : 'id';
	}
	protected function hash_password($password) {
		return password_hash($password, PASSWORD_BCRYPT);
	}
	protected function verify_password_hash($password, $hash) {
		return password_verify($password, $hash);
	}
	private function create_instance_from_array($array){
		$class_name = get_class($this);
		$instance = new $class_name;
		foreach($array as $key=>$val){
			$instance->$key = $val;
		}
		return $instance;
	}	
	private function create_instance_from_row($row){
		$properties_array = get_object_vars($row);
		return $this->create_instance_from_array($properties_array);
	}
	private function instanctiate_multiple_results($results){
		$intances_array = [];
		foreach($results as $val){
			$instance = $this->create_instance_from_row($val);
			$intances_array[] = $instance;
		}
		return $intances_array;
	}
	protected function mysql_date($unix_time){
		if($unix_time=="now") $unix_time = time();
		return date('Y-m-j H:i:s',$unix_time);
	}
	protected function convert_date($unix_time,$format = "Y-m-j H:i:s"){
		return date('Y-m-j H:i:s',$unix_time);
	}




	public function my_get_table(){
		$sql = "SELECT * FROM ".$this->table_name;
		return $this->my_query($sql,[]);
	}
	public function my_query($sql,$array){
		// $sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
		// $this->db->query($sql, array(3, 'live', 'Rick'));
		$results = $this->db->query($sql, $array)->result();		
		$instances_array = $this->instanctiate_multiple_results($results);
		return $instances_array;
	}

	public function my_find($identifier_value) {
		return $this->my_where( [$this->table_identifier=>$identifier_value] );
	}	
	public function my_where($where_array) {
		$this->db->select();
		$this->db->from($this->table_name);
		foreach($where_array as $key=>$val){
			$this->db->where($key,$val);		
		}
		$ans = $this->db->get()->row();
		if($ans) return $instance = $this->create_instance_from_row($ans);
		return false;
	}	
	public function my_create($create_array) {
		return ($this->db->insert($this->table_name,$create_array)) ? $this->db->insert_id() : false ;
	}	
	public function my_update_by_id($id,$update_array) {
		$id_name = $this->table_identifier;
		$this->db->where($id_name,$id);
		return $this->db->update($this->table_name, $update_array);
	}
	public function my_delete_by_id($id) {
		$id_name = $this->table_identifier;
		$this->db->where($id_name,$id);
		return $this->db->delete($this->table_name);
	}	
	public function my_set_to_by_id($id,$field_name,$set_to) {
		return $this->my_update_id($id,[$field_name=>$set_to]);
	}

/*********************************************************************
On instance methods
**********************************************************************/
	public function my_delete() {
		$id_name = $this->table_identifier;
		$this->db->where($id_name,$this->$id_name);
		return $this->db->delete($this->table_name);
	}	
	public function my_update($update_array) {
		$id_name = $this->table_identifier;
		$this->db->where($id_name,$this->$id_name);
		return $this->db->update($this->table_name, $update_array);
	}		
	public function my_increment($field_name,$increment_by = 1) {
		return $this->my_update([$field_name=>$this->$filed+$increment_by]);
	}
	public function my_decrement($field_name,$increment_by = 1) {
		return $this->my_update([$field_name=>$this->$filed-$increment_by]);
	}
	public function my_set_to($field_name,$set_to) {
		return $this->my_update([$field_name=>$set_to]);
	}
	public function my_save(){
		$id_name = $this->table_identifier;
		if($this->$id_name && $this->id_name>0){
			//update model
		}else{
			//create model
		}
	}
/**********************************************************************/


/*********************************************************************
Method Helpers
**********************************************************************/
	public function my_list($intances_array,$field_name,$unique=true){
		$list = [];
		foreach($instances_array as $val){
			$list[] = $val->$field_name;
		}
		return ($unique) ? array_unique($list) : $list;
	}
/**********************************************************************/



}
