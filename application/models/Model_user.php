<?php
class Model_user extends CI_Model {
    function __construct() {
        parent::__construct();
        // echo $this->input->post('class');
    }
    function total($param_where = NULL) {
        $this->db->from('users');
        if(isset($param_where) && count($param_where)) {
            $this->db->where($param_where);
        }
        return $this->db->count_all_results();
    }
    function get($param_where = NULL) {
        $this->db->select('id,name,email,role_id,password')->from('users');
        if(isset($param_where) && count($param_where)) {
            $this->db->where($param_where);
        }
        return $this->db->get()->row_array();
    }
    function index($start, $limit) {
        return $this->db->select('*')->from('users')->order_by('id ASC')->limit($limit,$start)->get()->result_array(); 
    }  
    function add_user() {
        $this->db->insert('users', array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'created_at' => gmdate('Y-m-d H:i:s',time() + 7*3600),
            ));

        $fag = $this->db->affected_rows();
        if ($fag > 0) {
            return array(
                'type' => 'seccessful',
                'message' => 'Thêm lớp học thành công !',
            );
        } else {
            return array(
                'type' => 'error',
                'message' => 'Không có bản ghi nào được thêm',
            );
        }
    }
    function delete($id =0) {            
        $id = (int)$id;
        $this->db->delete('users', array('id' => $id)); 
        $fag = $this->db->affected_rows();
        if ($fag > 0) {
            return array(
                'type' => 'seccessful',
                'message' => 'Xóa post thành công!',
            );
        } else {
            return array(
                'type' => 'error',
                'message' => 'Không có bản ghi nào bị xóa!',
            );
        }
    }
    function forgot_password() {
        $email = $this->input->post('email');
        $data = array(
            'password' =>md5($this->input->post('password')),
            'updated_at' => gmdate('Y-m-d H:i:s',time() + 7*3600),
        );
        $this->db->where('email', $email);
        $this->db->update('user', $data);  
        $fag = $this->db->affected_rows();
        if ($fag > 0) {
            return array(
                'type' => 'seccessful',
                'message' => 'Sửa dữ liệu thành công!',
            );
        } else {
            return array(
                'type' => 'error',
                'message' => 'Không có bản ghi nào bị sửa!',
            );
        }
    }
    function edit_user($id =0) {            
        $id = (int)$id;
        $data = array(
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'updated_at' => gmdate('Y-m-d H:i:s',time() + 7*3600),
        );
        $this->db->where('id', $id);
        $this->db->update('users', $data);  
        $fag = $this->db->affected_rows();
        if ($fag > 0) {
            return array(
                'type' => 'seccessful',
                'message' => 'Sửa dữ liệu thành công!',
            );
        } else {
            return array(
                'type' => 'error',
                'message' => 'Không có bản ghi nào bị sửa!',
            );
        }
    }
    function update($param_data = NULL,$param_where = NULL) {            
        $this->db->where($param_where);
        $this->db->update('users', $param_data);  
        $fag = $this->db->affected_rows();
        if ($fag > 0) {
            return array(
                'type' => 'seccessful',
                'message' => 'Sửa dữ liệu thành công!',
            );
        } else {
            return array(
                'type' => 'error',
                'message' => 'Không có người dùng nào bị sửa!',
            );
        }
    }
    
}