<!-- Header Section -->
<?php include ("./includes/header.php");?>
  <!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

 

 <?php 
//  Register User
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $username = escape($_POST['username']);
        $email =    escape($_POST['email']);
        $password = escape($_POST['password']);

        $error = [
            'username' => '',
            'email' => '',
            'password' => ''
        ];

        if(strlen($username) < 5){
            $error['username'] = 'Username too short ';
        }

        if(empty($username)){
            $error['username'] = 'Username cannot be empty ';
        }

        if(username_exists($username)){
            $error['username'] = 'Username is already exist';
        }


        if(empty($email)){
            $error['email'] = 'Email cannot be empty ';
        }

        if(email_exists($email)){
            $error['email'] = "Email is already exist, <a href='index.php'>Please login</a>";
        }

        if(strlen($password) < 8 ){
            $error['password'] = 'Password must be at least 8 Char';
        }

        if(empty($password)){
            $error['password'] = 'Password cannot be empty ';
        }

        foreach($error as $key => $value){
            if(empty($value)){
                unset($error[$key]);
            }
        }//foreach

        if(empty($error)){

            //Register Function
            register_user($username, $email, $password);
            login_user($username, $password);
            redirect('../cms/admin');
        }

       
    } 
 ?>









  
    
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       <?php //echo  $message; ?>

                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                            autocomplete="on"
                                value="<?php echo isset($username) ? $username : ''  ?>"
                            >  
                            <small class="text-danger"><?php echo isset($error['username']) ? $error['username'] : ''  ?></small>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" 
                            value="<?php echo isset($email) ? $email : ''  ?>"
                            >
                            <small class="text-danger"><?php echo isset($error['email']) ? $error['email'] : ''  ?></small>
                        </div>

                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <small class="text-danger"><?php echo isset($error['password']) ? $error['password'] : ''  ?></small>
                        </div>
                
                        <input type="submit" name="resgister" id="btn-login" class="btn btn-primary btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
