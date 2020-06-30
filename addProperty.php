<?php

//Enpoint_addProperty.php
//http://localhost:81/parcial3/addProperty.php

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    include_once('db_connection.php');
    $request = file_get_contents('php://input');
    $dataPropertie = json_decode($request);
    //validar que el dato exista y no enviar datos vacios a la BD
    $title = "";
    $type = "";
    $address = "";
    $rooms = "";
    $price = "";
    $area = "";
    $id_user = "";

    if (isset($dataPropertie->title) && isset($dataPropertie->type) && isset($dataPropertie->address) && isset($dataPropertie->rooms) && isset($dataPropertie->price) && isset($dataPropertie->area) && isset($dataPropertie->id_user)) {
        $title = $dataPropertie->title;
        $type = $dataPropertie->type;
        $address = $dataPropertie->address;
        $rooms = $dataPropertie->rooms;
        $price = $dataPropertie->price;
        $area = $dataPropertie->area;
        $id_user = $dataPropertie->id_user;

        if ($title == "" || $type == "" || $address == "" || $rooms == "" || $price == "" || $area == "" || $id_user == "") {
            echo json_encode(array('Error' => true, "title" => "Campos Vacios en el Registro", 'Message' => 'formato invalido, pueden que existan campos vacios por favor valide'));
        } else if (is_numeric($rooms) &&  is_numeric($price) &&  is_numeric($area) &&  is_numeric($id_user)) {
            $sql = "SELECT * FROM users WHERE id={$id_user}";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql = "INSERT INTO properties (title,type,address,rooms,price,area,id_user) VALUES ('{$title}','{$type}','{$address}',{$rooms},{$price}, {$area}, {$id_user})";
                $result = $conn->query($sql);
                echo json_encode(array('success' => true, 'Message' => 'Propiedad Agregada Satisfactoriamente', 'Error' => false));
            } else {
                echo json_encode(array('Error' => true, "title" => "Usuario no autorizado", 'Message' => 'El usuario ingresado no esta permitido par esta operacion'));
            }
        } else {
            echo json_encode(array('Error' => true, "title" => "Formato invalido en los campos", 'Message' => 'Rooms - Price o Area, deben ser numericos, por favor valide'));
        }
    } else {
        echo json_encode(array('Error' => true, "title" => "Formato no valido", 'Message' => 'formato invalido, Valide Por Favor'));
    }
} else {
    echo json_encode(array("Error" => true, "title" => "Error de programa.", 'Message' => 'Método de Envio,formato invalido'));
}
