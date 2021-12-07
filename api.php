<?php
    require_once 'headers.php';
    $con = new mysqli('localhost','root', '','ionic-php-crud');

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['id'])){
            $id = $con->real_escape_string($_GET['id']);
            $sql = $con->query("select * from estudante where id = '$id'");
            $data = $sql->fetch_assoc();
        }else{
            $data = array();
            
            $sql = $con->query("select * from estudante");
            while($d = $sql->fetch_assoc()){
                $data[] = $d;
            }
        
        }
        exit(json_encode($data));//json_encode( $arr, JSON_NUMERIC_CHECK );
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data  = json_decode(file_get_contents("php://input"));
        $sql = $con->query("insert into estudante (nome, quantidade, marca) values ('".$data->nome."','".$data->quantidade."','".$data->marca."')");   
        if($sql){
            $data->id = $con->insert_id;
            exit(json_encode($data));

        }else{
           exit(json_encode(array('status' => 'Deu ruim')));
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        if(isset($_GET['id'])){
            $id = $con->real_escape_string($_GET['id']);
            $data = json_decode(file_get_contents("php://input"));
            $sql = $con->query("update estudante set nome = '".$data->nome."', quantidade = '".$data->quantidade."', marca = '".$data->marca."' where id = '$id'");
            if($sql){
                exit(json_encode(array('status'=> 'successo')));
            }else{
                exit(json_encode(array('status'=> 'Deu ruim')));
            }
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        if(isset($_GET['id'])){
            $id = $con->real_escape_string($_GET['id']);
            $sql = $con->query("delete from estudante where id = '$id'");
        
            if($sql){
                exit(json_encode(array('status' => 'successo')));
            }else{
                exit(json_encode(array('status' => 'Deu ruim')));
            }
        }
    }
?>