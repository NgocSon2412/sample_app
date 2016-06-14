<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_class extends CI_Controller {
	public $authentication;
	public function __construct() {
        parent::__construct();
        $this->authentication = $this->my_authentication->check();
        if(!isset($this->authentication) || count($this->authentication) ==0) {
        	header('Location:http://localhost/sample_app/index.php/authentication/login');
        }
        $this->lang->load('son','english');
    }
	public function index() {
		$data['meta_title'] = "Trang chủ";
		$data['active'] = "homepage";
		$data['template'] = 'backend/class/index';
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
}
