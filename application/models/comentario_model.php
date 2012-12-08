<?php
class Comentario_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function create_comentario($data){
        return $this->db->insert('Comentario', $data);
    }

    public function update_comentario($data, $id){
        $this->db->where('id', $id);
        return $this->db->update('Comentario', $data);
    }

    public function delete_comentario($id){
        $comentarios = $this->db->query('DELETE FROM Comentario WHERE id=' . $id);
        //return $comentarios->result_array();
    }

    public function read_comentario_esp($id){
        //$fraccion=$this->input->post('fraccion');
        $comentarios = $this->db->query('SELECT * FROM Comentario WHERE id=' . $id);
        return $comentarios->result_array();
    }

    public function read_comentario_usuario($id_usuario){
        //$fraccion=$this->input->post('fraccion');
        $comentarios = $this->db->query('SELECT * FROM Comentario WHERE id_usuario=' . $id_usuario);
        return $comentarios->result_array();
    }

    public function read_comentario_reporte($id_reporte){
        //$fraccion=$this->input->post('fraccion');
        $comentarios = $this->db->query('SELECT * FROM Comentario WHERE id_reporte=' . $id_reporte);
        return $comentarios->result_array();
    }

}
