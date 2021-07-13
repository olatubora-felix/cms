<?php 
    
    if(isset($_GET['edit_user'])){

       $the_user_id = $_GET['edit_user'];

       $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
       $select_user_query = mysqli_query($connection, $query);

       while($row = mysqli_fetch_assoc($select_user_query)){
        $user_id = $row["user_id"];
        $user_name = $row["user_name"];
        $user_password = $row["user_password"];
        $user_firstname = $row["user_firstname"];
        $user_lastname = $row["user_lastname"];
        $user_email = $row["user_email"];
        $user_image = $row["user_image"];
        $user_role = $row["user_role"];
        
       }

    if(isset($_POST['edit_user'])){

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];


        if(!empty($user_password)){
          $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
          $get_user_query = mysqli_query($connection,  $query_password);
          confirmQuery($get_user_query);

          $row = mysqli_fetch_array($get_user_query);
          $db_user_password = $row['user_password'];

          if($db_user_password != $user_password){
              $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
          }

          $query = "UPDATE users SET ";
          $query .= "user_name = '{$user_name }', ";
          $query .= "user_password = '{$hashed_password }', ";
          $query .= "user_firstname = '{$user_firstname }', ";
          $query .= "user_lastname = '{$user_lastname }', ";
          $query .= "user_email = '{$user_email}', ";
          $query .= "user_role = '{$user_role}' ";
          $query .= "WHERE user_id = {$the_user_id} ";
    
          $update_user = mysqli_query($connection, $query) or die("Query Failed");
          echo "<p class='alert alert-success text-white'>User Updated <a href='users.php'>View Users</a></p>";

        }  
    }

  } else {
    header('Location: index.php');
  }


?>



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
  <label for="username">Username</label>
  <input type="text" value="<?php echo $user_name; ?>" name="user_name"  class="form-control">
</div>
<div class="form-group">
  <label for="post_image">Email</label>
  <input type="text" value="<?php echo $user_email; ?>" name="user_email"  class="form-control">
</div>

<div class="form-group">
  <label for="password">Password</label>
  <input type="password" autocomplete="off" name="user_password"  class="form-control">
</div>

<div class="form-group ">
  <input name="edit_user"  class="btn btn-primary" type="submit" value="Add User" >
  
</form>