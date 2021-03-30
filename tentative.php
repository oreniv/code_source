<?php 
include_once 'dbconnection.php';

?>



<!DOCTYPE html>
<html>
    <head>
        <title>

        </title>
    </head>

    <body>

<?php
    $sql = "SELECT * FROM project;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($result > 0)
    {
        while($row = mysqli_fetch_assoc($result)){
            echo $row['project_name'];
        }
    }

?>



    </body>
</html>