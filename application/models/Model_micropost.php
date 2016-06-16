<?php
class Model_micropost extends CI_Model {
    function __construct() {
        parent::__construct();
        // echo $this->input->post('class');
    }
    function get($id =0) {
        $id = (int)$id;
        return $this->db->select('*')->from('microposts')->where(array('id'=> $id))->get()->row_array();
    }
    function create($id = 0) {
        $id = (int)$id;
        $this->db->insert('microposts', array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'user_id' => $id,
                'created_at' => gmdate('Y-m-d H:i:s',time() + 7*3600),
            ));

        $fag = $this->db->affected_rows();
        if ($fag > 0) {
            return array(
                'type' => 'seccessful',
                'message' => 'Tạo post thành công !',
            );
        } else {
            return array(
                'type' => 'error',
                'message' => 'Tạo post không thành công',
            );
        }
    }
    function delete($id =0) {            
        $id = (int)$id;
        $this->db->delete('microposts', array('id' => $id)); 
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
    function view_micropost($start, $limit,$id) {
        return $this->db->select('*')->from('microposts')->where(array('user_id' =>$id))->order_by('id DESC')->limit($limit,$start)->get()->result_array(); 
    }
    function total($id) {
        return $this->db->from('microposts')->where(array('user_id' =>$id))->count_all_results();
    }
    function view_micropost_all($start, $limit =0,$id =0) {
        $temp[0] = $id;
        $array = $this->Model_relationship->followings($id);
        if(isset($array) && count($array)) {
            foreach ($array as $key => $value) {
                $temp[] = $value['id']; 
            }     
        }
        return $this->db->select('microposts.id as micropost_id,title,content,microposts.created_at as micropost_created_at,users.id as user_id,users.name')->from('microposts')->join('users','user_id=users.id')->where_in('user_id' ,$temp)->order_by('microposts.created_at DESC')->limit($limit,$start)->get()->result_array(); 
    }
    function total_all($id) {
        $temp[0] = $id;
        $array = $this->Model_relationship->followings($id);
        if(isset($array) && count($array)) {
            foreach ($array as $key => $value) {
                $temp[] = $value['id']; 
            }     
        }
        return $this->db->select('*')->from('microposts')->where_in('user_id' ,$temp)->count_all_results();
    }
}