<?php ob_start();?>

<!-- Grapping take info -->
<?php include ("delete_modal.php"); ?>
<?php 

    if(isset($_POST['checkBoxArray'])){



        foreach( $_POST['checkBoxArray'] as $postValueId){

           $bulk_options = $_POST['bulk_options'];

            switch ($bulk_options) {

                case 'Published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";

                    $update_to_published_status = mysqli_query($connection, $query);

                    confirmQuery($update_to_published_status);
                    break;

                    
                    case 'Draft':
                       $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
    
                        $update_to_draft_status = mysqli_query($connection, $query);
    
                        confirmQuery($update_to_draft_status);
                        break;

                    case 'Delete':
                       $query = "DELETE FROM posts  WHERE post_id = {$postValueId} ";
    
                        $update_to_delete_status = mysqli_query($connection, $query);
    
                        confirmQuery( $update_to_delete_status);
                        break;

                    case 'Clone':
                    $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}'";
                    $select_all_post = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($select_all_post)){
                        $post_category_id = $row['post_category_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_tags = $row['post_tags'];
                        $post_status = $row['post_status'];

                    }

                    if(empty($post_tags)){
                        $post_tags = "No Tages";
                    }

                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_image,post_content, post_tags,  post_status) ";
        
                    $query .= "VALUES('{$post_category_id}', '{$post_title}','{$post_author}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";

                    $copy_query = mysqli_query($connection, $query);

                    if(!$copy_query){
                        die("Query Failed" . mysqli_error($connection));
                    }

                    break;

                        
                default:
                    # code...
                    break;
            }

        }
    }

?>



<form action="" method="post">
<table class="table table-bordered table-hover">

    <div id="bulkOptionsContainer" class="col-xs-4">
        <select  class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
            <option value="Delete">Delete</option>
            <option value="Clone">Clone</option>
        </select>
    
    </div>

    <div class="col-xs-4">
        <button type="submit" name="submit" class="btn btn-success">Apply</button>
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <br>


    <br>


    <thead>
        <tr>
            <th><input type="checkbox" name="" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>User</th>
            <th>Title</th>
            <th>Categories</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comment</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Views</th>
        </tr>
    </thead>
    <tbody>
                             
    <?php 
        //Finding and Query Post From DB
        $query = "SELECT *,categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
            
        $select_posts= mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_posts)){
            $post_id = $row["post_id"];
            $post_author = $row["post_author"];
            $post_user = $row["post_user"];
            $post_title = $row["post_title"];
            $post_category_id = $row["post_category_id"];
            // $post_status = $row["post_status"];
            $post_status = $row["post_status"];
            $post_image = $row["post_image"];
            $post_tags = $row["post_tags"];
            $post_comment_count = $row["post_comment_count"];
            $post_date = $row["post_date"];
            $post_view_count = $row["post_view_count"];
            $cat_id = $row["cat_id"];
            $cat_title = $row["cat_title"];
                                
            echo "<tr>";
        ?>

            <td><input type='checkbox' class="checkBoxes" name='checkBoxArray[]' id='checkBoxe' value="<?php echo $post_id; ?>"></td>

        <?php 
            echo "<td>{$post_id}</td>";

            if(!empty($post_author)){

                echo "<td>{$post_author}</td>";

            } elseif(!empty($post_user)){
                echo "<td>{$post_user}</td>";

            }
            echo "<td>{$post_title}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td>{$post_status}</td>";
            echo "<td><img src='../images/{$post_image}' width='100'></td>";
            echo "<td>{$post_tags}</td>";
            //Comment Count
            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
            $send_comment_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($send_comment_query)){
                $comment_id = $row['comment_id'];
            }
          
           
          
            $count_comments = mysqli_num_rows($send_comment_query);
           
       
            
         
            
            echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";


            echo "<td>{$post_date}</td>";
            echo "<td><a href='../post.php?post_id={$post_id}' class='btn btn-info'>View Post</a></td>";
            echo "<td><a href='posts.php?source=edit_post&post_id={$post_id}' class='btn btn-primary'>Edit</a></td>";

            ?>

            <form action="" method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                <?php 
                    echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger'></td>";
                ?>
                
            </form>

            <?php 
           // echo "<td><a rel={$post_id} href='javascript:void(0)' class='delete_link'>Delete</a></td>";


            //echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to delete'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "<td>{$post_view_count}</td>";                     
            echo "</tr>";
            
            } ?>
    </tbody>
                    
</table>
</form>



<?php 
    if(isset($_POST['delete'])){
        if(isset($_SESSION['user_role'])){
            if(isset($_SESSION['user_role']) == 'admin'){
                $post_id = $_POST['post_id'];
        
                $query = "DELETE FROM posts WHERE  post_id = {$post_id}";
            
                $delete_post = mysqli_query($connection, $query);
                
                header("location: posts.php");
        
            }
        }
        
    }

 ?>

 <script>
    $(document).ready(function(){
       $('.delete_link').on('click', function(){

        var id = $(this).attr('rel');
        var delete_url = "posts.php?delete="+ id +" ";

        $('.modal_delete_link').attr('href', delete_url);

        $('#myModal').modal('show');
       });
    });
 </script>


