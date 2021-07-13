<!-- Header Section -->
<?php include "includes/header.php";?>
  <!-- Navigation --> 
  <?php  include "includes/navigation.php"; ?>

 

 <?php 
    
    if(isset($_POST['submit'])){
        $to = 'olatubora1996@gmail.com';
        $subject = wordwrap(escape($_POST['subject']), 70);
        $body = escape($_POST['body']);
        $header = 'From'. escape($_POST['email']);

        if(!empty($to) && !empty($body) && $subject && $header){
            mail($to, $subject, $body, $header);
        } else {
            $message = "<h3 class='alert alert-danger'>Field cannot be Empty</h3>";
        }    
       
    } else {
        $message = '';
    }
 ?>









  
    
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Us</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                    <?php echo  $message ?>
                         <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" autocomplete="on" >

                        </div>
                         <div class="form-group">
                             <label for="email">Subject</label>
                            <label for="subject" class="sr-only">subject</label>
                            <input type="text" name="subject" id="key" class="form-control" placeholder="Enter Your Subject">
                        </div>
                         <div class="form-group">
                            <textarea name="body" placeholder="Drop your message " class="form-control" id="" rows="2"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Send Us Message">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
