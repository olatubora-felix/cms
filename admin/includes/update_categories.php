  <!-- Update Form  -->
  <form action=" " method="POST">
        <div class="form-group">
          <label
           for="cate_title">Edit Category</label>
                                  
          <?php //Update Categories
                                  
          if(isset($_GET['edit'])){                           
            $cat_id= $_GET['edit'];
            $query = "SELECT * FROM categories WHERE cat_id = $cat_id  ";
            $select_categories_id = mysqli_query($connection, $query);

           while($row = mysqli_fetch_assoc($select_categories_id)){
               $cat_id = $row["cat_id"];
               $cat_title = $row["cat_title"];
           ?>
        <input value="<?php if(isset($cat_title)){ echo $cat_title; } ?>" type="text" name="cat_title" class="form-control">
                             
       <?php }} ?>
                                  
                                  
          <?php                        
            if(isset($_POST['update'])){
                $the_cat_title = escape($_POST['cat_title']);  
                $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");  
                mysqli_stmt_bind_param($stmt,'si', $the_cat_title, $cat_id);
              $execute = mysqli_stmt_execute($stmt);
                confirmQuery($execute);  
                redirect('categories.php');                 
            }                     
          ?>                      
        </div>
        <div class="form-group">
        <input type="submit" name="update" class="btn btn-primary" value="Update Category">
        </div>
    </form>
<!-- Form Category -->