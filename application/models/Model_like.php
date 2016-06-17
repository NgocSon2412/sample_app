<?php
class Model_like extends CI_Model {
    function __construct() {
        parent::__construct();
        // echo $this->input->post('class');
    }
    function like($current_user_id,$post_id) {
        $current_user_id = (int)$current_user_id;
        $post_id = (int)$post_id;
        $this->db->select('*')->from('likes')->where(array(
             'user_id' => $current_user_id,
            'post_id' => $post_id,
            ));
        $count = $this->db->count_all_results();
        if($count == 0) {
            $this->db->insert('likes', array(
                    'user_id' => $current_user_id,
                    'post_id' => $post_id,
                    'created_at' => gmdate('Y-m-d H:i:s',time() + 7*3600),
                ));

            $this->db->affected_rows();
        }
    }
    function unlike($current_user_id,$post_id) {            
        $current_user_id = (int)$current_user_id;
        $post_id = (int)$post_id;
        $this->db->delete('likes', array(
                'user_id' => $current_user_id,
                'post_id' => $post_id,
                )); 
        $this->db->affected_rows();
    }
    function check_liking($current_user_id,$post_id) {            
        $current_user_id = (int)$current_user_id;
        $post_id = (int)$post_id;
        $array =$this->db->select('post_id')->from('likes')->where(array('user_id' =>$current_user_id))->get()->result_array(); 
        if(isset($array) && count($array)) {
            foreach ($array as $key => $value) {
                $temp[] = $value['post_id'];
            }   
            if(in_array ( $post_id,  $temp)) {
                return TRUE;
            }else {
                return FALSE;
            }    
        }        
        return FALSE;
    }
    function count_like($post_id) {            
        $post_id = (int)$post_id;
        return $this->db->select('user_id')->from('likes')->where(array('post_id' =>$post_id))->count_all_results();
    }
}