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
    $clearMonthly = '';
    $clearWeekly = '';

    if($data){
        $query_financial = "SELECT idUser FROM financial WHERE idUser=:idUser";
        $result_financial = $conn->prepare($query_financial);
        $result_financial->bindParam(':idUser', $data['idUser']);
        $result_financial->execute();

        if($result_financial->rowCount() != 0) {
            if($data['monthlyGoal'] != ''){
                $query_del_monthlyGoal = "UPDATE financial SET monthlyGoal=:monthlyGoal WHERE idUser=:idUser";
                $delete_budgets = $conn->prepare($query_del_monthlyGoal);

                $delete_budgets->bindParam(':monthlyGoal', $clearMonthly);
                $delete_budgets->bindParam(':idUser', $data['idUser']);
                $delete_budgets->execute();
                $response = [
                    "erro" => false,
                    "Message" => "successfully deleted",
                ];
            }

            if($data['weeklyGoal'] != ''){
                $query_del_weeklyGoal = "UPDATE financial SET weeklyGoal=:weeklyGoal WHERE idUser=:idUser";
                $delete_weeklyGoal = $conn->prepare($query_del_weeklyGoal);

                $delete_weeklyGoal->bindParam(':weeklyGoal', $clearWeekly);
                $delete_weeklyGoal->bindParam(':idUser', $data['idUser']);
                $delete_weeklyGoal->execute();
                $response = [
                    "erro" => false,
                    "Message" => "successfully deleted",
                ];
            } 
            
            
        } else {
            $response = [
                "erro" => true,
                "Message" => "The financial does not exist in the system",
            ];
        }
        

    }else {
        $response = [
            "erro" => true,
            "Message" => "The financial does not exist in the system",
        ];
    }

 
    http_response_code(200);
    echo json_encode($response);

?>