<?php

require_once "config.php";
require_once "session.php";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $error = '';

    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Replace this with your actual validation logic
    if (empty($email)){
        $error .= '<p class="error">Please enter email.</p>';
    }

    if (empty($error)){
        if($query = $db->prepare("SELECT * FROM login_userdata WHERE email = ?")){
            $query->bind_param('s', $email);
            $query->execute();
            $result = $query->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if ($row) {
                    if (password_verify($password, $row['password'])) {
                        $_SESSION["userid"] = $row['id'];
                        $_SESSION["user"] = $row;
                        echo " Password is valid.";

                        header("location: ./welcome.php");
                        // Your existing code here
                    } else {
                        echo " Password is not valid!";
                        $error .= '<p class="error">The password is not valid.</p>';
                    }
                }
            } else {
                $error .= '<p class="error">No user exists with this email address.</p>';
            }
            
        }
        $query->close();
    }
    // Close connection
    mysqli_close($db);


}else{
    /*echo " *Block error connecting..."*/;
}

include "Login_&_Signup.html";

?>
