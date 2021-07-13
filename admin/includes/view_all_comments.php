<?php ob_start();?>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Authoor</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response To</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unaprrove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
                             
    <?php 
        //Finding and Query Post From DB
        $query = "SELECT * FROM comments";
            
        $select_comment = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_comment)){
            $comment_id = $row["comment_id"];
            $comment_post_id = $row["comment_post_id"];
            $comment_author = $row["comment_author"];
            $comment_email = $row["comment_email"];
            $comment_content = $row["comment_content"];
            $comment_status = $row["comment_status"];
            $comment_date = $row["comment_date"];
                                
            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_content}</td>";
            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";

           
            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id  ";

            $select_postt_id_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_postt_id_query)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?post_id=$post_id'>$post_title</a></td>";
            }



            echo "<td>{$comment_date}</td>";
            echo "<td><a href='comments.php?approve={$comment_id}' class='btn btn-info'>Approve</a></td>";
            echo "<td><a href='comments.php?unapprove={$comment_id}' class='btn btn-primary'>Unapprove</a></td>";
            echo "<td><a href='comments.php?delete={$comment_id}' class='btn btn-danger'>Delete</a></td>";
            echo "</tr>";
                                
            } ?>
    </tbody>
                    
</table>

<?php 
    if(isset($_GET['approve'])){
        $the_comment_id = $_GET['approve'];
        
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id= $the_comment_id ";
        $approve_comment_query = mysqli_query($connection, $query);
        header("location: comments.php");
        
        
    }

    if(isset($_GET['unapprove'])){
        $the_comment_id = $_GET['unapprove'];
        
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id= $the_comment_id ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("location: comments.php");
        
        
    }

    if(isset($_GET['delete'])){
        if(isset($_SESSION['user_role'])){
            if(isset($_SESSION['user_role']) == 'admin'){
                $the_comment_id = mysqli_real_escape_string($connection, $_GET['delete']);
        
                $query = "DELETE FROM comments WHERE  comment_id = {$the_comment_id}";
                $delete_comment = mysqli_query($connection, $query);
                header("location: comments.php");
        
            }
        }
        
    }
 ?>
