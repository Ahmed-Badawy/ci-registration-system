<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('BaseController.php');

class User extends BaseController {

	public function __construct() {
		parent::__construct();
		$this->load->library(['session']);
		$this->load->helper(['url']);
		$this->load->model('user_model');
	}
	

	public function users_control() {
		$data['all_users'] = $this->user_model->get_all_users();
		$this->_view_layout("user/users_view/users_view",$data);
	}
	
	public function register() {
		$data = new stdClass();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]',array('is_unique' => 'This email already exists in the database. <a href="forget-pass" class="btn btn-xs btn-primary">have you forgot your password</a> ?'));
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
					$this->_send_confirmation_msg($user->email);
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
		$user = $this->user_model->get_user_by_id($id);
		if(do_hash($user->email) == $hashed_email){
			$user->confirm_user();
			redirect("login");
		}
		else die("not confirmed");
	}

	public function forgot_password(){
		die("not done yet");
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
		echo("<h3>this is the confirmation email: </h3> $msg <hr><hr><hr>");

		$this->email->from('admin@ahmed-badawy.com', 'Ahmed Badawy');
		$this->email->to($email);
		$this->email->subject("Account Activation Request");
		$this->email->message($msg);
		$this->email->send();
	}

	

}
