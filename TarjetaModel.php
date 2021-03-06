<?php

//CLIENTE(id: int; nombre: string, dni: string, telefono: string, direccion: string, ejecutivo: boolean)
//TARJETA(id: int; fecha_alta: datetime; nro_tarjeta: string, fecha_vencimiento: int, tipo_tarjeta: string, id_cliente: int)
//ACTIVIDAD(id: int; kms: int, fecha: datetime, tipo_operación: int, id_cliente: int)

class TarjetaModel{

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_pfy;charset=utf8', 'root', '');
    }

    function getTarjetasAsociadas($id_cliente){
        $query = $this->db->prepare("SELECT * FROM tarjeta WHERE id_cliente = ?");
        $query->execute([$id_cliente]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}