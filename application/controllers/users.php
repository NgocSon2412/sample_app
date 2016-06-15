<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Users extends CI_Controller {
	public $authentication;
	public function __construct() {
		parent::__construct();
		$this->authentication = $this->my_authentication->check();
	}
	public function show($id =1 ,$page = 1){	
		$id = (int)$id;
		$this->load->library('pagination');
		// config giao dien phan trang
		$config = $this->_pagination($id);		
		$this->pagination->initialize($config); 
		$data['list_pagination'] = $this->pagination->create_links();
		$total_page = ceil($config['total_rows']/$config['per_page']); //ceil lấy phần nguyên
		$page = ($page > $total_page)? $total_page : $page ;
		$page = ($page < 1)? 1 : $page ;
		$page = $page-1;
		if ($config['per_page'] > 0) {
			$data['list_microposts'] =$fag = $this->Model_micropost->view_micropost(($page*$config['per_page']),$config['per_page'],$id);
		}
		$data['count'] = $this->Model_micropost->total($id);
		$data['user'] = $user = $this->Model_user->get(array('id'=>$id));
		if(!isset($data['user']) && count($data['user']) ==0) {
			header('Location:http://localhost/sample_app/index.php/static_pages');	
		}
		$data['meta_title'] = $user['name']. '| Sample App';
		$data['active'] = "profile";
		$data['template'] = 'backend/user/show';
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}
	public function show_all_user($page = 1){	
		$this->load->library('pagination');
		// config giao dien phan trang
		$config = $this->_pagination1();		
		$this->pagination->initialize($config); 
		$data['list_pagination'] = $this->pagination->create_links();
		$total_page = ceil($config['total_rows']/$config['per_page']); //ceil lấy phần nguyên
		$page = ($page > $total_page)? $total_page : $page ;
		$page = ($page < 1)? 1 : $page ;
		$page = $page-1;
		if ($config['per_page'] > 0) {
			$data['list_users'] =$fag = $this->Model_user->index(($page*$config['per_page']),$config['per_page']);
		}
		$data['count'] = $this->Model_user->total();
		$data['meta_title'] = "All user";
		$data['active'] = "all_user";
		$data['template'] = 'backend/user/index';
		$data['authentication'] = $this->authentication;
		$this->load->view('backend/layout/home',isset($data)? $data:NULL);
	}		
	public function login() {
		if(isset($this->authentication) && count($this->authentication) > 0) {
        	header('Location: http://localhost/sample_app/index.php/static_pages');
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
					header('Location:http://localhost/sample_app/index.php/static_pages');		
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
			header('Location:http://localhost/sample_app/index.php/static_pages');
        }
        if(isset($_SESSION['authentication'])) {
				unset($_SESSION['authentication']);
			}
        $this->session->unset_userdata('authentication');
        echo "dsađasadá";
        header('Location:http://localhost/sample_app/index.php/static_pages');
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
				header('Location:http://localhost/sample_app/index.php/static_pages');		
			}
		}

		$data['meta_title'] = "Sign Up";
		$data['active'] = "sign_up";	
		$data['template'] = 'backend/user/sign_up';
		$this->load->view('backend/layout/home1',isset($data)? $data:NULL);
	}
	public function delete($id = 0) {
		if (($this->authentication['role_id'] == 1) || ($this->authentication['id'] == $id)) {
			$redirect = $this->input->get('redirect');
			$redirect = (!empty($redirect))? base64_decode($redirect): '';
			$data['user'] = $user = $this->Model_user->get(array('id'=>$id));
			if (!isset($data['user']) || count($data['user']) == 0) {
				$fag = array(
	                'type' => 'error',
	                'message' => 'Lớp không tồn tại!',
	            );
	            $this->session->set_flashdata('message_flashdata',$fag);
	            redirect($redirect);
	            die;
	        }
	        // xác nhận xóa
			$fag = $this->Model_user->delete($id);
			$this->session->set_flashdata('message_flashdata',$fag);
			redirect($redirect);	
		} else {
			header('http://localhost/sample_app/index.php/users/show_all_user');	
		}		
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
				$redirect = 'static_pages';
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
				$redirect = 'static_pages';
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
	public function _pagination($id) {
		$id = (int)$id;
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
        $config['base_url'] = 'http://localhost/sample_app/index.php/users/show/'. $id . '/';
        $config['total_rows'] = $this->Model_micropost->total($id);
        $config['per_page'] = 15;
        return $config;         
    }
    public function _pagination1() {
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
        $config['base_url'] = 'http://localhost/sample_app/index.php/users/show_all_user/';
        $config['total_rows'] = $this->Model_user->total();
        $config['per_page'] = 15;
        return $config;         
    }
}
