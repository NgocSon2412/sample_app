<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Authentication extends CI_Controller {
	public $authentication;
	public function __construct() {
		parent::__construct();
		$this->authentication = $this->my_authentication->check();
			}
	public function login() {
		if(isset($this->authentication) && count($this->authentication) > 0) {
        	header('Location: http://localhost/sample_app/index.php/admin_class');
        }
		$this->config->set_item('sess_expiration', 0);
		if ($this->input->post('login')) {
			$this->form_validation->set_rules('password','Mật khẩu','callback__authentication' );
			$this->form_validation->set_error_delimiters('<div style="color:red">','</div>');
			if($this->form_validation->run()) {
				$email =  $this->input->post('email');
				$user = $this->Model_user->get(array('email' =>$email));
				$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
				$last_login = gmdate('Y-m-d H:i:s',time() + 7*3600);
				$flag = $this->Model_user->update(array('last_login' => $last_login,'http_user_agent' => $http_user_agent),array('email' => $email));
				$user['http_user_agent'] = $http_user_agent;
				if($flag['type'] = 'seccessful') {
					$remember = (int)$this->input->post('remember');
					$user['http_user_agent'] = $http_user_agent;
					if($remember == 0 ) {
					// $_SESSION['remember'] = json_encode($user);
						echo 'remember =0';
						$_SESSION['authentication'] = json_encode($user);
					} else if ( $remember >= 1) {
						$this->session->set_userdata('authentication',json_encode($user));
						echo 'remember=1';
					}
					$fag1 =  array(
		                'type' => 'seccessful',
		                'message' => 'Bạn đăng nhập thành công!',
		            );
					$this->session->set_flashdata('message_flashdata',$fag1);
					header('Location:http://localhost/sample_app/index.php/admin_class');		
				}
					
			}
		}
		$data['meta_title'] = "Đăng nhập";
		$data['active'] = "login";
		$data['template'] = 'backend/user/login';
		$this->load->view('backend/layout/home1',isset($data)? $data:NULL);
	}
	public function logout() {
		if(!isset($this->authentication) && count($this->authentication) ==0) {
			header('Location:http://localhost/sample_app/index.php/admin_class');
        }
        if(isset($_SESSION['authentication'])) {
				unset($_SESSION['authentication']);
			}
        $this->session->unset_userdata('authentication');
        echo "dsađasadá";
        header('Location:http://localhost/sample_app/index.php/admin_class');
	}
	public function sign_up() {
		if ($this->input->post('sign-up')) {
			$this->form_validation->set_rules('email','email','callback__checkemail' );
			$this->form_validation->set_rules('password','password','min_length[6]' );
			$this->form_validation->set_rules('password_confirmation','password_confirmation','min_length[6]|callback__checkpassword' );
			$this->form_validation->set_error_delimiters('<div style="color:red">','</div>');
			if($this->form_validation->run()) {
				$fag = $this->Model_user->add_user();
				$email =  $this->input->post('email');
				$user = $this->Model_user->get(array('email' =>$email));
				$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
				$last_login = gmdate('Y-m-d H:i:s',time() + 7*3600);
				$flag = $this->Model_user->update(array('last_login' => $last_login,'http_user_agent' => $http_user_agent),array('email' => $email));
				$user['http_user_agent'] = $http_user_agent;
				$_SESSION['authentication'] = json_encode($user);
				$this->session->set_flashdata('message_flashdata',$fag);
				header('Location:http://localhost/sample_app/index.php/admin_class');		
			}
		}

		$data['meta_title'] = "Sign Up";
		$data['active'] = "sign_up";	
		$data['template'] = 'backend/user/sign_up';
		$this->load->view('backend/layout/home1',isset($data)? $data:NULL);
	}
	public function edit($id = 0) {
		if(!isset($this->authentication)) {
			$redirect = 'authentication/login';
			$fag1 =  array(
		                'type' => 'error',
		                'message' => 'Vui lòng đăng nhập trước khi sửa thông tin!',
		            );
			$this->session->set_flashdata('message_flashdata',$fag1);
			header('Location: http://localhost/sample_app/index.php/'. $redirect);	
		}
		if ($this->input->post('edit')) {
			$this->form_validation->set_rules('email','email' );
			$this->form_validation->set_rules('password','password','min_length[6]' );
			$this->form_validation->set_rules('password_confirmation','password_confirmation','min_length[6]|callback__checkpassword' );
			$this->form_validation->set_error_delimiters('<div style="color:red">','</div>');
			if($this->form_validation->run()) {
				$fag = $this->Model_user->edit_user($this->authentication['id']);
				$this->session->set_flashdata('message_flashdata',$fag);
				$redirect = 'admin_class';
				header('Location: http://localhost/sample_app/index.php/'. $redirect);	
			}
		}

		$data['meta_title'] = "Edit";
		$data['active'] = "Edit";
		$data['authentication'] = $this->authentication;
		$data['template'] = 'backend/user/edit';
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function forgot_password() {
		if ($this->input->post('forgot-password')) {
			$this->form_validation->set_rules('email','email','callback__forgot_password' );
			$this->form_validation->set_rules('password','password','min_length[6]' );
			$this->form_validation->set_rules('password_confirmation','password_confirmation','min_length[6]|callback__checkpassword' );
			$this->form_validation->set_error_delimiters('<div style="color:red">','</div>');
			if($this->form_validation->run()) {
				$fag = $this->Model_user->forgot_password();
				$this->session->set_flashdata('message_flashdata',$fag);
				$redirect = 'admin_class';
				header('Location: http://localhost/sample_app/index.php/'. $redirect);	
			}
		}
		$data['meta_title'] = "Forgot password";
		$data['active'] = "Forgot password";
		$data['authentication'] = $this->authentication;
		$data['template'] = 'backend/user/forgot_password';
		$this->load->view('backend/layout/home1',isset($data)? $data:NULL);
	}
	public function _forgot_password($email = '') {
		$user = $this->Model_user->get(array('email' => $email));
		if(!isset($user) && count($user) == 0) {
			$this->form_validation->set_message('_forgot_password','Email không tồn tại');
			return FALSE;	
		}
		return TRUE;	
	}
	public function _checkpassword ($password_confirmation = '') {
		$password = $this->input->post('password');
		if($password != $password_confirmation) {
			$this->form_validation->set_message('_checkpassword',"Password không trùng nhau");
			return FALSE;
		}
		return TRUE;
	}
	public function _checkemail ($email = '') {
		$user = $this->Model_user->get(array('email' => $email));
		if(isset($user) && count($user)) {
			$this->form_validation->set_message('_checkemail','Tên email đã tồn tại');
			return FALSE;	
		}
		return TRUE;	
	}
	public function _authentication ($password = '') {
		$email = $this->input->post('email');
		$count = $this->Model_user->total(array('email' => $email));
		if($count == 0) {
			$this->form_validation->set_message('_authentication','Tài khoản không tồn tại');
			return FALSE;
		}
		$user = $this->Model_user->get(array('email' => $email));
		if($user['password'] != md5($password)) {
			$this->form_validation->set_message('_authentication','Mật khẩu không đúng');
			return FALSE;
		}
		return TRUE;
	}
	
}
