<!-- Header Section -->
<?php include("./includes/header.php");?>
<!-- Navigation -->
<?php include("./includes/navigation.php");?>
<?php 
echo loggedInUserId();
echo "<br>";
if(userLikedThisPost(96)){
    echo 'USER LIKED THE POST';
} else {
    echo "DID NOT LIKE IT";
}