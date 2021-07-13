<? include("./includes/db.php") ?>
<? //include("../admin/functions.php") ?>


<?php

		
		


		if(ifIsMethod('post')){

			if(isset($_POST['username']) && isset($_POST['password'])){

				login_user($_POST['username'], $_POST['password']);


			}else {


				redirect('/cms/login');
			}

		}






?>



<div class="col-md-4">
<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>
    <form action="search.php" method="post">
    <div class="input-group">
        <input type="search" name="search" class="form-control">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit" name="submit">
                <span class="glyphicon glyphicon-search"></span>
        </button>
        </span>
    </div>
    </form>  
    <!-- Search Form -->
    <!-- /.input-group -->
</div>


<!-- Login Section-->
                  
                      <?php  if(isset($_SESSION['user_role'])) :?>
                        <div class="well">
                        <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
                            <a href="includes/logout.php" class="btn btn-primary">Logout</a>
                        </div>
                            
                        <?php else: ?>
                            <div class="well">
                        <h4>Login</h4>
                            <form  method="post">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Enter Username">
                                </div>
                            <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>
                                <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
                        </form>  
                        <a href="/cms/forgot.php">Forgotten Password</a>
                            <!-- Search Form -->
                            <!-- /.input-group -->
                        </div>

                         
                     <?php endif ?>
                  
                    
             


<!-- Blog Categories Well -->
    <div class="well">
    <h4>Blog Categories</h4>
    <?php 
                    
        $query = "SELECT * FROM categories";
                    
        $select_sidebar_categories= mysqli_query($connection, $query);
    
    ?>

    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
            
                <?php 
                    while($row = mysqli_fetch_array($select_sidebar_categories)){
                        $cat_title = $row["cat_title"];
                        $cat_id = $row["cat_id"];
                            
                        echo "<li> <a href='category.php?category= $cat_id'> $cat_title </a><li/>";
                    } 
                
                ?>
            </ul>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<?php include("./includes/widget.php"); ?>

</div>
