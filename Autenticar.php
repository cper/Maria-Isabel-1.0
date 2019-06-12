<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticar extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('model_autenticar');
	}
	public function login(){

		$this->logged_in();

		$this->form_validation->set_rules('correo_electronico', 'correo_electronico', 'required');
        $this->form_validation->set_rules('clave', 'clave', 'required');

        if ($this->form_validation->run() == TRUE) {
           	$email_exists = $this->model_autenticar->check_email($this->input->post('correo_electronico'));

           	if($email_exists == TRUE) {
           		$login = $this->model_autenticar->login($this->input->post('correo_electronico'), $this->input->post('clave'));

           		if($login) {

           			$logged_in_sess = array(
           				'id_usuario'             => $login['id_usuario'],
				          'nombre_usuario'         => $login['nombre_usuario'],
				          'correo_electronico'     => $login['correo_electronico'],
				          'logged_in'              => TRUE
					     );

					$this->session->set_userdata($logged_in_sess);
           			redirect('panel', 'refresh');
           		}
           		else {
           			$this->data['errors'] = 'correo electronico o contraseña incorrecta.';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'El correo electronico ingresado no existe.';
           		$this->load->view('login', $this->data);
           	}	
        }
        else {
            $this->load->view('login');
        }	
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('autenticar/login', 'refresh');
	}

}
