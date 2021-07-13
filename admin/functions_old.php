<?php ob_start(); ?>
<?php include "/includes/db.php"; ?>
<?php 


       
    function confirmQuery($result){
        global $connection;
        
        if(!$result){
        die("QUERY FAILED" . mysqli_error($connection));
    }

    }

      // Redirect Function
    function redirect($location){

        header("Location:". $location);
        exit;
    }


    // Function Methode
    function ifIsMethod($method=null){
        if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){

            return true;
        }

        return false;
    }


    // Check for login
    function isLoggedIn(){
        if(isset($_SESSION['user_role'])){

            return true;
        }

        return false;
    }


    // Check if Logged In
    function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){

        if(isLoggedIn()){
            redirect($redirectLocation);
        }
    }



    // Mysqli Injection
    function escape($string){
        global $connection;
        return mysqli_real_escape_string($connection, trim(strip_tags($string)));
    }


    // record count
    function recordCount($table){

        global $connection;
        $query = "SELECT * FROM " . $table;

        $select_all_post = mysqli_query($connection, $query);

       $result = mysqli_num_rows($select_all_post);

       confirmQuery($result);

        return $result;

    }

    //Check Status/////
    function checkStatus($table, $column, $status){
        global $connection;
        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $result = mysqli_query($connection, $query);

        confirmQuery($result);
        return mysqli_num_rows($result);

    }

    ////Check User Role////
    function checkRole($table, $column, $role){
        global $connection;
        $query = "SELECT * FROM $table WHERE $column = '$role'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        return mysqli_num_rows($result);

    }


    // check if user is an admin
    function is_admin($username = ''){
        global $connection;
        $query = "SELECT user_role FROM users WHERE user_name = '$username'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        $row = mysqli_fetch_array($result);
        if($row['user_role'] == 'admin'){
            return true;
        } else {
            return false;
        }

    }


    // check if user exist in DB
    function username_exists($username){
        global $connection;
        $query = "SELECT user_name FROM users WHERE user_name = '$username'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        if(mysqli_num_rows($result) > 0){
            return true;
        } else {
            return false;
        }
    }

    // check if user email exist in DB
    function email_exists($email){
        global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        if(mysqli_num_rows($result) > 0){
            return true;
        } else {
            return false;
        }
    }


    // Register User////
    function register_user($username, $email, $password) {
        global $connection;
        $username = escape($_POST['username']);
        $email =    escape($_POST['email']);
        $password = escape($_POST['password']);
        
        //$pass = crypt($password, $salt);
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12) );
        $query = "INSERT INTO users (user_name, user_email, user_password, user_role) VALUES('{$username}', '{$email}', '{$password}', 'subscriber')";
        $register_user_query = mysqli_query($connection, $query);
    }


    // Login User
    function login_user($username, $password){

        global $connection;

        $username = htmlspecialchars(escape($_POST['username']));
        $password =  htmlspecialchars(escape($_POST['password']));

        $query = "SELECT * FROM users WHERE user_name= '{$username}'";
        $select_user_query = mysqli_query($connection, $query);

        confirmQuery($select_user_query);
    
        while($row = mysqli_fetch_array($select_user_query)){
            $db_user_id = $row['user_id'];
            $db_user_name = $row['user_name'];
           echo  $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            echo $db_user_role = $row['user_role'];
      
    
    
        if(password_verify($password, $db_user_password)){
    
            $_SESSION['username'] = $db_user_name;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;

            redirect('../admin');
            // header('Location: ');
        } else {
           
            redirect('/cms/index.php');
        }
        }
    }



    // Check for user online
    function user_online(){

        if(isset($_GET['onlineusers'])){
        global $connection;
            if(!$connection){
                session_start();
                include("../includes/db.php");
                $session = session_id();
                $time = time();
                $time_out_in_seconds = 05;
                $time_out = $time - $time_out_in_seconds;
                $query = "SELECT * FROM users_online WHERE session = '$session'";
                $send_query = mysqli_query($connection, $query);
                $count = mysqli_num_rows($send_query);

                if($count == NULL){

                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
                } else {
                    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
                }

                $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time >  '$time_out'");
               echo $count_user = mysqli_num_rows( $user_online_query);
            }
        } //get request isset

    }
// execute online user
    user_online();

   

    // Insert Categories
    function inserCategories(){
        global $connection;
        if(isset($_POST['submit'])){
           $cat_title = escape($_POST['cat_title']);                         
           if( $cat_title == "" || empty($cat_title)) {                        
               echo "This field should not be empty";                        
           } else {
                $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");  
                mysqli_stmt_bind_param($stmt,'s', $cat_title);
               $execute = mysqli_stmt_execute($stmt);
                confirmQuery($execute);
           }
        }
                            
    }


    
    //Query / Find All Categories  From the DB
    function findAllCategories(){
        global $connection;
        $query = "SELECT * FROM categories";        
        $select_categories = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($select_categories)){
           $cat_id = $row["cat_id"];
           $cat_title = $row["cat_title"];
           echo "<tr class>";
           echo "<td> $cat_id</td>";
           echo "<td> $cat_title</td>";
           echo "<td><a href='categories.php?edit={$cat_id}' class='btn btn-primary'>Edit</a></td>";
           echo "<td><a href='categories.php?delete={$cat_id}' class='btn btn-danger'>Delete</a></td>";
           echo "</tr>";
       } 
               
    }


    
     //Update Categories
    function updateCategories(){
        global $connection;
          if(isset($_GET['edit'])){
            $cat_id = $_GET['edit'];
            include("includes/update_categories.php");
        }  
    }
    
    
    // Delete Categories
    function deleteCategories(){
        global $connection; 
        if(isset($_GET['delete'])){
            $the_cat_id = $_GET['delete']; 
            $stmt = mysqli_prepare($connection, "DELETE FROM categories WHERE cat_id = ? ");  
            mysqli_stmt_bind_param($stmt,'i',  $the_cat_id);
           $execute = mysqli_stmt_execute($stmt);
            confirmQuery($execute); 

            mysqli_stmt_close($stmt);                            
            redirect("categories.php");
        }
        
       // mysqli_stmt_close($stmt);
    }


?>