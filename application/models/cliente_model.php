<?php
class Cliente_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function create_cliente($data){
        return $this->db->insert('Cliente', $data);
    }

    public function update_cliente($data, $id){
        $this->db->where('id', $id);
        return $this->db->update('Cliente', $data);
    }

    public function delete_cliente($id){
        $clientes = $this->db->query('DELETE FROM Cliente WHERE id=' . $id);
        //return $clientes->result_array();
    }

    public function read_cliente_esp($id){
        //$fraccion=$this->input->post('fraccion');
        $clientes = $this->db->query('SELECT * FROM Cliente WHERE id=' . $id);
        return $clientes->result_array();
    }

}
