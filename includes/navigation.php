<!-- DataBase Connection -->
<?php
 session_start();
  include "./admin/function.php";
 ?>


<!-- Navigation Section -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            <!-- Read And Query Data from DB -->
                <?php 
                    
                    $query = "SELECT * FROM categories";
                    
                    $select_all_categories = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_array($select_all_categories)){
                        $cat_title = $row["cat_title"];
                       $cat_id = $row["cat_id"];

                       $category_class = '';
                       $registration_class = '';
                       $contact_class = '';
                       $login_class = '';

                       $pageName = basename($_SERVER['PHP_SELF']);
                       $registration = 'registration.php';
                       $contact = 'contact.php';
                       $login = 'login.php';

                       if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                           $category_class = 'active';
                       } else if($pageName ==  $registration){

                        $registration_class = 'active';

                       } else if($pageName ==  $contact){
                            $contact_class = 'active';
                       } else if($pageName ==  $login ){
                            $login_class = 'active';
                       }
                        
                        echo "<li class='$category_class'> <a href='/cms/category/{$cat_id}'> $cat_title </a><li/>";
                    };
                    
                ?>

                
                    <li class="<?php echo $contact_class ?>"><a href="/cms/contact">Contact</a></li>

                <?php 
                    if(isset($_SESSION['user_role'])){

                        if(isset($_GET['post_id'])){

                            $post_id = $_GET['post_id'];

                            echo "<li><a href='/cms/admin/posts.php?source=edit_post&post_id={$post_id}'>Edit Post</a></li>";
                        }
                    }
                
                ?>

                <?php  if(isLoggedIn()) :?>

                    <li><a href='/cms/admin'>Admin</a></li>
                    <li class=""><a href="includes/logout.php">Logout</a></li>

                <?php else: ?>

                <li class="<?php echo $registration_class ?>"><a href="/cms/registration">Register</a></li>
                <li class="<?php echo $login_class ?>"><a href="/cms/login">Login</a></li>
                    
                <?php endif ?>
                                
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>