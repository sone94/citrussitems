<?php
require('../connection.php'); 


$stmt = $conn->prepare("INSERT INTO comments (name,email,text, approved, created_at) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssds", $name, $email, $text, $approved, $created_at);
$response = array();
$name = $_REQUEST['name']; 
$email = $_REQUEST['email'];
$text = $_REQUEST['text'];
$created_at = date('Y-m-d H:i:s');
$approved = 0;
if($stmt->execute()){
    $response['status'] = 'success';
}
else{
    $response['status'] = 'error';
}

echo json_encode($response);