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
		// if(isset($this->authentication) && count($this->authentication) && in_array($this->uri->segments[1].'/'.$this->uri->segments[2],$this->authentication['permissions']) == FALSE) {
		// 	$fag = array(
  //               'type' => 'error',
  //               'message' => 'Bạn không có quyền truy cập vào trang này!',
  //           );
  //           $this->session->set_flashdata('message_flashdata',$fag);
  //           header('Location:http://localhost/demo/index.php/admin_class');	
		// }

		if ($this->input->post('post')) {
			$fag = $this->Model_micropost->create($this->authentication['id']);
			$this->session->set_flashdata('message_flashdata',$fag);
			$redirect = 'static_pages/index';
			header('Location: http://localhost/sample_app/index.php/'. $redirect);	
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
}
