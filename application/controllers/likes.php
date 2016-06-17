<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Likes extends CI_Controller {
	public $authentication;
	public function __construct() {
		parent::__construct();
		$this->authentication = $this->my_authentication->check();
	}
	public function create() {
		if ($this->input->post('like')) {
			$post_id = $this->input->post('post_id');
			$this->Model_like->like($this->authentication['id'],$post_id);
			$redirect = $this->input->post('method');
			redirect($redirect);	
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function delete($id = 0) {
		if ($this->input->post('unlike')) {
			$post_id = $this->input->post('post_id');
			$this->Model_like->unlike($this->authentication['id'],$post_id);
			$redirect = $this->input->post('method');
			redirect($redirect);
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
}
