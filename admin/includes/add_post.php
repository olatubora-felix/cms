<?php 
    if(isset($_POST['create_post'])){

        $post_title = escape($_POST['title']);
        $post_user = escape($_POST['post_user']);
        $post_category_id = escape($_POST['post_category_id']);
        $post_status = escape($_POST['post_status']);
        
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        
        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);
        $post_date= date('d-m-y');
    


        
        move_uploaded_file($post_image_temp, "../images/$post_image");
  
        $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image,post_content, post_tags,  post_status) ";
        
        $query .= "VALUES('{$post_category_id}', '{$post_title}','{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
        
        $create_post = mysqli_query($connection, $query);
       
        confirmQuery($create_post);

        $post_id = mysqli_insert_id($connection);
        echo "<p class='alert alert-success text-white'>Post Added. <a href='../post.php?post_id={$post_id}'>View Post</a> Or <a href='posts.php'>Edit More Posts</a></p>";
    }


?>


<form action="" method="POST" enctype="multipart/form-data">

<div class="form-group">
  <label for="title">Post Title</label>
  <input type="text" name="title"  class="form-control">
</div>

<div class="form-group">
  <label for="title">Category</label><br>
  <select name="post_category_id" id="post_category" class="selectpicker" data-stylesheet="btn-info ">
  
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
  <label for="post_author">Post Author</label><br>
  <select name="post_user" id="post_author" class="selectpicker" data-stylesheet="btn-info ">
  <option value="">Select Author</option>
  <?php 
  
    $query = "SELECT * FROM users WHERE user_role = 'admin'";
    $select_author = mysqli_query($connection, $query);
    confirmQuery($select_author);

     while($row = mysqli_fetch_assoc($select_author)){
       $user_id = $row["user_id"];
       $user_author = $row["user_name"];
       
       echo "<option value='{$user_author}'>{$user_author}</option>";
       
     }
   ?>
 
  </select>
</div>
<div class="form-group">
  <label for="post_status" style="display:block;">Post Status</label>
  <select name="post_status" id="">
     <option value="">Select Options</option>
     <option value="Draft">Draft</option>
     <option value="Published">Published</option>
  </select>
</div>
<div class="form-group">
  <label for="post_image">Post Image</label>
  <input type="file" name="image"  class="form-control">
</div>
<div class="form-group">
  <label for="post_tags">Post Tags</label>
  <input type="text" name="post_tags"  class="form-control">
</div>
<div class="form-group">
  <label for="post_content">Post Content</label>
  <textarea  name="post_content"  class="form-control" id="body" cols="30" rows="10"></textarea>
</div>

<div class="form-group ">
  <input name="create_post"  class="btn btn-primary" type="submit" value="Publish Post" >
  
</form>