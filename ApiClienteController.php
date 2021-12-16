<?php
require_once "";


class ApiClienteController{
    
    private $clienteModel;
    private $view;

    function __construct(){
        $this->clienteModel = new ClienteModel();
        $this->view = new ApiView();
    }

    function getTarjetasCliente(){
        $tarjetas = $this->clienteModel->getTarjetas();
        return $this->view->response($tarjetas, 200);
    }

    function eliminarTarjeta($params = null){
        $idTarjeta = $params[':ID'];    
        $tarjeta = $this->clienteModel->getTarjeta();

        if($tarjeta){
            $this->clienteModel->eliminarTarjetaCliente();
            return $this->view->response("La tarjeta fue borrada", 200);
        }else{
            return $this->view->response("La tarjeta no existe", 404);
        }
    }
}