<?php include("./includes/admin_header.php");?>


    <div id="wrapper">  
       <!-- Navigation -->
<?php include("./includes/admin_navigation.php");?>
       
        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Welcome 
                            <small>Author</small>
                        </h1>    
                        <div class="col-xs-6">
                            <!--Create Query DB  -->
                            <?php inserCategories();?>
                        <!-- Start Form Categories -->
                            <form action="categories.php" method="POST">
                                <div class="form-group">
                                  <label for="cate_title">Add Category</label>
                                  <input type="text" name="cat_title" class="form-control">
                                </div>
                                <div class="form-group">
                                  <input type="submit" name="submit" class="btn btn-primary" value="Add Category">
                                </div>
                            </form>
                            
                            <!-- Update Categories -->
                          <?php updateCategories(); ?>
                          
                            </div>
                        
                        <!-- Categories Table -->
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Query / Find All Categories  From the DB -->
                                    <?php findAllCategories();?>
                                       <!-- Delete Query From DB -->
                                    <?php deleteCategories() ?>
                                </tbody>
                            </table>
                        </div> 
                        
                        <!-- Table   -->
                    </div> 
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    
    <!-- Footer -->
<?php include("./includes/admin_footer.php");?>
  
