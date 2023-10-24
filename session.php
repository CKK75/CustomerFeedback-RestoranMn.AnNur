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

$_SESSION['last_activity'] = time();
$_SESSION['timeout'] = 900;                     // 15 minutes in seconds

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout'])) {
    // Session has timed out
    session_unset();                            // Unset all session variables
    session_destroy();                          // Destroy the session
    header("Location: logout.php");             // Redirect to a logout page
    exit;
}else{
    // Update the last activity time
    $_SESSION['last_activity'] = time();
}

?>
