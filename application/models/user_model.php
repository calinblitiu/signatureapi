<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	private $table_name = 'tbl_users';

	public function getUserWhere($where)
	{
		$this->db->where($where);
		$query = $this->db->get($this->table_name);
		$user = $query->result();
		return $user;
	}

	public function login($email, $password){
        $this->db->where('login_email', $email);
        $query = $this->db->get($this->table_name);
        $user = $query->result();
        if(!empty($user)){
            if(password_verify($password, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
	}

	public function addUser($data) {
		$this->db->insert($this->table_name, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function updateUser($user_id, $data) {
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $data);
	}
}