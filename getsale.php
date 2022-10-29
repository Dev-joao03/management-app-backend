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
        $query_sales = "SELECT * FROM sales WHERE idUser=:idUser";
        $result_sales = $conn->prepare($query_sales);
        $result_sales->bindParam(':idUser', $data['idUser']);
        $result_sales->execute();

        if(($result_sales) AND ($result_sales->rowCount() != 0)) {
            $row_sales = $result_sales->fetchAll(PDO::FETCH_ASSOC);

            $response = [
                "erro" => false,
                "Message" => "successful sales",
                "sales" => $row_sales
            ];

           
        } else {
            $response = [
                "erro" => true,
                "Message" => "failed to restore sales"
            ];
           
        }


    }else {
        $response = [
            "erro" => true,
            "Message" => "failed to restore sales",
        ];
    }

 
    http_response_code(200);
    echo json_encode($response);

?>