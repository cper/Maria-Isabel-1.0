<?php 

class Model_autenticar extends CI_Model{
	
	public function __construct(){

		parent::__construct();
	}

	public function check_email($correo_electronico) {

		if($correo_electronico) {
			$query = $this->db->query("SELECT * FROM usuario WHERE correo_electronico = ?", array($correo_electronico));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}

		return false;
	}
	
	public function login($correo_electronico, $clave) {

		if($correo_electronico && $clave) {
		
			$query = $this->db->query("SELECT * FROM usuario WHERE correo_electronico = ?", array($correo_electronico));

			if($query->num_rows() == 1) {
				$result = $query->row_array();

				$hash_clave = password_verify($clave, $result['clave']);
				if($hash_clave === true) {
					return $result;	
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
	}
}