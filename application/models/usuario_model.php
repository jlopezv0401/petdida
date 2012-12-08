<?php
class Usuario_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function create_usuario($data){
        return $this->db->insert('Usuario', $data);
    }

    public function update_usuario($data, $id){
        $this->db->where('id', $id);
        return $this->db->update('Usuario', $data);
    }

    public function delete_usuario($id){
        $usuarios = $this->db->query('DELETE FROM Usuario WHERE id=' . $id);
        //return $usuarios->result_array();
    }

    public function read_usuario_esp($id){
        //$fraccion=$this->input->post('fraccion');
        $usuarios = $this->db->query('SELECT * FROM Usuario WHERE id=' . $id);
        return $usuarios->result_array();
    }

}
