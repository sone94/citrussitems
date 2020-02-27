<?php
    include("../connection.php");

    $id = $_REQUEST['id'];
    $type = $_REQUEST['type'];

    if($type == 'Approved'){
        $query = "UPDATE comments SET approved = 0 WHERE id =".$id;
        $returnType = 'NotApproved';
    }
    else if($type == 'NotApproved'){
        $query = "UPDATE comments SET approved = 1 WHERE id =".$id;
        $returnType="Approved";
    }

    if($id != '') {
        $result = $conn->query($query);

        if($result){
            echo ($returnType);
        }
        else{
            echo ("Error has happened");
        }

    }


?>