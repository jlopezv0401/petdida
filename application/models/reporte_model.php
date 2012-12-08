<?php
class Reporte_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function create_reporte($data){
        return $this->db->insert('Reporte', $data);
    }

    public function update_reporte($data, $id){
        $this->db->where('id', $id);
        return $this->db->update('Reporte', $data);
    }

    public function delete_reporte($id){
        $reportes = $this->db->query('DELETE FROM Reporte WHERE id=' . $id);
        //return $reportes->result_array();
    }

    public function read_reporte_esp($id){
        //$fraccion=$this->input->post('fraccion');
        $reportes = $this->db->query('SELECT * FROM Reporte WHERE id=' . $id);
        return $reportes->result_array();
    }

    public function read_reporte_usuario($id_usuario){
        $reportes = $this->db->query('SELECT * FROM Reporte WHERE id_usuario=' . $id_usuario);
        return $reportes->result_array();
    }

    public function read_reporte_ubicacion($lat, $lng, $d){
        $R = 6371;
        $d = 5*$d; //Kilometros

        $lat = ($lat * pi())/180;
        $lng = ($lng * pi())/180;
        $r=$d/$R;

        $lat_min = $lat-$r;
        $lat_max = $lat+$r;

        $delta_lng = asin(sin($r)/cos($lat));

        $lng_min = $lng-$delta_lng;
        $lng_max = $lng+$delta_lng;
      
        $reportes = $this->db->query('SELECT * FROM Reporte WHERE (latitud >= ' . $lat_min . ' AND latitud <= '. $lat_max .')' .
            'AND (longitud >= ' . $lng_min . ' AND longitud <= ' . $lng_max . ') HAVING ' .
            'acos(sin(' . $lat . ') * sin(latitud) + cos(' . $lat .  ') * cos(latitud) * cos(longitud - (' . $lng . '))) <=' . $r);
        return $reportes->result_array();
    }

}
