<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

$app->get('/experiments', function(Request $request, Response $response, array $args) {
    try {
        $db = new db();
        $db = $db->connect();

        $sql = 'SELECT t.id, t.server, t.client, t.created, t.config, t.repeat  ' .
               'FROM experiments t ' .
               'WHERE done = 0 ' .
               'ORDER BY created ASC ' .
               'LIMIT 1';
        $statement = $db->query($sql);
        $results = $statement->fetchAll();
        $data = array();
        foreach($results as $result) {
            $row = array();
            $row['id'] = $result['id'];
            $row['server'] = $result['server'];
            $row['client'] = $result['client'];
            $row['created'] = $result['created'];
            $row['config'] = $result['config'];
            $row['repeat'] = $result['repeat'];
            $data[] = $row;
	}
    	$response->getBody()->write(json_encode($data));
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    return $response;
});

$app->get('/nodes', function(Request $request, Response $response, array $args) {
    try {
        $db = new db();
        $db = $db->connect();

        $sql = 'SELECT * FROM nodes';
        $statement = $db->query($sql);
        $results = $statement->fetchAll();
        $data = array();
        foreach($results as $result) {
            $row = array();
            $row['id'] = $result['id'];
            $row['address'] = $result['address'];
            $row['name'] = $result['name'];
            $row['online'] = $result['online'];
            $data[] = $row;
	}
    	$response->getBody()->write(json_encode($data));
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    return $response;
});


$app->post('/results/add', function(Request $request, Response $response, array $args) {
    try {

        $id = $request->getParam('id');
        $test = $request->getParam('test');
        $data = $request->getParam('data');

        $db = new db();
        $db = $db->connect();
        
        $insert_sql = 'INSERT INTO results (id, test, data) VALUES (:id, :test, :data)';
    
        $statement = $db->prepare($insert_sql);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':test', $test);
        $statement->bindParam(':data', $data);

        $statement->execute();
        
    } catch(PDOException $e) {
        echo '{"error": "' . $e->getMessage() . '"}';
    }

    return $response;
});

$app->post('/experiments/data', function(Request $request, Response $response, array $args) {
    try {

        $id = (int)$request->getParam('id');
        $key = $request->getParam('key');
        $data = $request->getParam('data');

        $db = new db();
        $db = $db->connect();
        
        $insert_sql = 'INSERT INTO experiments_data (experiment_id, time, test, value) VALUES (:experiment_id, :time, :test, :value)';
        
        $timestamp = time();
        $statement = $db->prepare($insert_sql);
        $statement->bindParam(':experiment_id', $id);
        $statement->bindParam(':time', $timestamp);
        $statement->bindParam(':test', $key);
        $statement->bindParam(':value', $data);

        $statement->execute();
        
    } catch(PDOException $e) {
        echo '{"error": "' . $e->getMessage() . '"}';
    }

    return $response;
});

$app->post('/experiments/update', function(Request $request, Response $response, array $args) {
    try {

        $id = $request->getParam('id');
        $done = $request->getParam('done');

        $db = new db();
        $db = $db->connect();
        
        
        $sql = "UPDATE experiments SET done = :done WHERE id = :id";

        $stmtUp= $db->prepare($sql);
        $stmtUp->bindParam(':id',$id);
        $stmtUp->bindParam(':done',$done);

        $stmtUp->execute();
        
    } catch(PDOException $e) {
        echo '{"error": "' . $e->getMessage() . '"}';
    }

    return $response;
});



$app->post('/experiments/generate', function(Request $request, Response $response) {
    try {
        $db = new db();
        $db = $db->connect();
        
        $repeat = 10;

        $sql = 'SELECT a.address AS server, b.address AS client, c.test AS test ' .
               'FROM nodes a, nodes b, tests c ' .
               'WHERE a.address != b.address ' .
               'AND a.online = 1 ' .
               'AND b.online = 1 ' .
               'ORDER by rand() ' .
               'LIMIT 1';
        $insert_sql = 'INSERT INTO experiments (created, server, client, config, `repeat`) VALUES (:created ,:server, :client, :config, :repeat)';
        $statement = $db->query($sql);
        $results = $statement->fetchAll();
        foreach($results as $result) {
            $server = $result['server'];
            $client = $result['client'];
            $test = $result['test'];
            $timestamp = time();
            $statement = $db->prepare($insert_sql);
            $statement->bindParam(':server', $server);
            $statement->bindParam(':client', $client);
            $statement->bindParam(':created', $timestamp);
            $statement->bindParam(':config', $test);
            $statement->bindParam(':repeat', $repeat);
            $statement->execute();
        }
    } catch(PDOException $e) {
        echo '{"error": "' . $e->getMessage() . '"}';
    }

    return $response;
});

$app->post('/nodes/online', function(Request $request, Response $response, array $args) {
    try {

        $ipAddrNode = $request->getParam('ipAddr');

        $db = new db();
        $db = $db->connect();
        
        
        $sql = "UPDATE nodes SET last_seen = :last_seen WHERE address = :address";

        $timestamp = time();
        $stmtUp= $db->prepare($sql);
        $stmtUp->bindParam(':address',$ipAddrNode);
        $stmtUp->bindParam(':last_seen',$timestamp);

        $stmtUp->execute();
        
    } catch(PDOException $e) {
        echo '{"error": "' . $e->getMessage() . '"}';
    }

    return $response;
});

$app->post('/check', function(Request $request, Response $response, array $args) {
    try {

        $db = new db();
        $db = $db->connect();

        $sql = 'SELECT * FROM nodes';
        $statement = $db->query($sql);
        $results = $statement->fetchAll();
        $data = array();
        $now=time();
        foreach($results as $result) {
            if($result['last_seen']<$now-300){
                $sql = "UPDATE nodes SET online = 0 WHERE  id = :id";
                $stmtUp= $db->prepare($sql);
                $stmtUp->bindParam(':id',$result['id']);
        
                $stmtUp->execute();
            }

	}
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

});

$app->get('/terminate/{id}', function(Request $request, Response $response, array $args) {
    try {

        $id = $request->getAttribute('id');
        $db = new db();
        $db = $db->connect();

        $sql = "SELECT * FROM experiments WHERE id = $id AND done = 0";
        $stmt = $db->query($sql); 
        $results = $stmt->fetchAll();

        //echo(json_encode($results));
      if($results!=null){

        $response->getBody()->write("TRUE");
            
        }
        else{
            $response->getBody()->write("FALSE");
        }
	
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    return $response;
});

$app->post('/experiments/delete', function(Request $request, Response $response, array $args) {
    try {

        $db = new db();
        $db = $db->connect();

        $sql = "SELECT address FROM nodes WHERE nodes.online = 0";
        $stmt = $db->query($sql); 
        $results = $stmt->fetchAll();

        $sqlDel = 'DELETE FROM experiments WHERE done = 0 ' .
                  'AND client = :address OR server = :address';

        foreach($results as $result) {

            $address = $result['address'];
            $stmtDel= $db->prepare($sqlDel);
            $stmtDel->bindParam(':address',$address);
        
            $stmtDel->execute();

        } 
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    return $response;
});







$app->run();