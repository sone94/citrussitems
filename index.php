<?php require('connection.php'); ?>
<html>
    <head>
        <?php require_once('head.php'); ?>
    </head>
    <body>
<?php require_once('navbar.php'); ?>
        <?php $sql = "SELECT * FROM products p INNER JOIN images i ON p.image_id = i.id";

        $result = $conn->query($sql);
        $i = 0;
        if($result->num_rows > 0){
            $products =  "<div class='container'><div class='row' style='margin 0 auto;'>";
            while($row = $result->fetch_array()){
                if($i > 2){
                    $products.= "</div><div class='row' >";
                    $i = 0;
                }
                $i++;
            $products.= "<div class='column' style='margin:5px;'> 
                            <img src=".$row['src']." width='150' height='150'/><br/>
                            ".$row['title']."<br/>
                            ".$row['description']."<br/>
                            </div>";
                        
            }

            $products.="</div>";
        }
        $products.= "</div>";
        echo $products;
        ?>

<?php
  $queryComment = "SELECT * FROM comments WHERE approved = 1 ORDER BY created_at DESC";
  $resultComment = $conn->query($queryComment);

  $iTotalComments = mysqli_num_rows($resultComment);

?>


<div class="container">
            <div class="row">
                <div class="col-md-8">
                  <div class="page-header">
                    <h1><small class="pull-right">comments(<?php echo $iTotalComments;  ?>)</small> Comments </h1>
                  </div> 
                   <div class="comments-list">
                   <?php if($iTotalComments > 0){
                     while($row = $resultComment->fetch_array()) { ?>
                      <div class="row">
                          <div class="col-8">
                              <div class="card card-white post">
                                  <div class="post-heading">
                                      <div class="float-left image">
                                          <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">
                                      </div>
                                      <div class="float-left meta">
                                          <div class="title h5">
                                              <a href="#"><b><?php echo $row['name']; ?></b></a>
                                              made a post.
                                          </div>
                                          <h6 class="text-muted time"><?php echo date('d.m.Y H:i', strtotime($row['created_at'])); ?></h6>
                                      </div>
                                  </div> 
                                  <div class="post-description"> 
                                      <p><?php echo $row['text']; ?></p>

                                  </div>
                              </div>
                          </div>
                          
                      </div>
                      <br/>
                     <?php }} ?>

                    <h3>Add comment</h3>
                   <form>
                    <div class="form-group">
                        <label for="txtEmail">Email address</label>
                        <input type="txtEmail" class="form-control" id="txtEmail" aria-describedby="emailHelp" placeholder="Enter email">
                        <span id="err-email" class="red hidden">Wrong email format*</span>
                    </div>
                    <div class="form-group">
                        <label for="txtName">Name</label>
                        <input type="text" class="form-control" id="txtName" placeholder="Name">
                        <span id="err-name" class="red hidden">This field is required*</span>
                    </div>
                    <div class="form-group">
                        <label for="taText">Text</label>
                        <textarea class="form-control" id='taText' name="taText" placeholder="Enter text"></textarea>
                        <span id="err-text" class="red hidden">This field is required*</span>
                    </div>
                    <button type="button" id="btnSubmit" class="btn btn-primary">Submit</button>
                </form>
                <div class="alert alert-success hidden" id="successMessage" role="alert">
                    Your comment has been sucessfully added, and it waits for the administrator for approve.
                </div>
                <div class="alert alert-error hidden" id="errorMessage" role="alert">
                    There was an error.
                </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">

        function isEmail(email) {
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          
          
          if(regex.test(email) == false) {
            $('#err-email').removeClass('hidden');
            return false;
          }
          else{
            $('#err-email').addClass('hidden'); // *** this line have been added ***
                  return true;
          }
        }
          function HasName() {
              var name=$('#txtName').val();
              if(name.length == 0){
                $('#err-name').removeClass('hidden');
              }
              else {
                $('#err-name').addClass('hidden'); // *** this line have been added ***
                  return true;
              }
          }

          function HasText() {
              var name=$('#taText').val();
              if(name.length == 0){
                $('#err-text').removeClass('hidden');
              }
              else {
                $('#err-text').addClass('hidden'); // *** this line have been added ***
                  return true;
              }
          }



        $("#btnSubmit").click(function(){
            var email = $("#txtEmail").val();
            var name = $("#txtName").val();
            var text = $("#taText").val();


          if(isEmail(email) == true && HasName() == true && HasText()) {

            $("#txtEmail").css('border','1px solid #555');
            //$("#err-email").css('color', 'red')
            $('#err-email').text("");
            

            $.ajax({
                url:'js/ajxInsertComment',
                dataType:"json",
                method:"POST",
                data:{
                    'email' : email,
                    'name' : name,
                    'text' : text
                },
                success:function(data){
                  if(data.status == 'success'){
                      $('#successMessage').removeClass('hidden');
                    setTimeout(function() {
                      $('#successMessage').addClass('hidden');
                    }, 5000); 
                  }
                  else if(data.status == 'error'){
                    $('#errorMessage').removeClass('hidden');
                    setTimeout(function() {
                      $('#errorMessage').addClass('hidden');
                    }, 5000);
                  }

                }
            });
          }

        });

</script>
<style type='text/css'>
.user_name{
    font-size:14px;
    font-weight: bold;
}
.comments-list .media{
    border-bottom: 1px dotted #ccc;
}

.red {
  color:red;
}
</style>