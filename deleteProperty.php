<?php

//Enpoint_deleteProperty.php
//http://localhost:81/parcial3/deleteProperty.php

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'DELETE') {
        include_once('db_connection.php');
        $request = file_get_contents('php://input');
        $dataPropertie = json_decode($request);

        $id = $dataPropertie->id;
        $id_user = $dataPropertie->id_user;

        if ($id == "" || $id_user == "") {
                echo json_encode(array('Error' => true, "title" => "Campos Vacios", 'Message' => 'Por favor valide el campo ID o ID_USER, puede estar vacio'));
        } else {

                $sql = "SELECT * FROM users WHERE id={$id_user} && id={$id}";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {

                        $id = $dataPropertie->id;
                        $id_user = $dataPropertie->id_user;
                        $sql = "DELETE FROM properties WHERE  id= {$id} && id_user={$id_user}";
                        $result = $conn->query($sql);
                        echo json_encode(array('success' => true, 'Message' => 'Propiedad Eliminda Satisfactoriamente', 'Error' => false));
                } else {

                        echo json_encode(array('Error' => true, "title" => "Propiedad o Usuario no Encontrado", 'Message' => 'Hay un dato que no se encontro en la base de datos por favor valide bien la información'));
                }
        }
} else {
        echo json_encode(array("Error" => true, "title" => "Error de programa.", 'Message' => 'Método de Envio,formato invalido'));
}
