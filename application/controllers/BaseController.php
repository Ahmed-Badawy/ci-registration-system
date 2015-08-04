<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	protected function _view_layout($view,$data=[]){
		$this->load->view('header');
		$this->load->view($view, $data);
		$this->load->view('footer');
		// die;
	}

	
}
