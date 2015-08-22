<?php
namespace IRON;

require("IRON_base.php");
require("IRON_collection.php");
class IRON_init extends IRON_BASE {

    public $login_names = ['username','email','password'];



//find(15)
//find("email","courtaks@yahoo.com")
//find([email=>courtaks@yahoo.com])
//find([user=>ahmed , pass=>123])
    public function i_find($pram1 = false,$pram2 = false) {
        if ($pram1 && $pram2) return $this->my_find_by_array([$pram1 => $pram2]);
        if(!$pram2) {
            if (is_array($pram1) && !empty($pram1)) return $this->my_find_by_array($pram1);
            if ($pram1 && !$pram2) return $this->my_find_by_id($pram1);
        }
    }

//i_login_check(username_or_email,password)
    public function i_login_check($username_or_email,$password,$hash=false){
        return ($hash) ?
                $this->match_username_or_email_by_password($username_or_email,$this->hash($password))
                :$this->match_username_or_email_by_password($username_or_email,$password);
    }


//i_query();
    public function i_query($sql,$array=[]){
        // $sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
        // $this->db->query($sql, [3, 'live', 'Rick']);
        $instances_array = $this->my_query($sql,$array);
        $collection_obj = new IRON_collection($instances_array);
        return $collection_obj;
    }
    public function i_get_table(){
        $sql = "SELECT * FROM ".$this->table_name." ORDER BY ".$this->table_identifier." DESC";
        return $this->i_query($sql);
    }
    public function i_create($create_array) {
        return ($this->db->insert($this->table_name,$create_array)) ? $this->db->insert_id() : false ;
    }

    public function i_cols_names($return_as="object"){
        $sql = "SHOW COLUMNS FROM users";
        $instances_array = $this->db->query($sql,[])->result();
        $collection_obj = new IRON_collection($instances_array);
        return $collection_obj;
    }


    /*********************************************************************
    On Single instance methods
     **********************************************************************/
    public function i_delete() {
        $id_name = $this->table_identifier;
        $this->db->where($id_name,$this->$id_name);
        return $this->db->delete($this->table_name);
    }
    public function i_update($pram1,$pram2=false) {
        $update_array = ($pram1 && $pram2) ? [$pram1=>$pram2] : $pram1;
        $id_name = $this->table_identifier;
        $this->db->where($id_name,$this->$id_name);
        return $this->db->update($this->table_name, $update_array);
    }
    public function i_inc($field_name,$increment_by = 1) {
        return $this->i_update([ $field_name => $this->$field_name+$increment_by ]);
    }
    public function i_dec($field_name,$increment_by = 1) {
        return $this->i_update([ $field_name => $this->$field_name-$increment_by ]);
    }
    public function i_set_to($field_name,$set_to) {
        return $this->i_update([$field_name=>$set_to]);
    }
    /**********************************************************************/


}