<?php
$msg = "";
$connection = mysqli_connect("localhost","edervishaj16","ed632haj","web18_edervishaj16");
if($_SERVER['REQUEST_METHOD']=="POST") {
    if(isset($_POST['reset'])) {
        $username = mysqli_real_escape_string($connection,$_POST["username"]);
        $pass = $_POST["pass"];
        $pass = md5($pass);
        $email = mysqli_real_escape_string($connection,$_POST["email"]);
        if(empty($username) || empty($pass) || empty($email))
            $msg = "Please fill all the fields";
            else {
                $query = mysqli_query($connection, "SELECT * FROM users WHERE username='$username' AND email='$email'");
                if (mysqli_num_rows($query) == 1) {
                    $msg = "Password successfully reset.";
                    mysqli_query($connection, "UPDATE users SET password='".$pass."' WHERE username='".$username."'");
                }
                else
                    $msg = "Account not found";
            }
        }

    }
?>
<html>
<head> 
<link rel = "stylesheet" type = "text/css" href = "resetPass.css"/>
</head>
<body>
    <div id = "mainDIV">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" id = "forgetPassForm">
            <label>Username:</label><br><input type="text" name="username"><br>
            <label>Email:</label><br><input type="text" name="email"><br>
            <label>New password:</label><br><input type="text" name="pass"><br>
            <input type="submit" name="reset" value="Reset"><br>
            <span style="color: red"><?php echo $msg ?></span>
        </form>
    </div>
</body>
</html>
