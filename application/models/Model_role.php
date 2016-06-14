<?php
class Model_role extends CI_Model {
    function __construct() {
        parent::__construct();
        // echo $this->input->post('class');
    }
    function permissions($param_where = NULL) {
        $this->db->select('permissions')->from('user_permissions');
        if(isset($param_where) && count($param_where)) {
            $this->db->where($param_where);
        }
        $permissions=$this->db->get()->result_array();
        if(isset($permissions) && count($permissions)) {
            $temp = NULL;
            foreach ($permissions as $key => $value) {
                $temp[] = $value['permissions'];
            }
            return $temp;
        }
        return NULL;
    }
}