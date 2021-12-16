<?php

//CLIENTE(id: int; nombre: string, dni: string, telefono: string, direccion: string, ejecutivo: boolean)
//TARJETA(id: int; fecha_alta: datetime; nro_tarjeta: string, fecha_vencimiento: int, tipo_tarjeta: string, id_cliente: int)
//ACTIVIDAD(id: int; kms: int, fecha: datetime, tipo_operación: int, id_cliente: int)

require_once "ClienteModel.php";
require_once "ActividadModel.php";
require_once "TarjetaModel.php";
require_once "ClienteView.php";
require_once "AuthHelper.php";

class ClienteController{
    private $clienteModel;
    private $actividadModel;
    private $tarjetaModel;
    private $view;
    private $authHelper;

    function __construct(){
        $this->clienteModel = new ClienteModel();
        $this->actividadModel = new ActividadModel();
        $this->tarjetaModel = new TarjetaModel();
        //$this->view = new ClienteView();
        $this->authHelper = new AuthHelper();
    }

    function altaCliente(){
        $this->authHelper->verifyLogin();
        $dni = $_POST['dni'];
        
        $dniCliente = $this->clienteModel->getDni($dni);

        if(isset($_POST['nombre']) && isset($_POST['dni']) && isset($_POST['telefono']) && isset($_POST['direccion']) && isset($_POST['ejecutivo'])){
            if($this->authHelper->esAdmin()){
                if(!$dniCliente){
                    $this->clienteModel->addCliente($_POST['nombre'], $_POST['dni'], $_POST['telefono'],$_POST['direccion'],$_POST['ejecutivo']);
                    $this->actividadModel->depositarKilometros($_POST['dni']);
                }else{
                    $this->view->showMensaje("Ya existe un cliente con el dni ingresado");
                }
            }else{
                $this->view->showMensaje("No puedes realizar esta accion");
            }
        }else{
            $this->view->showMensaje("Faltan completar campos");
        }
    }

    function resumenCuenta(){
        $dni = $this->clienteModel->getDni($_POST['dni']);
        $tarjetas = $this->tarjetaModel->getTarjetasAsociadas($_POST['id_cliente']);

        if($dni){
            $this->view->showDetallesResumen($_POST['tipo_operacion'],$_POST['kms'], $_POST['fecha']);
        }else{
            $this->view->showMensaje("No existe el cliente");
        }

        if($dni){
            $this->view->showTarjetas($tarjetas);
        }else{
            $this->view->showMensaje("No existe el cliente");
        }
    }

}