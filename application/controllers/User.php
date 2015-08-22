<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('BaseController.php');


function err($x){
	echo "<pre>";
	var_export($x);
	echo "</pre><hr>";
}

class User extends BaseController {

	public function __construct() {
		parent::__construct();
		$this->load->library(['session']);
		$this->load->helper(['url']);
		$this->load->model('user_model');
	}
	

	public function users_control() {
		$data['all_users'] = $this->user_model->my_get_table();
		$this->_view_layout("user/users_view/users_view",$data);
	}
	
	public function register() {
		$data = new stdClass();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]',array('is_unique' => 'This email already exists in the database. <a href="forgot-pass" class="btn btn-xs btn-primary">have you forgot your password</a> ?'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		if ($this->form_validation->run() == false) {
			$this->_view_layout("user/register/register",$data);
		} else {
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			if ($user_id = $this->user_model->create_user($username, $email, $password)) {
				$this->_send_confirmation_msg($user_id,$email);
				$this->_view_layout("user/register/register_success",$data);
			} else {
				$data->errors[] = 'There was a problem creating your new account. Please try again.';	
				$this->_view_layout("user/register/register",$data);				
			}
		}
	}
		
	public function login() {
		$data = new stdClass();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == false) {
			$this->_view_layout("user/login/login",$data);				
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if ($user = $this->user_model->resolve_user_login($username, $password)) {
				if(!$user->is_confirmed){
					$this->_send_confirmation_msg($user->id,$user->email);
					$data->errors[] = 'Please Confirm this account from your email. we sent a new confirmation message to your email.';
				} 
				if($user->is_deleted) $data->errors[] = 'this user has been deleted. please contact the adminstration.';
				if($user->is_locked) $data->errors[] = 'this user is locked by the admin. please contact the adminstration';
				if(empty($data->errors)){				
					$user->approve_login();
					$_SESSION['user_data'] = $user->prepare_user_data();
					$this->_view_layout("user/login/login_success",$data);					
				}else $this->_view_layout("user/login/login",$data);			
			} else {
				$data->errors[] = 'Wrong username or password.';
				$this->_view_layout("user/login/login",$data);								
			}
		}
	}
	
	public function logout() {
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		$this->_view_layout("user/logout/logout_success");								
	}

	public function confirm_account($id,$hashed_email){
		$this->load->helper('security');
		$user = $this->user_model->my_find($id);
		if(do_hash($user->email) == $hashed_email){
			$user->my_set_to('is_confirmed',true);
			redirect("login");
		}
		else die("error in confirmation");
	}

	public function forgot_password(){
		$data = new stdClass();
		$this->load->helper('form');
		$email = $this->input->post('email');
		if($email){
			$user = $this->user_model->my_where(['email'=>$email]);
			$new_password = $user->set_random_password();
			die("your new password is: ".$new_password);
		}else{
			$this->_view_layout("user/forgot-password",$data);								
		}
	}


	public function testing(){
//		$sql = "SELECT * FROM users WHERE id > ? AND is_confirmed = ? limit 0,5";
//		$array = [9,1];
//		$res = $this->user_model->my_query($sql,$array);
		$obj = $this->user_model;


//		$res1 = $obj->i_find('9');
//		err($res1);
//		$res2 = $obj->i_find('username','ahmed3');
//		err($res2);
//		$res2 = $obj->i_find(['username'=>'ahmed3',"email"=>"courtaks3@yahoo.com"]);
//		err($res2);
//		$res4 = $obj->i_login_check("courtaks3@yahoo.com","123");
//		err($res4);
//		$obj->i_find('username','ahmedbadawy23')->i_update('password','888');
		$res5 = $obj->i_get_table()->get_array('email');
		err($res5);

		die;
	}



/*********************************************************************
	Helpers
**********************************************************************/
	private function _send_confirmation_msg($id,$email){
		$this->load->library('email');
		$this->load->helper('security');
		$hashed_email = do_hash($email);
		$msg = 'activate your account at: ahmed-badawy.com /n
			<a href="'.base_url("/confirm-account/$id/$hashed_email").'" style="color:red;font-size:20px;">Activate My Account</a>
		';
		echo("<div class='container'><pre> <h3>this is the confirmation email: </h3> $msg</pre> </div>");

		$this->email->from('admin@ahmed-badawy.com', 'Ahmed Badawy');
		$this->email->to($email);
		$this->email->subject("Account Activation Request");
		$this->email->message($msg);
		$this->email->send();
	}

	

}
