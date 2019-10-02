<?php
session_start();
?>

<?php
    // Variables to put in the database
    $myName = $mySurname = $myUsername = $myPassword = $myCardNo = $myCSC = $myCity = $myAddress1 = $myAddress1 = $myEmail = $myPhoneNr = $myExpiration =  "";
    // Error-holding variables
    $nameErr = $surnameErr = $mailErr = $userErr = $passErr = $cardTypeErr = $cardNoErr = $exDateErr = $cscErr = $cityErr = $addErr = $phoneErr = $exDateErr =  "";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_POST["Sign_Up"])){

            // Connecting to the database
            $connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");

            // Getting and cleaning the user input
            $name = mysqli_real_escape_string($connection, $_POST["name"]);
            $surname = mysqli_real_escape_string($connection, $_POST["surname"]);
            $username = mysqli_real_escape_string($connection, $_POST["username"]);

            $email = $_POST["email"];
            $pass = md5($_POST["password"]);
            $confirmPass = md5($_POST["VerifyPass"]);

            $cardNo = mysqli_real_escape_string($connection, $_POST["cardNo"]);

            $exYear = mysqli_real_escape_string($connection, $_POST["year"]);
            $exMonth = mysqli_real_escape_string($connection, $_POST["month"]);
            $exDate = "20".$exYear."-".$exMonth."-00";

            $csc = mysqli_real_escape_string($connection, $_POST["pin"]);

            $city = mysqli_real_escape_string($connection, $_POST["city"]);
            $address1 = mysqli_real_escape_string($connection, $_POST["address1"]);
            $address2 = mysqli_real_escape_string($connection, $_POST["address2"]);

            $phoneNumber = mysqli_real_escape_string($connection, $_POST["phoneNumber"]);
            
            // Defualt level for registering a user
            $level = 3;

            // Validating name
            if(empty($name)){
                $nameErr = "Name is required!";
            }else if(!test_name($name)){
                $nameErr = "Only letters allowed!";
            }else{
                $myName = $name;
            }

            // Validating surname
            if(empty($surname)){
                $surnameErr = "Surname is required!";
            }else if(!test_name($surname)){
                $surnameErr = "Only letters allowed!";
            }else{
                $mySurname = $surname;
            }

            // Validating username
            if(empty($username)){
                $userErr = "Username is required!";
            }else{
                // Checking if the username currently exists in the database
                $query = mysqli_query($connection, "select * from users WHERE username = '$username'");
                $result = mysqli_num_rows($query);
                if($result == 1){
                    $userErr = "Username already exists!";
                }else if ($result == 0 && test_username($username)){
                    $myUsername = $username;
                }else{
                    $userErr = "Only . or _ are allowed!";
                }
            }

            // Validating email
            if(empty($email)){
                $mailErr = "E-mail is required!";
            }else{
                // Checking if the username currently exists in the database
                $query = mysqli_query($connection, "select * from users WHERE email = '$email'");
                $result = mysqli_num_rows($query);

                if($result == 1){
                    $mailErr = "This E-mail already has an account!";
                }else{
                    $myEmail = $email;
                }
            }

            // Validating password
            if(empty($pass) || empty($confirmPass)){
                $passErr = "Please fill in both the fields!";
            }else if($pass == $confirmPass){
                $passErr = "";
                $myPassword = $pass;
            }else{
                $passErr = "Passwords do not match!";
            }

            // Validating card number
            if(empty($cardNo)){
                $cardNoErr = "Card number is required!";
            }else if(test_cardNo($cardNo)){
                $myCardNo = md5($cardNo);
            }else{
                $cardNoErr = "Please use the right format!";
            }

            // Validating Expiration Date
            if(empty($exMonth) || empty($exYear)){
                $exDateErr = "Expiration date is required!";
            }else{
                if($exMonth > 12 || $exMonth < 1 || $exYear < 19){
                    $exDateErr = "Please enter a valid date";
                }
                else{
                    $exDateErr = "";
                    $myExpiration = $exDate;
                }
            }

            // Validating csc
            if(empty($csc)){
                $cscErr = "CSC is required!";
            }else if(test_csc($csc)){
                $myCSC = md5($csc);
            }else{
                $cscErr = "CSC must contain only numbers!";
            }

            // Validating city
            if(empty($city)){
                $cityErr = "Please select a city!";
            }else{
                $myCity = $city;
            }

            // Validating addresses
            if(empty($address1) || empty($address2)){
                $addErr = "Please provide an address!";
            }else if(!empty($address1) && !empty($address2)){
                $myAddress1 = $address1;
                $myAddress2 = $address2;
            }

            // Validating phone number
            if(empty($phoneNumber)){
                $phoneErr = "Please provide a phone number!";
            }else{
                $myPhoneNr = $phoneNumber; 
            }

            // If everything checks out
            if(!empty($myName) && !empty($mySurname) && !empty($myUsername) && !empty($myPassword) && !empty($myCity) && !empty($myCardNo) && !empty($myCSC) && !empty($myAddress2) && !empty($myAddress1) && !empty($myEmail) && !empty($myPhoneNr)){
                // Insert the new values into the database
                $query = mysqli_query($connection, "INSERT INTO users (username, password, _level_, _name_, surname, email, card_no, csc, city, address_1, address_2) VALUES ('$myUsername', '$myPassword', '$level', '$myName', '$mySurname', '$myEmail', '$myCardNo', '$myCSC', '$myCity', '$myAddress1', '$myAddress2')");
                // Log In the user
                header("location: user.php");
            }
        }
    }
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>iOrder</title>
        <link rel = "stylesheet" type = "text/css" href = "signup.css"/>
    </head>
    <body>
        <!--First div used to center the login-->
        <div id = "main">
            <!--Contains the login fields-->
            <div id = "signupForm">
                <form action = "<?php echo $_SERVER["PHP_SELF"]?>" method = "POST">

                    <!--Name / Surname-->
                    <label style = "margin-right: 5px;">Name:</label><input type = "text" name = "name">
                    <label style = "margin-left: 22px;">Surname:</label><input style = "margin-left: 18px; width: 160px;" type = "text" name="surname"><br>

                    <span id = "error" style = "margin-left: 100px;"><?php echo $nameErr;?></span>
                    <span id = "error" style = "margin-left: 140px;"><?php echo $surnameErr;?></span><br>

                    <!--Email-->
                    <label>E-mail:</label><input style = "width: 243px;" type="email" name="email" autocomplete="off">
                    <span id = "error"><?php echo $mailErr;?></span>
                    <hr>

                    <!--Username / Password-->
                    <label>Username:</label><input style = "margin-left: 10px;" type = "text" name = "username">
                    <span id = "error"><?php echo $userErr;?></span><br>

                    <label>Password:</label><input style = "margin-left: 14px;" type = "password" name = "password">
                    <label style = "margin-left: 20px;">Confirm:</label><input style = "margin-left: 20px;" type = "password" name = "VerifyPass"><br>
                    <span id = "error"><?php echo $passErr;?></span><br>
                    <hr>

                    <!--Card Information-->
                    <label>Card Type:</label><input type = "radio" name = "cardType" value = "visa"><label>Visa</label>
                                            <input type = "radio" name = "cardType" value = "mastercard"><label>MasterCard</label>
                                            <input type = "radio" name = "cardType" value = "americanEx"><label>American Express</label><br>
                    <span id = "error"><?php echo $cardTypeErr;?></span><br>

                    <label>Card No.:</label><input placeholder = "xxxx xxxx xxxx xxxx" type = "text" name = "cardNo" maxlength = "19">
                    <span id = "error"><?php echo $cardNoErr;?></span><br>

                    <label>Expiration Date:</label>
                    <input style = "text-align: center; margin-left: 54px; width: 27px;" type = "text" max = "12" min = "1" name = "month" placeholder = "mm" maxlength = "2">
                    <label style = "font-size: 18px; margin-left: 5px;">/</label>
                    <input style = "text-align: center; margin-left: 5px; width: 27px;" type = "text" min = "19" name = "year" placeholder = "yy" maxlength = "2">
                    <span id = "error"><?php echo $exDateErr;?></span><br>

                    <label>CSC.:</label><input style = "text-align: center; margin-left: 125px; width: 70px;" type = "text" name = "pin" maxlength = "3">
                    <span id = "error"><?php echo $cscErr;?></span><br>
                    <hr>

                    <!--Address Information-->
                    <label style = "margin-right: 63px;">City:</label>
                        <select name = "city">
                            <option disable selected value style = "display: none;"></option>
                            <option value = "tirana">Tirana</option>
                            <option value = "elbasan">Elbasan</option>
                            <option value = "durres">Durres</option>
                            <option value = "Librazhd">Librazhd</option>
                            <option value = "Lushnje">Lushnje</option>
                            <option value = "kruje">Kruje</option>
                        </select>
                        <span id = "error"><?php echo $cityErr;?></span><br>

                    <label>Address 1:</label><input type="text" name="address1" autocomplete="off"><br>
                    <label>Address 2:</label><input type="text" name="address2" autocomplete="off">
                    <span id = "error"><?php echo $addErr;?></span><br>

                    <label>Phone Number:</label><input type="text" name="phoneNumber" autocomplete="off">
                    <span id = "error"><?php echo $phoneErr;?></span><br>
                    <hr>
                    <!--Buttons & Links-->
                    <input id = "SignBtn" type = "submit" name = "Sign_Up" value="Sign up"><br>
                    <label style = "margin-left: 33%;"><a id = "loginLink" href = "main.php">Already have an account?</a></label>
                </form>
            </div>
        </div>
    </body>
</html>

<!--Helper Functions-->
<?php
    function test_name($data){
        // Username must contain only numbers letters and underscores
        if(preg_match("/[a-zA-Z]{2,}$/", $data)){
            return true;
        }else{
            return false;
        }
    }
    function test_pass($data){
        if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $data)){
            return true;
        }else{
            return false;
        }
    }

    function test_username($data){
        // Username must contain only numbers letters and underscores
        if(preg_match("/[0-9a-zA-Z_.]{5,}$/", $data)){
            return true;
        }else{
            return false;
        }
    }
    
    function test_cardNo($data){
        if(preg_match("/[0-9]{4}[ ][0-9]{4}[ ][0-9]{4}[ ][0-9]{4}/", $data)){
            return true;
        }else{
            return false;
        }
    }

    function test_csc($data){
        if(preg_match("/[0-9]{3}/", $data)){
            return true;
        }else{
            return false;
        }
    }
?>