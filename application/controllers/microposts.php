<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Microposts extends CI_Controller {
	public $authentication;
	public function __construct() {
		parent::__construct();
		$this->authentication = $this->my_authentication->check();
	}
	public function index() {
		$data['meta_title'] = "Trang chủ";
		$data['active'] = "homepage";
		$data['template'] = 'backend/static_pages/index';
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function create() {
		if ($this->input->post('post')) {
			$redirect =$this->input->post('method');
			$fag = $this->Model_micropost->create($this->authentication['id']);
			$this->session->set_flashdata('message_flashdata',$fag);
			redirect ($redirect);	
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function delete($id = 0) {
		$data['post'] = $post = $this->Model_micropost->get($id);
		if ($this->authentication['id'] == $post['user_id']) {
			$redirect = $this->input->get('redirect');
			$redirect = (!empty($redirect))? base64_decode($redirect): '';
			$data['post'] = $post = $this->Model_micropost->get($id);
			if (!isset($data['post']) || count($data['post']) == 0) {
				$fag = array(
	                'type' => 'error',
	                'message' => 'Lớp không tồn tại!',
	            );
	            $this->session->set_flashdata('message_flashdata',$fag);
	            redirect($redirect);
	            die;
	        }
	        // xác nhận xóa
			$fag = $this->Model_micropost->delete($id);
			$this->session->set_flashdata('message_flashdata',$fag);
			redirect($redirect);	
		}else {
			header('Location:http://localhost/sample_app/index.php/static_pages');
		}

	}
}
