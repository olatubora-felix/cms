

<?php 
      if(isset($_GET['post_id'])){

        $post_id = $_GET['post_id'];
     
 
       $query = "SELECT * FROM posts WHERE post_id= '{$post_id}'";
                
        $select_posts= mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row["post_id"];
        $post_user = $row["post_user"];
        $post_title = $row["post_title"];
        $post_category_id = $row["post_category_id"];
        $post_status = $row["post_status"];
        $post_status = $row["post_status"];
        $post_image = $row["post_image"];
        $post_tags = $row["post_tags"];
        $post_content = $row["post_content"];
        $post_comment_count = $row["post_comment_count"];
        $post_date = $row["post_date"];
     
     }}

    if(isset($_POST['update_post'])){
      $post_title = $_POST['post_title'];
      $post_user = $_POST['post_user'];
      $post_category_id = $_POST['post_category_id'];
      $post_status = $_POST['post_status'];
      $post_image = $_FILES['image']['name'];
      $post_image_temp = $_FILES['image']['tmp_name'];
      $post_content = $_POST['post_content'];
      $post_tags = $_POST['post_tags'];

      move_uploaded_file($post_image_temp, "../images/$post_image");

      if(empty($post_image)){

        $query = "SELECT * FROM posts WHERE post_id = '{$post_id}' ";

        $select_image = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($select_image)){
          $post_image = $row['post_image'];

        }

      }

      $query = "UPDATE posts SET ";
      $query .= "post_title = '{$post_title }', ";
      $query .= "post_date =  Now(), ";
      $query .= "post_category_id = '{$post_category_id }', ";
      $query .= "post_user = '{$post_user}', ";
      $query .= "post_status = '{$post_status}', ";
      $query .= "post_image = '{$post_image}', ";
      $query .= "post_content = '{$post_content}', ";
      $query .= "post_tags = '{$post_tags}' ";
      $query .= "WHERE post_id = {$post_id} ";

      $update_post = mysqli_query($connection, $query);

      confirmQuery($update_post);
      echo "<p class='alert alert-success text-white'>Post Updated. <a href='../post.php?post_id={$post_id}'>View Post</a> Or <a href='posts.php'>Edit More Posts</a></p>";
      
    }

 ?>




<form action="" method="POST" enctype="multipart/form-data">

<div class="form-group">
  <label for="title">Post Title</label>
  <input value="<?php echo  $post_title; ?>" type="text" name="post_title"  class="form-control">
</div>

<div class="form-group">
  <label for="category">Category User</label><br>
  <select name="post_category_id" id="post_category">
  
  <?php 
  
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
    confirmQuery($select_categories);

     while($row = mysqli_fetch_assoc($select_categories)){
       $cat_id = $row["cat_id"];
       $cat_title = $row["cat_title"];
       
       echo "<option value='{$cat_id}'>{$cat_title}</option>";
       
     }
   ?>
 
  </select>
</div>

<div class="form-group">
  <label for="post_author">User</label><br>
  <select name="post_user" id="post_user" class="selectpicker" data-stylesheet="btn-info ">
  <?php  echo "<option value='{$post_user}'>{$post_user}</option>"; ?>
  
  <?php 
  
    $query = "SELECT * FROM users WHERE user_role = 'admin'";
    $select_user = mysqli_query($connection, $query);
    confirmQuery($select_user);

     while($row = mysqli_fetch_assoc($select_user)){
       $user_name = $row["user_name"];
       
       echo "<option value='{$user_name}'>{$user_name}</option>";
       
     }
   ?>
 
  </select>
</div>

<div class="form-group">
  <select name="post_status" id="">
    <option value='<?php echo $post_status;?>'><?php echo $post_status;?></option>

    <?php 
      if($post_status == 'Published'){
        echo "<option value='Draft'>Draft</option>";
      } else {
          echo "<option value='Published'>Published</option>";
      }
    ?>
  </select>
</div>



<div class="form-group">
    <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
    <input type="file" name="image"  class="form-control">
</div>
<div class="form-group">
  <label for="post_tags">Post Tags</label>
  <input value="<?php echo $post_tags; ?>"  type="text" name="post_tags"  class="form-control">
</div>
<div class="form-group">
  <label for="post_content">Post Content</label>
  <textarea name="post_content"  class="form-control" id="body"  cols="30" rows="10">
            <?php echo str_replace('\r\n', '</br>', $post_content); ?>
  </textarea>
</div>

<div class="form-group ">
  <input name="update_post"  class="btn btn-primary" type="submit" value="Update Post" >
  
</form>
