<?php
namespace IRON;

class IRON_collection{

    private $instances_array;

    public function __construct($instances_array){
        $this->instances_array = $instances_array;
    }

    public function get(){
        return $this->get_obj();
    }

    public function get_obj(){
        return $this->instances_array;
    }
    public function get_array($key=false){
        $return_array = [];
        foreach($this->instances_array as $val){
            $properties_array = get_object_vars($val);
            unset($properties_array['login_names']);
            unset($properties_array['table_name']);
            unset($properties_array['table_identifier']);
            if($key) $return_array[$val->$key] = $properties_array;
            else $return_array[] = $properties_array;
        }
        return $return_array;
    }

    public function i_list( $field_name , $unique=true ){
        $return_array = [];
        foreach($this->instances_array as $val){
            $return_array[] = $val->$field_name;
        }
        return ($unique) ? array_unique($return_array) : $return_array ;
    }



}