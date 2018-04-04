<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get all customers
$app->get('api/customers', function(Request $request, Response $response){
    
     $sql = "SELECT * from customers";

     try{
         //get db object
         $db = new db();
         //connect
         $db = $db->connect();

         $stmt = $db->query($sql);
         $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
         $db =null;
         echo json_encode($customers);


     }catch(PDOException $e){
         echo '{eroor": {text": '.$e->getMessage().'}';
     }

});


$app->post('/customers/add', function(Request $request, Response $response){

    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $city = $request->getParam('city');
    

    
    $sql = "INSERT INTO customers (first_name,last_name,city) VALUES (:first_name,:last_name,:city)";

    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':city',$city);
        

        $stmt->execute();

        echo'{"notice": {"text": "customer added"}';
        

    }catch(PDOException $e){
        echo '{eroor": {text": '.$e->getMessage().'}';
    }

});
