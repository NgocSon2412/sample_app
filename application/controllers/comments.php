<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Comments extends CI_Controller {
	public $authentication;
	public function __construct() {
		parent::__construct();
		$this->authentication = $this->my_authentication->check();
	}
	public function create() {
		if ($this->input->post('comment')) {
			$redirect =$this->input->post('method');
			$post_id =$this->input->post('post_id');
			$fag = $this->Model_comment->create($this->authentication['id'],$post_id);
			redirect ($redirect);	
		}
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function delete($id = 0) {
		$data['comment'] = $comment = $this->Model_comment->get($id);
		$data['post'] = $post = $this->Model_micropost->get($comment['post_id']);
		if (($this->authentication['id'] == $comment['user_id'])||($this->authentication['id'] == $post['user_id'])) {
			$redirect = $this->input->get('redirect');
			$redirect = (!empty($redirect))? base64_decode($redirect): '';
			if (!isset($data['comment']) || count($data['comment']) == 0) {
				$fag = array(
	                'type' => 'error',
	                'message' => 'comment không tồn tại!',
	            );
	            $this->session->set_flashdata('message_flashdata',$fag);
	            redirect($redirect);
	            die;
	        }
	        // xác nhận xóa
			$fag = $this->Model_comment->delete($id);
			$this->session->set_flashdata('message_flashdata',$fag);
			redirect($redirect);	
		}else {
			header('Location:http://localhost/sample_app/index.php/static_pages');
		}

	}
}
