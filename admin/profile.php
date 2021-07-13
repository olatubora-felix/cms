<?php include("./includes/admin_header.php");?>

<?php 
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE user_name = '{$username}'";

    $select_user_profile_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_array($select_user_profile_query)){

       echo $user_id = $row["user_id"];
        $user_name = $row["user_name"];
        $user_password = $row["user_password"];
        $user_firstname = $row["user_firstname"];
        $user_lastname = $row["user_lastname"];
        $user_email = $row["user_email"];
        $user_image = $row["user_image"];
        $user_role = $row["user_role"];
    }
}


?>


<?php 

if(isset($_POST['update_user'])){

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    
    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];
    


    
    // move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "UPDATE users SET ";
    $query .= "user_password = '{$user_password }', ";
    $query .= "user_firstname = '{$user_firstname }', ";
    $query .= "user_lastname = '{$user_lastname }', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_role = '{$user_role}' ";
    $query .= "WHERE user_name = '{$username}' ";

    $update_user = mysqli_query($connection, $query) or die("Query Failed");

   
}



?>





    <div id="wrapper">  
       <!-- Navigation -->
<?php include("./includes/admin_navigation.php");?>
       
<div id="page-wrapper">

    <div class="container-fluid">
                <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                        <h1 class="page-header">
                           Welcome 
                            <small>Author</small>
                        </h1>


                        <form action="" method="POST" enctype="multipart/form-data">
<div class="form-group">
  <label for="firstname">Firstname</label>
  <input type="text" value="<?php echo $user_firstname; ?>" name="user_firstname"  class="form-control">
</div>
<div class="form-group">
  <label for="lastname">Lastname</label>
  <input type="text" value="<?php echo $user_lastname; ?>" name="user_lastname"  class="form-control">
</div>



<div class="form-group">
  <select name="user_role" id="user_role">
          <option value="subscriber"><?php echo $user_role; ?></option>
          <?php 
            if($user_role == 'admin'){
              
              echo "<option value='subscriber'>subscriber</option>";
            } else {

            echo " <option value='admin'>admin</option>";

            }
            
        ?>
  </select>
</div>


<div class="form-group">
  <label for="username">Username</label>
  <input type="text" value="<?php echo $user_name; ?>" name="user_name"  class="form-control">
</div>
<div class="form-group">
  <label for="post_image">Email</label>
  <input type="text" value="<?php echo $user_email; ?>" name="user_email"  class="form-control">
</div>

<div class="form-group">
  <label for="password">Password</label>
  <input type="text" value="<?php echo $user_password; ?>" name="user_password"  class="form-control">
</div>

<div class="form-group ">
  <input name="update_user"  class="btn btn-primary" type="submit" value="Update Profile" >
  
</form>
            </div> 
        </div>
                <!-- /.row -->

</div>
            <!-- /.container-fluid -->
</div>
        <!-- /#page-wrapper -->
</div>
    <!-- /#wrapper -->
    
    <!-- Footer -->
<?php include("./includes/admin_footer.php");?>
  
