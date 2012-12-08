<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Moy Lopez
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';
require APPPATH.'/libraries/sphinxapi.php';

class Api extends REST_Controller {

/**********************************************************************************
****************************** TABLA Usuario **************************************
***********************************************************************************/

	function usuario_get() {
		if(!$this->get('id')) {
			$this->response(NULL, 400);
		}

		$resultado = $this->usuario_model->read_usuario_esp($this->get('id'));
		if($resultado) {
			$this->response($resultado, 200);
		}
		else {
			$this->response(array('error' => 'No se encontro el Usuario'), 404);
		}
	}

	function usuario_put() {
        $data= array(
            'nombre' => $this->put('nombre'),
            'password' => $this->put('password'),
            'tipo_usuario' => $this->put('tipo_usuario')
        );

		$resultado = $this->usuario_model->create_usuario($data);
		if($resultado) {
			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El usuario no se pudo agregar'), 404);
		}
	}

	function usuario_post() {
		if(!$this->post('id')) {
			$this->response(NULL, 400);
		}

        $data= array(
            'nombre' => $this->post('nombre'),
            'password' => $this->post('password'),
            'tipo_usuario' => $this->post('tipo_usuario')
        );

		$resultado = $this->usuario_model->update_usuario($data, $this->post('id'));
		if($resultado) {
			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El usuario no se pudo actualizar'), 404);
		}
	}

	function usuario_delete() {
		if(!$this->delete('id')) {
			$this->response(NULL, 400);
		}
		$resultado = $this->usuario_model->read_usuario_esp($this->delete('id'));
		if($resultado) {
			$resultado = $this->usuario_model->delete_usuario($this->delete('id'));
        	$message = array('message' => 'Usuario borrado');
        	$this->response($message, 200); // 200 being the HTTP response code
		}
		else {
			$this->response(array('error' => 'No se encontro el usuario'), 404);
		}
	}

/**********************************************************************************
****************************** TABLA Reporte *************************************
***********************************************************************************/
	function reporte_get() {
		if(!$this->get('id')) {
			$this->response(NULL, 400);
		}
		else $id = $this->get('id');

		$resultado = $this->reporte_model->read_reporte_esp($id);
		if($resultado) {
			for ($i=0; $i <count($resultado); $i++) { 
				$resultado[$i]['latitud']=$resultado[$i]['latitud']*180/pi();
				$resultado[$i]['longitud']=$resultado[$i]['longitud']*180/pi();
			}
			$this->response($resultado, 200);
		}
		else {
			$this->response(array('error' => 'Reporte no encontrado'), 404);
		}
	}

	function reportexusuario_get() {
		if(!$this->get('id_usuario')) {
			$this->response(NULL, 400);
		}
		else $id = $this->get('id_usuario');

		$resultado = $this->reporte_model->read_reporte_usuario($id);
		if($resultado) {
			for ($i=0; $i <count($resultado); $i++) { 
				$resultado[$i]['latitud']=$resultado[$i]['latitud']*180/pi();
				$resultado[$i]['longitud']=$resultado[$i]['longitud']*180/pi();
			}
			$this->response($resultado, 200);
		}
		else {
			$this->response(array('error' => 'Reporte no encontrado'), 404);
		}
	}

	function reportexubicacion_get() {
		if(!$this->get('lat') || !$this->get('lng')) {
			$this->response(NULL, 400);
		}
		else{
			$lat = $this->get('lat');
			$lng = $this->get('lng');
		} 

		$m=1;
		
		do{
			$resultado = $this->reporte_model->read_reporte_ubicacion($lat, $lng, $m);
			if($resultado) {
			for ($i=0; $i <count($resultado); $i++) { 
				$resultado[$i]['latitud']=$resultado[$i]['latitud']*180/pi();
				$resultado[$i]['longitud']=$resultado[$i]['longitud']*180/pi();
			}
				$this->response($resultado, 200);
				break;
			}
			$m++;
		}
		while ($m<=10);

		if (!$resultado){
			$this->response(array('error' => 'Reporte no encontrado'), 404);
		}
	}

	function reporte_put() {
        $data= array(
            'tipo_reporte' => $this->put('tipo_reporte'),
            'nombre' => $this->put('nombre'),
            'url_imagen' => $this->put('url_imagen'),
            'procedencia' => $this->put('procedencia'),
            'tipo' => $this->put('tipo'),
            'raza' => $this->put('raza'),
            'sexo' => $this->put('sexo'),
            'descripcion' => $this->put('descripcion'),
            'fecha' => $this->put('fecha'),
            'latitud' => $this->put('latitud')*pi()/180,
            'longitud'=> $this->put('longitud')*pi()/180,
            'colonia' => $this->put('colonia'),
            'delegacion' => $this->put('delegacion'),
            'telefono' => $this->put('telefono'),
            'email' => $this->put('email'),
            'id_usuario' => $this->put('id_usuario')
        );

		$resultado = $this->reporte_model->create_reporte($data);
		if($resultado) {

			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El reporte no se pudo agregar'), 404);
		}
	}

