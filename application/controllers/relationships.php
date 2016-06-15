<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Relationships extends CI_Controller {
	public $authentication;
	public function __construct() {
		parent::__construct();
		$this->authentication = $this->my_authentication->check();
	}
	public function create() {
		if ($this->input->post('follow')) {
			$other_user_id = $this->input->post('method');
			$this->Model_relationship->follow($this->authentication['id'],$other_user_id);
			$redirect = 'users/show/'.$other_user_id;
			header('Location: http://localhost/sample_app/index.php/'. $redirect);	
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function delete($id = 0) {
		if ($this->input->post('unfollow')) {
			$other_user_id = $this->input->post('method');
			$this->Model_relationship->unfollow($this->authentication['id'],$other_user_id);
			$redirect = 'users/show/'.$other_user_id;
			header('Location: http://localhost/sample_app/index.php/'. $redirect);	
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
}
