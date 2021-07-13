<!-- Header Section -->
<?php include("./includes/header.php");?>
    <!-- Navigation -->
    <?php include("./includes/navigation.php");?>

    <?php 

        // Like 
        if(isset($_POST['liked'])){

            $post_id = $_POST['post_id'];
            $user_id = $_POST['user_id'];

            //1 = FETCHING THE  POST
            $query = "SELECT * FROM posts WHERE post_id=$post_id";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $likes = $row['likes'];

            // UPDATE POST WITH LIKES
            mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

            mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
            exit();
        }



    // Unlike
    if(isset($_POST['unliked'])){

        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //1 = FETCHING THE RIGHT POST
        $query = "SELECT * FROM posts WHERE post_id=$post_id";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        $likes = $row['likes'];

        //2. DELETE LIKES
        mysqli_query($connection, "DELETE FROM likes  WHERE post_id=$post_id AND user_id=$user_id");

        //3. DECREMENTING LIKES
        mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

        exit();
    }

    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               
                <!-- Read and Query Data from DB -->
                <?php 

                    if(isset($_GET['post_id'])){
                        $post_id = escape($_GET['post_id']);

                        $view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $post_id";
                        $send_query = mysqli_query($connection, $view_query) or die("Query Faild" . mysqli_error($connection));

                        if($_SESSION['user_role'] && $_SESSION['user_role'] = 'admin' ){

                            $query = "SELECT * FROM posts WHERE post_id={$post_id }";

                        } else {
                            $query = "SELECT * FROM posts WHERE post_id={$post_id } AND post_status = 'Published'";
                        }
                    
                        
                    
                        $select_all_post = mysqli_query($connection, $query);
                        if(numRows($select_all_post) < 1){
                            echo "<h1 class='text-center'>No Post Category Avaliable</h1>";
                        } else {
                    
                    while($row = mysqli_fetch_array($select_all_post)){
                        $post_title = $row['post_title'];
                        $post_author = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        
                        
                        ?>
                        
                        
                        <h1 class="page-header">
                           Post
                        </h1>
                        <h2>
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image);?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>


                        <hr>
                        <div class="row">
                            <p class="pull-right" style="font-size: 16px;"><a class="<?php echo userLikedThisPost($post_id) ? ' unlike ' : ' like'; ?>" href=""><span class="glyphicon glyphicon-thumbs-up"></span> <?php echo userLikedThisPost($post_id) ? 'Unlike' : 'Like'; ?></a></p>
                        </div>   
                        <div class="row">
                            <p class="pull-right">Liked: <?php getPostLikes($post_id) ?></p>
                        </div>  
                        <div class="clearfix"></div>            
                        
                    <?php   } ?>

                    
                <!-- Blog Comments -->
                   <?php 
                        if(isset($_POST['create_comment'])){

                            $the_post_id = escape( $_GET['post_id']);

                           $comment_author = $_POST['comment_author'];
                           $comment_email = $_POST['comment_email'];
                           $comment_content = $_POST['comment_content'];

                           if(!empty( $comment_author) && !empty($comment_author) && !empty($comment_content)){
                                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapprove', now() )";

                                $create_comment_query = mysqli_query($connection, $query);

                                if(!$create_comment_query){
                                    die("QUERY FAIL". mysqli_error($connection));
                                }

                                // $query = "UPDATE posts SET  post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id";

                                // $update_comment_count = mysqli_query($connection, $query);
                                header('Location:index.php');

                           } else {

                            echo "<script>alert('Field cannot be empty')</script>";

                           }


                          

                            
                           
                        }

                   
                   ?>
                        

                <!-- Comments Form -->
                <div class="well py-5">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="POST" action="">
                        <div class="form-group">
                            <label for="author">Author</label>
                           <input type="text" name="comment_author" class="form-control">
                        </div>
                        <div class="form-group">
                             <label for="email">Email</label>  
                            <input type="email" name="comment_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Your Comment">Your Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
             <?php
                 $query = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
                 $select_comment_query = mysqli_query($connection, $query);
                
                confirmQuery($select_comment_query);
                 while($row = mysqli_fetch_assoc($select_comment_query )){
                 $comment_date = $row["comment_date"];
                 $comment_content = $row["comment_content"];
                 $comment_author = $row["comment_author"];
             
             
             ?>

              <!-- Comment -->
              <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>

                    </div>
                </div>

                <?php }}} else {

                        header("Location:index.php");
                    }?>



               
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include("../cms/includes/sidebar.php");?>
        </div>
        <!-- /.row -->
        
        </div>

        <hr>
        <?php include("./includes/footer.php");?>

        <script>

            // Like Function
           $(document).ready(() => {
                var post_id = <?php echo $post_id; ?>;
                var user_id = 44;

               $('.like').on('click', () => {
                  $.ajax({
                      url: "/cms/post.php?post_id=<?php echo $post_id ?>",
                      type: 'post',
                      data: {
                          'liked': 1,
                          'post_id': post_id,
                          'user_id': user_id
                      }
                  }); 

               });
           });


            // Unlike Function
           $(document).ready(() => {
                var post_id = <?php echo $post_id; ?>;
                var user_id = 44;

               $('.unlike').on('click', () => {
                  $.ajax({
                      url: "/cms/post.php?post_id=<?php echo $post_id ?>",
                      type: 'post',
                      data: {
                          'unliked': 1,
                          'post_id': post_id,
                          'user_id': user_id
                      }
                  }); 

               });
           });

        </script>

