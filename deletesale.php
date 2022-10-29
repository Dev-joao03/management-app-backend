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
        $query_sales = "SELECT id FROM sales WHERE id=:id and idUser=:idUser";
        $result_sales = $conn->prepare($query_sales);
        $result_sales->bindParam(':id', $data['id']);
        $result_sales->bindParam(':idUser', $data['idUser']);
        $result_sales->execute();

        if($result_sales->rowCount() != 0) {
            $query_del_sale = "DELETE FROM sales WHERE id=:id and idUser=:idUser";
            $delete_sale = $conn->prepare($query_del_sale);

            $delete_sale->bindParam(':id', $data['id']);
            $delete_sale->bindParam(':idUser', $data['idUser']);
            $delete_sale->execute();
            $response = [
                "erro" => false,
                "Message" => "deletado com sucesso"
            ];
            
        } else {
            $response = [
                "erro" => true,
                "Message" => "The product does not exist in the system",
            ];
        }
        

    }else {
        $response = [
            "erro" => true,
            "Message" => "The product does not exist in the system",
        ];
    }

 
    http_response_code(200);
    echo json_encode($response);

?>