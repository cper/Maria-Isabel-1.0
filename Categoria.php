<?php 

class Categoria extends Admin_Controller {
    
    public function __construct() {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Categor&iacute;as';
        $this->load->model('model_categoria');
    }

    public function index() {
        $this->render_template('categoria/index', $this->data);
    }

    public function listar() {
        $result = array('data' => array());

        $data = $this->model_categoria->getCategoryData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (in_array('actualizarCategoria', $this->permiso)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc(' . $value['id_categoria'] . ')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }

            if (in_array('eliminarCategoria', $this->permiso)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id_categoria'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value['estado'] == 1) ? '<span class="label label-success">Activa</span>' : '<span class="label label-warning">Inactiva</span>';

            $result['data'][$key] = array(
                $value['nombre'],
                $status,
                $buttons
            );
        }

        echo json_encode($result);
    }

    public function crear() {

        $response = array();

        $this->form_validation->set_rules('nombre', 'Nombre de la categor&iacte;a', 'trim|required');
        $this->form_validation->set_rules('estado', 'estado', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name'      => $this->input->post('nombre'),
                'estado'    => $this->input->post('estado')
            );

            $create = $this->model_categoria->crear($data);
            if ($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Creado satisfactoriamente.';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error en la base de datos al insertar la informaci&oacute;n de la se&ntilde;alada.';
            }
        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }

    public function listaCategoriaId($id = null){

        if ($id) {
            $data = $this->model_categoria->getCategoryData($id);
            echo json_encode($data);
        }
    }

    public function actualizar($id) {

        $response = array();

        if ($id) {
            $this->form_validation->set_rules('edit_category_name', 'Category name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'estado', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'nombre' => $this->input->post('nombre'),
                    'estado' => $this->input->post('estado'),
                );

                $update = $this->model_categoria->actualizar($id, $data);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Actualizado satisfactoriamente.';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error en la base de datos al actualizar la informaci&oacute;n de la se&ntilde;alada.';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Error por favor refresque la p&aacute;gina.';
        }

        echo json_encode($response);
    }

    public function eliminar() {

        $category_id = $this->input->post('id_categoria');

        $response = array();
        if ($category_id) {
            $delete = $this->model_categoria->eliminar($category_id);
            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Eliminado satisfactoriamente.";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error en la base de datos al eliminar la informaci&oacute;n de la se&ntilde;alada.";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "¡Reenv&iacute;a el formulario de nuevo!";
        }

        echo json_encode($response);
    }

}