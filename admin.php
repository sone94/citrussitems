<!DOCTYPE html>
<html>
    <head>
        <?php require_once('head.php'); ?>
    </head>
    <?php require_once('navbar.php'); ?>
<?php
    include('connection.php');

    $query = "SELECT * FROM comments";

    $result = $conn->query($query);

    $i = 1;
?>
    <body>
    <div class="container">
        <h2>List of comments</h2>
        <table class="table" id="comments">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Comment</th>
                <th scope="col">Posted</th>
                <th scope="col">Is approved</th>
                </tr>
            </thead>
            <tbody>
                    <?php if($result->num_rows > 0) {
                        while($row = $result->fetch_array()){
                            echo "<tr>
                                    <td>".$i."</td>
                                    <td>".$row['name']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['text']."</td>
                                    <td>".$row['created_at']."</td>
                                    <td>";
                                        if($row['approved'] == 0){
                                            echo "<button class='btn btn-danger approveComment' type='button' id='".$row['id']."' data-type='NotApproved'  value='".$row['id']."'>Not Approved</button>";
                                        }
                                        else if($row['approved'] == 1)
                                            echo "<button class='btn btn-success approveComment' type='button' id='".$row['id']."' data-type='Approved'  value='".$row['id']."'>Approved</button>";
                                    echo "</td>
                                </tr>";
                            $i++;
                        }
                    } ?>
            </tbody>
        </table>
</div>
    <script type="text/javascript">
        $(".approveComment").click(function(){
            var id = $(this).val();
            var type = $(this).data('type');

            $.ajax({
                method:'POST',
                url:'js/ajxCommentApprove.php',
                data:{
                    'id': id,
                    'type' : type
                    },
                success: function(data){
             
                    if(data === "Approved"){
                        //alert(1);
                        $('#'+id).removeClass('btn-danger');
                        $('#'+id).addClass('btn-success');
                        $('#'+id).data('type','Approved');
                        $('#'+id).html('Approved');
                    }
                    else if(data === "NotApproved"){
                        //alert(2);
                        $('#'+id).removeClass('btn-success');
                        $('#'+id).addClass('btn-danger');
                        $('#'+id).data('type','NotApproved');
                        $('#'+id).html("Not Approved");
                    }
                }
            });
        });
    </script>
    </body>
</html>