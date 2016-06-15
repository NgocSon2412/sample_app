<?php
class Model_relationship extends CI_Model {
    function __construct() {
        parent::__construct();
        // echo $this->input->post('class');
    }
    function follow($current_user_id,$other_user_id) {
        $current_user_id = (int)$current_user_id;
        $other_user_id = (int)$other_user_id;
        $this->db->insert('relationships', array(
                'follower_id' => $current_user_id,
                'followed_id' => $other_user_id,
                'created_at' => gmdate('Y-m-d H:i:s',time() + 7*3600),
            ));

        $this->db->affected_rows();
    }
    function unfollow($current_user_id,$other_user_id) {            
        $current_user_id = (int)$current_user_id;
        $other_user_id = (int)$other_user_id;
        $this->db->delete('relationships', array(
                'follower_id' => $current_user_id,
                'followed_id' => $other_user_id,
                )); 
        $this->db->affected_rows();
    }
    function following($current_user_id,$other_user_id) {            
        $current_user_id = (int)$current_user_id;
        $other_user_id = (int)$other_user_id;
        $array =$this->db->select('followed_id')->from('relationships')->where(array('follower_id' =>$current_user_id))->get()->result_array(); 
        if(isset($array) && count($array)) {
            foreach ($array as $key => $value) {
                $temp[] = $value['followed_id'];
            }     
            if(in_array ( $other_user_id,  $temp)) {
                return TRUE;
            }else {
                return FALSE;
            }    
        }        
        return FALSE;
    }
    function count_following($current_user_id) {            
        $current_user_id = (int)$current_user_id;
        $array =$this->db->select('followed_id')->from('relationships')->where(array('follower_id' =>$current_user_id))->get()->result_array(); 
        return count($array);
    }
    function count_follower($current_user_id) {            
        $current_user_id = (int)$current_user_id;
        $array =$this->db->select('follower_id')->from('relationships')->where(array('followed_id' =>$current_user_id))->get()->result_array(); 
        return count($array);
    }
}