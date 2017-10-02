<?php
include('config.php');

//Store Data in Database
$con=mysqli_connect("localhost",$tinytask_db_user, $tinytask_db_pass, $tinytask_db_name);
// Check connection
if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }


if(isset($_POST['id'])) {
   $id = $_POST['id'];
   $delquery=mysqli_query($con,"UPDATE Tasks SET Completed=1, Date=Date WHERE ID=".$id) or die(mysqli_error($con));
}

mysqli_close($con);

?>