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
        $query_product = "SELECT name FROM inventory WHERE name=:name";
        $result_product = $conn->prepare($query_product);
        $result_product->bindParam(':name', $data['name']);
        $result_product->execute();

        if($result_product->rowCount() == 0) {
           $new_product = "INSERT INTO inventory (name, min, max, current, idUser) VALUES (:name, :min, :max, :current, :idUser)";
           $set_product = $conn->prepare($new_product);

           $set_product->bindParam(':name', $data['name']);
           $set_product->bindParam(':min', $data['min']);
           $set_product->bindParam(':max', $data['max']);
           $set_product->bindParam(':current', $data['current']);
           $set_product->bindParam(':idUser', $data['idUser']);

           $set_product->execute();

            if($set_product->rowCount()){
                $response = [
                    "erro" => false,
                    "Message" => "product registered successfully",
                ];
            }
        } else {
            $response = [
                "erro" => true,
                "Message" => "product already registered",
            ];
        }


    }else {
        $response = [
            "erro" => true,
            "Message" => "falha ao cadastrar produto",
        ];
    }

 
    http_response_code(200);
    echo json_encode($response);

?>