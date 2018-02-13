<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Signature_model extends CI_Model
{
	private $table_name = 'tbl_signature';

	public function getSignaturesWhere($where)
	{
		$this->db->where($where);
		$query = $this->db->get($this->table_name);
		$signatures = $query->result();
		return $signatures;
	}

	public function addSignature($data) {
		$this->db->insert($this->table_name, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function updateSignature($sig_id, $data) {
		$this->db->where('sig_id', $sig_id);
		$this->db->update($this->table_name, $data);
	}
}