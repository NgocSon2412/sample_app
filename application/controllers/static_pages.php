<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Static_pages extends CI_Controller {
	public $authentication;
	public function __construct() {
        parent::__construct();
        $this->authentication = $this->my_authentication->check();
        if(!isset($this->authentication) || count($this->authentication) ==0) {
        	header('Location:http://localhost/sample_app/index.php/users/login');
        }
        $this->lang->load('son','english');
    }
	public function index($page = 1) {
		$this->load->library('pagination');
		// config giao dien phan trang
		$config = $this->_pagination();		
		$this->pagination->initialize($config); 
		$data['list_pagination'] = $this->pagination->create_links();
		$total_page = ceil($config['total_rows']/$config['per_page']); //ceil lấy phần nguyên
		$page = ($page > $total_page)? $total_page : $page ;
		$page = ($page < 1)? 1 : $page ;
		$page = $page-1;
        if ($config['per_page'] > 0) {
            $data['list_microposts'] =$microposts = $this->Model_micropost->view_micropost_all(($page*$config['per_page']),$config['per_page'],$this->authentication['id']);
        }
        foreach ($microposts as $key => $value) {
            $data['list_comments'][] = $this->Model_comment->view_comment($value['micropost_id']);        
        }
        // print_r($data['list_comments']); die();
		$data['meta_title'] = "Sample App";
		$data['active'] = "homepage";
		$data['template'] = 'backend/static_page/index';
		$data['authentication'] = $this->authentication;
		// $data['count'] = $this->Model_micropost->total();
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function _pagination() {
        $config['full_tag_open'] = '<ul class="pagination" style ="margin: 0 0;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&gt';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a>';
        $config['cur_tag_close'] = '</li></a>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = 'http://localhost/sample_app/index.php/static_pages/index';
        $config['total_rows'] = $this->Model_micropost->total_all($this->authentication['id']); 
        $config['per_page'] = 15;
        return $config;         
    }
}