	function reporte_post() {
		if(!$this->post('id')) {
			$this->response(NULL, 400);
		}
        $data= array(
            'tipo_reporte' => $this->post('tipo_reporte'),
            'nombre' => $this->post('nombre'),
            'url_imagen' => $this->post('url_imagen'),
            'procedencia' => $this->post('procedencia'),
            'tipo' => $this->post('tipo'),
            'raza' => $this->post('raza'),
            'sexo' => $this->post('sexo'),
            'descripcion' => $this->post('descripcion'),
            'fecha' => $this->post('fecha'),
            'latitud' => $this->post('latitud')*pi()/180,
            'longitud'=> $this->post('longitud')*pi()/180,
            'colonia' => $this->post('colonia'),
            'delegacion' => $this->post('delegacion'),
            'telefono' => $this->post('telefono'),
            'email' => $this->post('email'),
            'id_usuario' => $this->post('id_usuario')
        );

		$resultado = $this->reporte_model->update_reporte($data, $this->post('id'));
		if($resultado) {
			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El reporte no se pudo actualizar'), 404);
		}
	}


	function reporte_delete() {
		if(!$this->delete('id')) {
			$this->response(NULL, 400);
		}
		$resultado = $this->reporte_model->read_reporte_esp($this->delete('id'));
		if($resultado) {
			$resultado = $this->reporte_model->delete_reporte($this->delete('id'));
        	$message = array('message' => 'Reporte borrado');
        	$this->response($message, 200); // 200 being the HTTP response code
		}
		else {
			$this->response(array('error' => 'No se encontro el reporte'), 404);
		}
	}

/**********************************************************************************
****************************** TABLA Cliente **************************************
***********************************************************************************/
	function cliente_get() {
		if(!$this->get('id')) {
			$this->response(NULL, 400);
		}
		else $id = $this->get('id');

		$resultado = $this->cliente_model->read_cliente_esp($id);
		if($resultado) {
			$this->response($resultado, 200);
		}
		else {
			$this->response(array('error' => 'Cliente no encontrado'), 404);
		}
	}

	function cliente_put() {
        $data= array(
            'tipo_cliente' => $this->put('tipo_cliente'),
            'giro' => $this->put('giro'),	
            'propietario' => $this->put('propietario'),
            'latitud' => $this->put('latitud'),
            'longitud'=> $this->put('longitud'),
            'direccion' => $this->put('direccion'),
            'colonia' => $this->put('colonia'),
            'delegacion' => $this->put('delegacion'),
            'telefono' => $this->put('telefono'),
            'email' => $this->put('email'),
            'url' => $this->put('url'),            
            'id_usuario' => $this->put('id_usuario')
        );

		$resultado = $this->cliente_model->create_cliente($data);
		if($resultado) {
			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El cliente no se pudo agregar'), 404);
		}
	}

	function cliente_post() {
		if(!$this->post('id')) {
			$this->response(NULL, 400);
		}

        $data= array(
            'tipo_cliente' => $this->post('tipo_cliente'),
            'giro' => $this->post('giro'),	
            'propietario' => $this->post('propietario'),
            'latitud' => $this->post('latitud'),
            'longitud'=> $this->post('longitud'),
            'direccion' => $this->post('direccion'),
            'colonia' => $this->post('colonia'),
            'delegacion' => $this->post('delegacion'),
            'telefono' => $this->post('telefono'),
            'email' => $this->post('email'),
            'url' => $this->post('url'),            
            'id_usuario' => $this->post('id_usuario')
        );

		$resultado = $this->cliente_model->update_cliente($data, $this->post('id'));
		if($resultado) {
			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El cliente no se pudo actualizar'), 404);
		}
	}


	function cliente_delete() {
		if(!$this->delete('id')) {
			$this->response(NULL, 400);
		}
		$resultado = $this->cliente_model->read_cliente_esp($this->delete('id'));
		if($resultado) {
			$resultado = $this->cliente_model->delete_cliente($this->delete('id'));
        	$message = array('message' => 'Cliente borrado');
        	$this->response($message, 200); // 200 being the HTTP response code
		}
		else {
			$this->response(array('error' => 'No se encontro el cliente'), 404);
		}
	}

/**********************************************************************************
****************************** TABLA Comentario ***********************************
***********************************************************************************/
	function comentario_get() {
		if(!$this->get('id')) {
			$this->response(NULL, 400);
		}
		else $id = $this->get('id');

		$resultado = $this->comentario_model->read_comentario_esp($id);
		if($resultado) {
			$this->response($resultado, 200);
		}
		else {
			$this->response(array('error' => 'Comentario no encontrado'), 404);
		}
	}

