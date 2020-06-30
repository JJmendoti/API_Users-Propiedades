

<?php
//- Obtiene las propiedades de todos los usuarios, pero en orden de precio.
//Enpoint_getSortedProperties.php
//http://localhost:81/parcial3/getSortedProperties.php
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    include_once('db_connection.php');
    $request = file_get_contents('php://input');
    $data = json_decode($request);
    $sql = "SELECT * FROM properties order by price desc";
    $result = $conn->query(($sql));
    $properties = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
        echo json_encode(array('success' => true, 'properties' => $properties, 'Error' => false));
    }
}else {
    echo json_encode(array("Error" => true, "title" => "Error de programa.", 'Message' => 'Método de Envio,formato invalido'));
}

?>