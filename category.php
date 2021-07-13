<!-- Header Section -->
<?php include("./includes/header.php");?>

    <!-- Navigation -->
    <?php include("./includes/navigation.php");?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <!-- Read and Query Data from DB -->
                <?php 

                    if(isset($_GET['category'])){
                        $the_category_id = $_GET['category'];

                   
                        if(is_admin($_SESSION['username'])){

                            $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");

                        } else {
                            $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");

                            $published = 'Published';
                        }
                 
                        if(isset($stmt1)){

                            mysqli_stmt_bind_param($stmt1, "i",  $the_category_id);
                            mysqli_stmt_execute($stmt1);
                            mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

                            $stmt = $stmt1;

                        } else {

                            mysqli_stmt_bind_param($stmt2, "is",  $the_category_id, $published);
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

                            $stmt = $stmt2;

                           
                        }

                        mysqli_stmt_store_result($stmt);

                        if(mysqli_stmt_num_rows($stmt) === 0){
                            echo "<h1 class='text-center'>No Post Category Avaliable</h1>";
                        }

                      

                        ?>

                       <?php while(mysqli_stmt_fetch($stmt)):?>
                            
                            <h1 class="page-header">
                                Page Heading
                                <small>Secondary Text</small>
                            </h1>
                            <h2>
                                <a href="/cms/post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="index.php"><?php echo $post_user; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                            <hr>
                            <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image);?>" alt="">
                            <hr>
                            <p><?php echo $post_content; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>  
                    
                    
                   
                                 
                        
                    <?php endwhile; mysqli_stmt_close($stmt);   } else {
                        
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

