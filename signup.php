<?php

require_once "config.php";
require_once "session.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["submit"])){

    $error = '';

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    if($query = $db->prepare("SELECT * FROM login_userdata WHERE email = ?")){

        $query->bind_param('s', $email);        /*Bind parameters (s=string, i=int, b=blob, etc), we use "s" for email.*/
        $query->execute();

        // Store the result so we can check if account exists in database.
        $query->store_result();    
         
        if ($query->num_rows > 0){
            $error .= '<p class="error">The email address is already signed-up!</p>';
        }else{
            $uppercase = preg_match('/[A-Z]/', $password);
            $lowercase = preg_match('/[a-z]/', $password);
            $number = preg_match('/[0-9]/', $password);
            $specialchar = preg_match('/[!@#$%^&*()_+]/', $password);

            // Validate password
            if (!$uppercase || !$lowercase || !$number || !$specialchar || strlen($password)<6){
                $error .= '<p class="error">Password does not meet the requirements.</p>' ;
            }
        }

        $insertQuery = null;

        $insertQuery = $db->prepare("INSERT INTO login_userdata (username,email,password) VALUES (?, ?, ?); ");
        if (!$insertQuery) {
            die("Error in the prepare statement: " . $db->error);
        }

        $insertQuery->bind_param("sss", $username, $email, $password_hash);
        
        $db->autocommit(false);

        $result = $insertQuery->execute();
        
        if ($result){
            $db->commit();
            echo " Data inserted successfully.";
            $error .= '<p class="success">Your signup was successful.</p>';
        }else{
            $db->rollback();
            die("Error in the execution: " . $insertQuery->error);
        }
    
    }

    $query->close();
    $insertQuery->close();

    // Close DB connection
    mysqli_close($db);
    
}else{
    /*echo " *Block error connecting..."*/;
}


include "Login_&_Signup.html";

?>

