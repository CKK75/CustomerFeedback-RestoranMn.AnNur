<?php

// Start the session
session_start();

// if the user is already logged in then redirect user to welcome page
if (isset($_SESSION["userid"]) && $_SESSION["userid"] == true){
    header("location: Welcome Page.html");
    exit;
}else{
    /*echo " Unable to redirect to Welcome page."*/;
}

?>