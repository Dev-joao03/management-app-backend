<?php 
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    //header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");

    //include connection
    include_once 'connection.php';


    //get information from user
    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

   
    if($data) {
        $query_user = "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)";
        $cad_user = $conn->prepare($query_user);

        $cad_user->bindParam(':name', $data['user']['name']);
        $cad_user->bindParam(':email', $data['user']['email']);
        $cad_user->bindParam(':password', $data['user']['password']);

        $cad_user->execute();

        if($cad_user->rowCount()){
            $response = [
                "erro" => false,
                "Message" => "User registered successfully",
            ];
        }else {
            $response = [
                "erro" => true,
                "Message" => "User data is not valid",
            ];
        }

    }else {
        $response = [
            "erro" => true,
            "Message" => "User data is not valid",
        ];
    }

     //response code
     http_response_code(200);

     //response json
     echo json_encode($response);

?>