<?php
    include('config.php');

    //Store Data in Database
    $con=mysqli_connect("localhost",$tinytask_db_user, $tinytask_db_pass, $tinytask_db_name);
    // Check connection
    if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

    // Process Delete Request
    if(isset($_POST['deleteItem']) and is_numeric($_POST['deleteItem']))
    {
      $delete = $_POST['deleteItem'];

      $delquery=mysqli_query($con,"DELETE FROM Tasks WHERE ID=".$delete) or die(mysqli_error($con));
    }

    mysqli_close($con);

?>
