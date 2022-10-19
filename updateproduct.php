<?php 
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");

    //include connection
    include_once 'connection.php';


    //get information from user
    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){
        $select_product = "SELECT * FROM inventory WHERE name=:name AND idUser=:idUser";
        $product = $conn->prepare($select_product);
        $product->bindParam(':name', $data['name']);
        $product->bindParam(':idUser', $data['idUser']);
        $product->execute();

        if(($product) AND ($product->rowCount() != 0)) {
            $verify_new_name = "SELECT name FROM inventory WHERE name=:newName AND idUser=:idUser";
            $new_name = $conn->prepare($verify_new_name);
            $new_name->bindParam(':newName', $data['newName']);
            $new_name->bindParam(':idUser', $data['idUser']);
            $new_name->execute();


            if(($new_name->rowCount() == 0) || ($data['newName'] == $data['name'])){
                if($data['newMin'] != '') {
                    $set_minProduct = "UPDATE inventory SET min=:newMin WHERE name=:name";
                    $set_min = $conn->prepare($set_minProduct);
                    $set_min->bindParam(':newMin', $data['newMin']);
                    $set_min->bindParam(':name', $data['name']);
                    $set_min->execute();
                }
    
                if($data['newMax'] != '') {
                    $set_maxProduct = "UPDATE inventory SET max=:newMax WHERE name=:name";
                    $set_max = $conn->prepare($set_maxProduct);
                    $set_max->bindParam(':newMax', $data['newMax']);
                    $set_max->bindParam(':name', $data['name']);
                    $set_max->execute();
                }
    
                if($data['newCurrent'] != '') {
                    $set_currentProduct = "UPDATE inventory SET current=:newCurrent WHERE name=:name";
                    $set_current = $conn->prepare($set_currentProduct);
                    $set_current->bindParam(':newCurrent', $data['newCurrent']);
                    $set_current->bindParam(':name', $data['name']);
                    $set_current->execute();
                }
    
                if($data['newName'] != '') {
                    $set_nameProduct = "UPDATE inventory SET name=:newName WHERE name=:name";
                    $set_name = $conn->prepare($set_nameProduct);
                    $set_name->bindParam(':newName', $data['newName']);
                    $set_name->bindParam(':name', $data['name']);
                    $set_name->execute();
                }
    
                $response = [
                    "erro" => false,
                    "Message" => "Changes made successfully",
                ];

            }else {
                $response = [
                    "erro" => true,
                    "Message" => "This name has already been used",
                ];
            }
          
        }else {
            $response = [
                "erro" => true,"Message" => "invalid information",
            ];
        }
    } else {
        $response = [
            "erro" => true,
            "Message" => "invalid information",
        ];
    }

    //response code
    http_response_code(200);

    //response json
    echo json_encode($response);

?>