<?php
class Model_comment extends CI_Model {
    function __construct() {
        parent::__construct();
        // echo $this->input->post('class');
    }
    function get($id =0) {
        $id = (int)$id;
        return $this->db->select('*')->from('comments')->where(array('id'=> $id))->get()->row_array();
    }
    function create($user_id = 0,$post_id = 0) {
        $user_id = (int)$user_id;
        $post_id = (int)$post_id;
        $this->db->insert('comments', array(
                'content' => $this->input->post('content'),
                'user_id' => $user_id,
                'post_id' => $post_id,
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
        $this->db->delete('comments', array('id' => $id)); 
        $fag = $this->db->affected_rows();
        if ($fag > 0) {
            return array(
                'type' => 'seccessful',
                'message' => 'Xóa comment thành công!',
            );
        } else {
            return array(
                'type' => 'error',
                'message' => 'Không có comment nào bị xóa!',
            );
        }
    }
    function view_comment($id =0) {
        return $this->db->select('comments.id as comment_id,content,user_id,post_id,comments.created_at as comment_created_at,users.name')->from('comments')->join('users','user_id=users.id')->where('post_id' ,$id)->order_by('comments.created_at DESC')->get()->result_array(); 
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