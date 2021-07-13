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

                    if(isset($_GET['post_id'])){
                        $post_id =$_GET['post_id'];
                        $post_user = $_GET['user'];
                    


                    $query = "SELECT * FROM posts WHERE post_user = '{$post_user}' AND post_status = 'Published'";
                    
                    $select_all_post = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_array($select_all_post)){
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        
                        
                        ?>
                        
                        
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>
                        <h2>
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead text-warning">
                            All Posts By <?php echo $post_user; ?>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="./images/<?php echo $post_image;?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>                   
                        
                    <?php   }} ?>  
                                
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include("../cms/includes/sidebar.php");?>
        </div>
        <!-- /.row -->
        
        </div>

        <hr>
        <?php include("./includes/footer.php");?>

