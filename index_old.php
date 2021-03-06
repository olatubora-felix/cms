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
                    $query = "SELECT * FROM posts";
                    
                    $select_all_post = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_array($select_all_post)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'], 0, 150);
                        $post_status = $row['post_status'];

                        if($post_status == 'Published'){
                           
                        ?>
 
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>
                        <h2>
                            <a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_posts.php?author=<?php echo $post_author; ?>&post_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <a href="post.php?post_id=<?php echo $post_id; ?>">
                         <img class="img-responsive" src="./images/<?php echo $post_image;?>" alt="">
                         </a>
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>                       
                        
                    <?php   }  } ?>
                    
                  

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include("../cms/includes/sidebar.php");?>
        </div>
        <!-- /.row -->
        
        </div>

        <hr>
        <?php include("./includes/footer.php");?>

