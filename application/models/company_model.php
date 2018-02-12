<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model
{
	private $table_name = 'tbl_company_profile';

	public function getCompanyWhere($where)
	{
		$this->db->where($where);
		$query = $this->db->get($this->table_name);
		$user = $query->result();
		return $user;
	}

	public function addCompany($data) {
		$this->db->insert($this->table_name, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function updateCompany($com_id, $data) {
		$this->db->where('com_id', $com_id);
		$this->db->update($this->table_name, $data);
	}

}