<?php 
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    //header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
  
    //include connection
    include_once 'connection.php';

    //get information from user to login
    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){
        $query_product = "SELECT * FROM inventory WHERE idUser=:idUser";
        $result_product = $conn->prepare($query_product);
        $result_product->bindParam(':idUser', $data['idUser']);
        $result_product->execute();

        if(($result_product) AND ($result_product->rowCount() != 0)) {
            $row_product = $result_product->fetchAll(PDO::FETCH_ASSOC);

            $response = [
                "erro" => false,
                "Message" => "retorno",
                "products" => $row_product
            ];

           
        } else {
            $response = [
                "erro" => true,
                "Message" => "failed to restore products"
            ];
           
        }


    }else {
        $response = [
            "erro" => true,
            "Message" => "failed to restore products",
        ];
    }

 
    http_response_code(200);
    echo json_encode($response);

?>