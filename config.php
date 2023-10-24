<?php

$DBSERVER='localhost';                              //Database server
$DBUSERNAME='root';                                 //Database username
$DBPASSWORD='';                                     //Database password
$DBDATABASE='customer_feedback_userdata';           //Database name


/* connect to MySQL database*/ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBDATABASE);

// Check db connection 
if($db){
    echo "Database connection successful.";
}else{
    die("Error: connection error01. " . mysqli_connect_error());
}

?>
