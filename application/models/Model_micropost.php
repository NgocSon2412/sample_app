<?php
class Model_micropost extends CI_Model {
    function __construct() {
        parent::__construct();
        // echo $this->input->post('class');
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
    function view_micropost($start, $limit) {
        return $this->db->select('*')->from('microposts')->order_by('id DESC')->limit($limit,$start)->get()->result_array(); 
    }
    function total() {
        return $this->db->from('microposts')->count_all_results();
    }
}