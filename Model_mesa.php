<?php 

class Model_Mesa extends CI_Model{
	
	public function __construct(){

		parent::__construct();
	}

	public function getTableData($id = null){

		if($id) {
			$query = $this->db->query('SELECT * FROM mesa WHERE id_mesa = ?', array($id));
			return $query->row_array();
		}

		// if admin all data 
		$id_usuario = $this->session->userdata('id_usuario');
		if($id_usuario == 1) {

			$query = $this->db->query('SELECT * FROM mesa ORDER BY id_mesa DESC');
			return $query->result_array();	
		}
		else {
			$this->load->model('model_usuario');
			$usuario_data = $this->model_usuario->getUserData($id_usuario);
			$query = $this->db->query('SELECT * FROM mesa WHERE id_sucursal = ? ORDER BY id_mesa DESC', array($usuario_data['id_usuario']));
			return $query->result_array();		
		}

		// else store wise
	}

	public function crear($data = array()){

		if($data) {
			$create = $this->db->insert('mesa', $data);
			return ($create == true) ? true : false;
		}
	}

	public function actualizar($id = null, $data = array()){

		$this->db->where('id_mesa', $id);
		$update = $this->db->update('mesa', $data);

		return ($update == true) ? true : false;
	}

	public function eliminar($id = null){

		if($id) {
			$this->db->where('id_mesa', $id);
			$delete = $this->db->delete('mesa');
			return ($delete == true) ? true : false;
		}
	}

	public function getActiveTable(){

		$id_usuario = $this->session->userdata('id_usuario');
		if($id_usuario == 1) {
			$query = $this->db->query('SELECT * FROM mesa WHERE disponible = ? AND estado = ?', array(1, 1));
			return $query->result_array();	
		}
		else {
			$this->load->model('model_usuario');
			$usuario_data = $this->model_usuario->getUserData($id_usuario);
			$query = $this->db->query('SELECT * FROM mesa WHERE id_sucursal = ? AND disponible = ? AND estado = ? ORDER BY id_mesa DESC', array($usuario_data['id_sucursal'], 1, 1));
			return $query->result_array();			
		}
	}
}