	function comentarioxusuario_get() {
		if(!$this->get('id_usuario')) {
			$this->response(NULL, 400);
		}
		else $id = $this->get('id_usuario');

		$resultado = $this->comentario_model->read_comentario_usuario($id);
		if($resultado) {
			$this->response($resultado, 200);
		}
		else {
			$this->response(array('error' => 'Comentario no encontrado'), 404);
		}
	}

	function comentarioxreporte_get() {
		if(!$this->get('id_reporte')) {
			$this->response(NULL, 400);
		}
		else $id = $this->get('id_reporte');

		$resultado = $this->comentario_model->read_comentario_reporte($id);
		if($resultado) {
			$this->response($resultado, 200);
		}
		else {
			$this->response(array('error' => 'Comentario no encontrado'), 404);
		}
	}


	function comentario_put() {
        $data= array(
            'comentario' => $this->put('comentario'),
            'id_reporte' => $this->put('id_reporte'),	
            'id_usuario' => $this->put('id_usuario')
        );

		$resultado = $this->comentario_model->create_comentario($data);
		if($resultado) {
			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El comentario no se pudo agregar'), 404);
		}
	}

	function comentario_post() {
		if(!$this->post('id')) {
			$this->response(NULL, 400);
		}
		
        $data= array(
            'comentario' => $this->post('comentario'),
            'id_reporte' => $this->post('id_reporte'),	
            'id_usuario' => $this->post('id_usuario')
        );

		$resultado = $this->comentario_model->update_comentario($data, $this->post('id'));
		if($resultado) {
			$this->response($resultado, 201);
		}
		else {
			$this->response(array('error' => 'El comentario no se pudo actualizar'), 404);
		}
	}

	function comentario_delete() {
		if(!$this->delete('id')) {
			$this->response(NULL, 400);
		}
		$resultado = $this->comentario_model->read_comentario_esp($this->delete('id'));
		if($resultado) {
			$resultado = $this->comentario_model->delete_comentario($this->delete('id'));
        	$message = array('message' => 'Cliente borrado');
        	$this->response($message, 200); // 200 being the HTTP response code
		}
		else {
			$this->response(array('error' => 'No se encontro el comentario'), 404);
		}
	}


/**********************************************************************************
**************************************** OTROS  ***********************************
***********************************************************************************/

	function buscar_palabras_get() {
		if(!$this->get('palabras')) {
			$palabras = '';
		}
		else $palabras = $this->get('palabras');

		$cl = new SphinxClient ();

		$q = $palabras;
		$sql = "";
		$mode = SPH_MATCH_ALL;
		$host = "localhost";
		$port = 9312;
		$index = "tigie";
		$groupby = "subpartida";
		$groupsort = "@group desc";
		$filter = "group_id";
		$filtervals = array();
		$distinct = "";
		$sortby = "";
		$sortexpr = "";
		$limit = 40;
		$ranker = SPH_RANK_PROXIMITY_BM25;
		$select = "";

		$cl->SetServer ( $host, $port );
		$cl->SetConnectTimeout ( 1 );
		$cl->SetArrayResult ( true );
		$cl->SetWeights ( array ( 100, 1  ) );
		$cl->SetMatchMode ( $mode );
		if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
		if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
		if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
		if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
		if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
		if ( $select )				$cl->SetSelect ( $select );
		if ( $limit )				$cl->SetLimits ( 0, $limit, ( $limit>1000 ) ? $limit : 1000 );
		$cl->SetRankingMode ( $ranker );
		$res = $cl->Query ( $q, $index );
		if ( $res===false ){
		    print "Falló la busqueda: " . $cl->GetLastError() . ".\n";

		} else{
			$busqueda = array();
			if (isset($res['matches'])){
				foreach ($res['matches'] as $info) {
					$consulta = $this->tarifa_model->read_fraccion_esp($info['id']);
					//var_dump($consulta[0]['fraccion']);
					//var_dump($info['id']);
					$busqueda[$consulta[0]['fraccion']] = array (
						'fraccion_desc' => $consulta[0]['fraccion_desc'],
						'partida_desc' => $consulta[0]['partida_desc'],
						'subpartida_desc' => $consulta[0]['subpartida_desc'],
						);
				}

				if($busqueda) {
						$this->response($busqueda, 200);
					}
					else {
						$this->response(array('error' => 'No se obtuvieron resultados de la busqueda'), 404);
					}
			}
			else {
				$this->response(array('error' => 'No se obtuvieron resultados de la busqueda'), 404);
			}
		}
	}

}