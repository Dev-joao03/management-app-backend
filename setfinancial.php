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
        $query_financial = "SELECT idUser FROM financial WHERE idUser=:idUser";
        $result_financial = $conn->prepare($query_financial);
        $result_financial->bindParam(':idUser', $data['idUser']);
        $result_financial->execute();

        if($result_financial->rowCount() == 0){
            $new_financial= "INSERT INTO financial (monthlyGoal, weeklyGoal, idUser) VALUES (:monthlyGoal, :weeklyGoal, :idUser)";
            $set_financial= $conn->prepare($new_financial);

            $set_financial->bindParam(':monthlyGoal', $data['monthlyGoal']);
            $set_financial->bindParam(':weeklyGoal', $data['weeklyGoal']);
            $set_financial->bindParam(':idUser', $data['idUser']);
            $set_financial->execute();
            

            $response = [
                "erro" => false,
                "Message" => "registered successfully",
            ]; 

        }else {
            if($data['monthlyGoal'] != '') {
                $set_newMonthlyGoal = "UPDATE financial SET monthlyGoal=:monthlyGoal WHERE idUser=:idUser";
                $set_monthly = $conn->prepare($set_newMonthlyGoal);
                $set_monthly->bindParam(':monthlyGoal', $data['monthlyGoal']);
                $set_monthly->bindParam(':idUser', $data['idUser']);
                $set_monthly->execute();
            }

            if($data['weeklyGoal'] != '') {
                $set_newWeeklyGoal = "UPDATE financial SET weeklyGoal=:weeklyGoal WHERE idUser=:idUser";
                $set_monthly = $conn->prepare($set_newWeeklyGoal);
                $set_monthly->bindParam(':weeklyGoal', $data['weeklyGoal']);
                $set_monthly->bindParam(':idUser', $data['idUser']);
                $set_monthly->execute();
            }

            $response = [
                "erro" => false,
                "Message" => "goals updated successfully",
            ]; 
        }


    } else {
        $response = [
            "erro" => true,
            "Message" => "product already registered",
        ];  
    }
    


    http_response_code(200);
    echo json_encode($response);

?>