<?php
//Obtiene las propiedades, pero de un usuario en específico y ordenadas por precio.
//enpoint_getSortedUserProperties.php
//http://localhost:81/parcial3/getSortedUserProperties.php
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    include_once('db_connection.php');
    $request = file_get_contents('php://input');
    $dataPropertie = json_decode($request);

    $id_user = $dataPropertie->id_user;
    if ($id_user == "") {

        echo json_encode(array('success' => false, 'properties' => 'El campo ID_USER ESTA VACIO, por favor valide', 'Error' => true));
    } else {

        $id_user = $dataPropertie->id_user;
        $sql = "SELECT * FROM properties WHERE id_user={$id_user} order by price desc";
        $result = $conn->query(($sql));
        $properties = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $properties[] = $row;
            }
            echo json_encode(array('success' => true, 'Message' => $properties, 'Error' => false));
        } else {

            echo json_encode(array('Error' => true, "title" => "No existen datos", 'Message' => 'No hay datos para retornar, O el Usuario no Existe '));
        }
    }
} else {
    echo json_encode(array("Error" => true, "title" => "Error de programa.", 'Message' => 'Método de Envio,formato invalido'));
}
