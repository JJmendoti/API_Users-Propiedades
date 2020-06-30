<?php

//enpoint
//http://localhost:81/parcial3/Signup.php

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    include_once('db_connection.php');
    $request = file_get_contents('php://input');
    $data = json_decode($request);
    //validar que el dato exista y no enviar datos vacios a la BD

    $type_id = "";
    $identification = "";
    $name = "";
    $lastname = "";
    $email = "";
    $password = "";

    if (isset($data->type_id) && isset($data->identification) && isset($data->name) && isset($data->lastname) && isset($data->email) && isset($data->password)) {
        $type_id = $data->type_id;
        $identification = $data->identification;
        $name = $data->name;
        $lastname = $data->lastname;
        $email = $data->email;
        $password = $data->password;

        if ($type_id == "" ||  $identification == "" || $name == "" || $lastname == "" || $email == "" || $password == "") {
            echo json_encode(array("Error" => true, "title" => "Campo vacio", 'Message' => 'formato invalido, hay un campo vacio o tiene datos invalidos. Por favor valide'));
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array("Error" => true, "title" => "Campo Email invalido", 'Message' => 'formato invalido, El email debe tener @ y una extensión'));
        } elseif (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.(COM|NET|com|net)/", $email)) {
            echo json_encode(array("Error" => true, "title" => "Campo email debe tener una extensión", 'Message' => 'formato invalido, El email debe tener la extensión .com O .net, valide por favor'));
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $name) || strlen($name) > 40) {
            echo json_encode(array("Error" => true, "title" => "Campo Name invalido", 'Message' => 'formato invalido, El nombre supera los 40 caracteres y no debe tener caracteres especiales, Por favor valide'));
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $lastname) || strlen($lastname) > 40) {
            echo json_encode(array("Error" => true, "title" => "Campo Lastname invalido", 'Message' => 'formato invalido, El lastname supera los 40 caracteres y no debe tener caracteres especiales, Por favor valide'));
        } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z¡@#$%&?¿!]{8,16}$/', $password)) {
            echo json_encode(array("Error" => true, "title" => "Campo Password invalido", 'Message' => 'formato invalido, El password  debe tener entre 8 y 16 caracteres, almenos un número y 2 caracteres especiales ¡@#$%&?¿!'));
        } elseif ($type_id == "PAS" || $type_id == "pas" || $type_id == "Pas") {
            if (strlen($identification) > 10) {

                echo json_encode(array("Error" => true, "title" => "Identificación pasporte invalida",  'Message' => 'formato invalido, La identificacion para pasaporte supera los 10 caracteres permitidos. Por favor valide'));
            } else {

                $sql = "SELECT * FROM users WHERE identification='{$identification}'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo json_encode(array('Error' => true, "title" => "Usuario ya existe", 'Message' => 'Por favor verifique la identificación con la que se intenta registrar ya existe'));
                } else {

                    // query para enviar datos a la DB
                    $sql = "INSERT INTO  users (type_id,identification,name,lastname,email,password) VALUES ('{$type_id}','{$identification}','{$name}','{$lastname}','{$email}','{$password}')";
                    $result = $conn->query($sql);

                    echo json_encode(array('success' => true, 'Message' => 'Usuario agregado exitosamente', "Error" => false));
                }
            }
        } else if ($type_id == "CC" || $type_id == "cc" || $type_id == "Cc") {

            if (is_numeric($identification)) {
                $sql = "SELECT * FROM users WHERE identification='{$identification}'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo json_encode(array('Error' => true, "title" => "Usuario ya existe", 'Message' => 'Por favor verifique la identificación con la que se intenta registrar ya existe'));
                } else {

                    // query para enviar datos a la DB
                    $sql = "INSERT INTO  users (type_id,identification,name,lastname,email,password) VALUES ('{$type_id}','{$identification}','{$name}','{$lastname}','{$email}','{$password}')";
                    $result = $conn->query($sql);

                    echo json_encode(array('success' => true, 'Message' => 'Usuario agregado exitosamente', "Error" => false));
                }
            } else {

                echo json_encode(array("Error" => true, "title" => "Identificación Cédula invalida",  'Message' => 'formato invalido, La identificacion no puede tener letras. Por favor valide'));
            }
        } else {
            echo json_encode(array("Error" => true, "title" => "Tipo de Identificación Invalido.", 'Message' => 'formato invalido, el tipo de identificación no es valido'));
        }
    }
} else {
    echo json_encode(array("Error" => true, "title" => "Error de programa.", 'Message' => 'Método de Envio,formato invalido'));
}
