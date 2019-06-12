<?php 

class Model_categoria extends CI_Model{
	
	public function __construct(){

		parent::__construct();
	}

	public function getCategoryData($id = null){

		if($id) {
			$query = $this->db->query('SELECT * FROM categoria WHERE id_categoria = ?', array($id));
			return $query->row_array();
		}

		$query = $this->db->query('SELECT * FROM categoria ORDER BY id_categoria DESC');
		return $query->result_array();
	}

	public function crear($data = array()){

		if($data) {
			$create = $this->db->insert('categoria', $data);
			return ($create == true) ? true : false;
		}
	}

	public function actualizar($id = null, $data = array()){

		if($id && $data) {
			$this->db->where('id_categoria', $id);
			$update = $this->db->update('categoria', $data);
			return ($update == true) ? true : false;
		}
	}

	public function eliminar($id = null){

		if($id) {
			$this->db->where('id_categoria', $id);
			$delete = $this->db->delete('categoria');
			return ($delete == true) ? true : false;
		}
	}

	public function getActiveCategory(){
		
		$query = $this->db->query('SELECT * FROM categoria WHERE estado= ?', array(1));
		return $query->result_array();
	}
}