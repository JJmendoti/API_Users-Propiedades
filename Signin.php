<?php
//enpoint
//http://localhost:81/parcial3/Signin.php

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    include_once('db_connection.php');
    $request = file_get_contents('php://input');
    $data = json_decode($request);

    $identification = $data->identification;

    $sql = "SELECT * FROM users WHERE identification= '{$identification}'";
    $result = $conn->query(($sql));
    if ($result->num_rows > 0) {
        echo json_encode(array("success" => true, 'Message' => "El usuario Existe, ¡Bienvenido al Sistema!"));
    } else {
        echo json_encode(array("Error" => true, "title" => "Usuario no Registrado", 'Message' => "El usuario no Existe, ¡Registrese por favor en el Enpoint Signup.php!"));
    }
} else {
    echo json_encode(array("Error" => true, "title" => "Error de programa.", 'Message' => 'Método de Envio,formato invalido'));
}
