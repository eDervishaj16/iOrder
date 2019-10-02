<?php
session_start();
?>

<?php
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    //Load Composer's autoloader
    require 'vendor/autoload.php';
    // Error-holding variable
    $emailErr = $emailSc = "";
    // Placeholders
    $myEmail = $pass = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["forgotBtn"])){

            // Connecting to the database
            $connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");

            $myEmail = $_POST["resetEmail"];

            $query = mysqli_query($connection, "select * from users WHERE email = '$myEmail'");
            $count = mysqli_num_rows($query);

            if($count == 1){

                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
                    $mail->Port = 465;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('noreply@iorder.com', 'Mailer');
                    $mail->addAddress($myEmail);               // Name is optional

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Password Reset';
                    $mail->Body    = 'Plese follow this link to reset your password: <b>http://stud-proj.epoka.edu.al/~edervishaj16/web_programming_project/resetPass.php</b>';
                    $mail->AltBody = 'Plese follow this link to reset your password: http://stud-proj.epoka.edu.al/~edervishaj16/web_programming_project/resetPass.php';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }
        }
    }
?>

<html>
    <head>
        <title>iOrder</title>
        <link rel = "stylesheet" type = "text/css" href = "forgotPass.css" />
    </head>


    <body>
        <div id = "main">
            <div id = "forgetPassForm">
                <form action = "<?php echo $_SERVER['PHP_SELF']?>" method = "POST">
                    <p><strong>Please insert your <u>E-mail address</u>. We will send a link to reset your password!</strong></p>
                    <input type = "email" name = "resetEmail"><br>

                    <input id = "myBtn" type = "submit" name = "forgotBtn" value = "Submit"><br><br>
                    <!--Error/Success Output-->
                    <span id = "error"><?php if(empty($emailErr) && !empty($emailSc)){echo $emailSc;}else{echo $emailErr;}?></span><br>
                </form>
            </div>
        </div>
    </body>
</html>