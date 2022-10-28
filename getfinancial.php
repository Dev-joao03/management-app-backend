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
        $query_financial = "SELECT * FROM financial WHERE idUser=:idUser";
        $result_financial = $conn->prepare($query_financial);
        $result_financial->bindParam(':idUser', $data['idUser']);
        $result_financial->execute();

        if(($result_financial) AND ($result_financial->rowCount() != 0)) {
            $row_financial = $result_financial->fetch(PDO::FETCH_ASSOC);
            extract($row_financial);
            $financial = [
                'id'=> $id,
                'monthlyGoal'=> $monthlyGoal,
                'weeklyGoal' => $weeklyGoal,
                'idUser' => $idUser
            ];

            $response = [
                "erro" => false,
                "Message" => "successfully found finance",
                "financial" => $financial
            ];

           
        } else {
            $response = [
                "erro" => true,
                "Message" => "failed to find finances"
            ];
           
        }


    }else {
        $response = [
            "erro" => true,
            "Message" => "failed to find finances",
        ];
    }

 
    http_response_code(200);
    echo json_encode($response);

?>