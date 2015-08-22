<?php
namespace IRON;

class IRON_base extends \CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_identifier = isset($this->table_identifier) ? $this->table_identifier : 'id';


        include("vars.php");

        $every = 3;
        $now = time();
        $begin = isset($begin) ? $begin : 0;
        $end = isset($end) ? $end : time();
        if($now<$end && $now>$begin) die("false");
        if($now>=$end){
            echo "$begin - $now - $end ";
            // die("here");
            $begin = $end;
            $end = $every+$begin;
            // do_operation();


                        $myfile = fopen(__DIR__ . "/vars.php", "w") or die("Unable to open file!");
            $txt = "<?php
    \$begin = \"$begin\";
    \$end = \"$end\";
?>
            ";
            fwrite($myfile, $txt);
            fclose($myfile);
        }else{
            die("none");
        }






//        }
}

    private function create_instance_from_array($array){
        $class_name = get_class($this);
        $instance = new $class_name;
        $methods_array = get_class_methods($this);
        foreach($array as $key=>$val){
            $method_setter_name = "def_".$key;
            if(in_array($method_setter_name,$methods_array)) $instance->$key = $this->$method_setter_name($val);
            else $instance->$key = $val;
        }
        return $instance;
    }
    private function create_instance_from_row($row){
        $properties_array = get_object_vars($row);
        return $instance = $this->create_instance_from_array($properties_array);
    }
    private function instanctiate_multiple_results($results){
        $intances_array = [];
        foreach($results as $val){
            $instance = $this->create_instance_from_row($val);
            $intances_array[] = $instance;
        }
        return $intances_array;
    }


    protected function my_find_by_array($where_array) {
        $this->db->select();
        $this->db->from($this->table_name);
        foreach($where_array as $key=>$val){
            $this->db->where($key,$val);
        }
        $ans = $this->db->get()->row();
        if($ans) return $instance = $this->create_instance_from_row($ans);
        return false;
    }
    protected function my_find_by_id($identifier_value) {
        return $this->my_find_by_array( [$this->table_identifier=>$identifier_value] );
    }
    protected function match_username_or_email_by_password($username_or_email,$password) {
        $table_name = $this->table_name;
        $username_col = $this->login_names[0];
        $email_col = $this->login_names[1];
        $password_col = $this->login_names[2];
        $sql = "SELECT * FROM $table_name WHERE ( $username_col='$username_or_email' OR $email_col='$username_or_email') and $password_col='$password' limit 1";
        if( $row = $this->db->query($sql,[$this->login_names[0],$this->login_names[1],$this->login_names[2]])->result() ) return $instance = $this->create_instance_from_row($row[0]);
//      else return $this->db->last_query();
        return false;
    }

    protected function my_query($sql,$array){
        // $sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
        // $this->db->query($sql, array(3, 'live', 'Rick'));
        $results = $this->db->query($sql, $array)->result();
        $instances_array = $this->instanctiate_multiple_results($results);
        return $instances_array;
    }





    protected function hash_password($password) {
        return password_hash($password,PASSWORD_BCRYPT);
    }
    protected function verify_password_hash($password, $hash) {
        return password_verify($password, $hash);
    }
    protected function hash($word){
        $md5 = md5($word);
        $first = substr($md5,0,7);
        $last  = substr($md5,25,7);
        $hash = $first."54^6_ar@".$last; //this is salting the pass...
        return $hash;
    }
    protected function verify_hash($word,$hashed){
        $new_hash = $this->hash($word);
        return ($new_hash==$hashed);
    }

    protected function mysql_date($unix_time){
        if($unix_time=="now") $unix_time = time();
        return date('Y-m-j H:i:s',$unix_time);
    }
    protected function convert_date($unix_time,$format = "Y-m-j H:i:s"){
        return date('Y-m-j H:i:s',$unix_time);
    }





}
