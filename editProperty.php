<?php

//Enpoint_editProperty.php
//http://localhost:81/parcial3/editProperty.php

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'PUT') {
    include_once('db_connection.php');

    $request = file_get_contents('php://input');
    $dataPropertie = json_decode($request);

    $id = "";
    $id_user = "";

    if (isset($dataPropertie->id) && isset($dataPropertie->id_user)) {

        $id = $dataPropertie->id;
        $title = $dataPropertie->title;
        $type = $dataPropertie->type;
        $address = $dataPropertie->address;
        $rooms = $dataPropertie->rooms;
        $price = $dataPropertie->price;
        $area = $dataPropertie->area;
        $id_user = $dataPropertie->id_user;

        if ($title == "" || $type == "" || $address == "" || $rooms == "" || $price == "" || $area == "" || $id_user == "") {
            echo json_encode(array("Error" => true, "title" => "Campos vacios", 'Message' => 'formato invalido, pueden que existan campos vacios por favor valide'));
        } elseif (is_numeric($rooms) &&  is_numeric($price) &&  is_numeric($area) &&  is_numeric($id_user)) {

            $sql = "SELECT * FROM users WHERE id={$id_user}";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

                $sql = "UPDATE  properties SET title='{$title}', type='{$type}', address='{$address}', rooms='{$rooms}', price={$price}, area={$area} WHERE id= {$id} && id_user={$id_user}";
                $result = $conn->query($sql);
                echo json_encode(array('success' => true, 'Message' => 'Propiedad Editada Satisfactoriamente', 'Error' => false));
            } else {

                echo json_encode(array('Error' => true, "title" => "Campos vacios o inexistentes", 'Message' => 'Error Inesperado, el campo ID o ID_USER ESTAN VACIOS o no estan en la base de datos'));
            }
        } else {
            echo json_encode(array('Error' => true, "title" => "Campos Númericos", 'Message' => 'formato invalido, los campos Rooms - Price - Area - id - id_user debe ser numericos, por favor valide'));
        }
    } else {
        echo json_encode(array('Error' => true, "title" => "Formato errado o invalido", 'Message' => 'formato invalido, Valide Por Favor'));
    }
} else {
    echo json_encode(array("Error" => true, "title" => "Error de programa.", 'Message' => 'Método de Envio,formato invalido'));
}
