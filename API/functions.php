
<?php


function getPosts($connect){
$posts = mysqli_query($connect, "SELECT * FROM `api`");
$postsList=[];
while($post = mysqli_fetch_assoc($posts)){
  $postsList[]=$post;
}
echo json_encode($postsList);
}


function getPost($connect, $id){
  $post = mysqli_query($connect, "SELECT * FROM `api` WHERE `id` = '$id' ");
  if(mysqli_num_rows($post)===0){
    http_response_code(404);
 $res=[
   "status" => false,
   "message" => "Post not found"
 ];
 echo json_encode($res);
  }
  else
  {
  $post = mysqli_fetch_assoc($post);
  echo json_encode($post);
}
}

function addPost($connect, $data){
  $title =$data['title'];
  $body =$data['body'];
mysqli_query($connect, "INSERT INTO `api` (`id`, `title`, `body`) VALUES (NULL, '$title', '$body')");
http_response_code(201);
  $res=[
    "status" => true,
    "post_id" => mysqli_insert_id($connect)
  ];
echo json_encode($res);

}

function updatePost($connect, $id, $data){
  $body = $data['body'];
  $title= $data['title'];
  mysqli_query($connect, "UPDATE `api` SET `id` = '$id', `title` = '$title', `body` = '$body' WHERE `api`.`id` = '$id'");
  http_response_code(200);
  $res=[
    'id' => $id,
      'connect' => $connect,
      'data' => $data,
    "status" => true,
    "message" => "Post is updated"
  ];
echo json_encode($res);

}

function deletePost($connect, $id){
  mysqli_query($connect, "DELETE FROM `api` WHERE `api`.`id` = '$id'");
  http_response_code(200);
  $res=[
    "status" => true,
    "message" => "Post is deleted"
  ];
echo json_encode($res);
}
