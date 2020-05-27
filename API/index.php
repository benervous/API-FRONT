<?php
header('Content-type: json/application');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
require 'functions.php';
require 'connect.php';

$method= $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'];
$params = explode('/', $q);
$type = $params[0];

if(isset($params[1])){
$id = $params[1];
}
if ($method ==='GET'){
if($type === 'posts'){
if(isset($id)){

getPost($connect, $id);

}
else
{
getPosts($connect);
}

}
} elseif($method ==='POST'){
  if($type==='posts'){
    addPost($connect, $_POST);
  }
}
elseif($method === 'PATCH'){
  if($type === 'posts'){
    if(isset($id)){
      $data = file_get_contents('php://input');
      $data=json_decode($data, true);
      updatePost($connect, $id, $data);
    }

  }
}elseif($method === 'DELETE'){
  if($type === 'posts'){
    if(isset($id)){
      deletePost($connect, $id);
    }
  }
}

?>
