<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Relationships extends CI_Controller {
	public $authentication;
	public function __construct() {
		parent::__construct();
		$this->authentication = $this->my_authentication->check();
	}
	public function create() {
		if ($this->input->post('post')) {
			$fag = $this->Model_micropost->create($this->authentication['id']);
			$this->session->set_flashdata('message_flashdata',$fag);
			$redirect = 'static_pages/index';
			header('Location: http://localhost/sample_app/index.php/'. $redirect);	
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function delete($id = 0) {
		//kiểm tra id 
		// if(isset($this->authentication) && count($this->authentication) && in_array($this->uri->segments[1].'/'.$this->uri->segments[2],$this->authentication['permissions']) == FALSE) {
		// 	$fag = array(
  //               'type' => 'error',
  //               'message' => 'Bạn không có quyền truy cập vào trang này!',
  //           );
  //           $this->session->set_flashdata('message_flashdata',$fag);
  //           header('Location:http://localhost/demo/index.php/admin_class');	
		// }
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
	}
}
