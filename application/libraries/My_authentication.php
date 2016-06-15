<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class My_authentication {
  public $CI;
  public function __construct() {
    $this->CI =& get_instance();
  }
  public function check() {
    // SESSION
    $remember = 0;
    if(isset($_SESSION['authentication']) && !empty($_SESSION['authentication'])){
      $authentication = $_SESSION['authentication'];
    } else {
      // COOKIE
      $authentication = $this->CI->session->userdata('authentication');
      $remember = 1; 
    }  
    if(!isset($authentication) || empty($authentication)) {
      return NULL;
    }
    $authentication = json_decode($authentication,TRUE);
    $user = $this->CI->Model_user->get(array(
      'email' => $authentication['email'],
      'password' => $authentication['password'],
      'http_user_agent' => $authentication['http_user_agent']
    ));
    if(!isset($user) || count($user) == 0) {
      if ($remember == 0) {
        unset($_SESSION['authentication']);
      } else {
        $this->CI->session->unset_userdata('authentication');
      }
      return NULL;
    }
    $user['permissions'] = $this->CI->Model_role->permissions(array('role_id' =>$user['role_id']));
    return $user;
  }
}
