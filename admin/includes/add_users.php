<?php 
    if(isset($_POST['create_user'])){

        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        
        
        
       //$pass = crypt($password, $salt);
       $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );

       if(!empty($user_firstname) && !empty($user_lastname) && !empty($user_role) && !empty($user_name) && !empty($user_email) && !empty($user_password)){

          // $post_image = $_FILES['image']['name'];
          // $post_image_temp = $_FILES['image']['tmp_name'];
          // move_uploaded_file($post_image_temp, "../images/$post_image");
    
          $query = "INSERT INTO users(user_firstname, user_lastname, user_role, user_name, user_email, user_password) ";
          
          $query .= "VALUES('{$user_firstname }', '{$user_lastname}',  '{$user_role}', '{$user_name}', '{$user_email}', '{$user_password}') ";
          
          $create_users = mysqli_query($connection, $query);
          
          confirmQuery($create_users);
  
          echo "<div class='alert alert-success'>User Created: " . " " . "<a href='users.php'>View users</a></div>";
       } 

    }


?>



<form action="" method="POST" enctype="multipart/form-data">
<div class="form-group">
  <label for="firstname">Firstname</label>
  <input type="text" name="user_firstname"  class="form-control">
</div>
<div class="form-group">
  <label for="lastname">Lastname</label>
  <input type="text" name="user_lastname"  class="form-control">
</div>



<div class="form-group">
  <select name="user_role" id="user_role">
      <option value="subscriber">Select Option</option>
      <option value="admin" selected>Admin</option>
      <option value="subscriber" selected>Subscriber</option>
  </select>
</div>


<div class="form-group">
  <label for="username">Username</label>
  <input type="text" name="user_name"  class="form-control">
</div>
<div class="form-group">
  <label for="post_image">Email</label>
  <input type="text" name="user_email"  class="form-control">
</div>

<div class="form-group">
  <label for="password">Password</label>
  <input type="password" name="user_password"  class="form-control">
</div>

<div class="form-group ">
  <input name="create_user"  class="btn btn-primary" type="submit" value="Add User" >
  
</form>