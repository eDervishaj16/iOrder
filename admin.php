<?php
session_start();
if($_SESSION["_level_"] != 0 || !isset($_SESSION["logIn"])){
    header('Location: user.php');
}
$connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin iOrder</title>
    <link rel="stylesheet" type="text/css" href="adminPage_stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
        <script>
        var index;
        function indexRow(x) {
            index = x.rowIndex;
            console.log("Row index="+index);
        }
        function deleteR() {
            var rows = document.getElementsByClassName("rows");
            for(var i=0; i<rows.length; i++){
                if(i==index-1){
                    var id = rows[i].getElementsByTagName("td")[0].innerHTML;
                    console.log("ID is: "+id);
                        jQuery.post("delete.php",
                            {
                                id: id
                            },
                        function () {
                            alert("Row deleted from the database");
                        });

                }
            }
            document.getElementsByTagName("table")[0].deleteRow(index);
        }
        function update() {
            var rows = document.getElementsByClassName("rows");
            for(var i=0; i<rows.length; i++){
                var id = rows[i].getElementsByTagName("td")[0].innerHTML;
                var username = rows[i].getElementsByTagName("td")[1].innerHTML;
                var password = rows[i].getElementsByTagName("td")[2].innerHTML;
                var privilege = rows[i].getElementsByTagName("td")[3].innerHTML;
                var name = rows[i].getElementsByTagName("td")[4].innerHTML;
                var surname = rows[i].getElementsByTagName("td")[5].innerHTML;
                var email = rows[i].getElementsByTagName("td")[6].innerHTML;
                var city = rows[i].getElementsByTagName("td")[7].innerHTML;
                var address1 = rows[i].getElementsByTagName("td")[8].innerHTML;
                var address2 = rows[i].getElementsByTagName("td")[9].innerHTML;
                var phoneNr = rows[i].getElementsByTagName("td")[10].innerHTML;
                jQuery.post("update.php",
                    {
                        id: id, username: username, password: password, privilege: privilege, name: name, surname: surname, email: email, city: city, address1: address1, address2: address2, phoneNr: phoneNr
                    },
                );
            }
            alert("Database updated.")
        }
    </script>
</head>
<body>
<?php
$valid = true;
$usernameErr = $passErr = $privilegeErr = $nameErr = $surnameErr = $emailErr = $cityErr = $address1Err = $telnrErr = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");
        if (empty($_POST["username"])) {
            $usernameErr = "Username is required";
            $valid = false;
        } else {
            // Checking if the username currently exists in the database
            $username = $_POST["username"];
            $query = mysqli_query($connection, "select * from users WHERE username = '$username'");
            $result = mysqli_num_rows($query);
            if ($result == 1) {
                $usernameErr = "Username already exists!";
                $valid = false;
            } else if ($result == 0 && !test_username($username)) {
                $usernameErr = "Only . or _ are allowed!";
                $valid = false;
            }
        }
        if (empty($_POST["password"])) {
            $passErr = "Password is required";
            $valid = false;
        } else
            $pass = $_POST["password"];
        if (empty($_POST["privilege"]) && $_POST["privilege"]!=0) {
            $privilegeErr = "Privilege is required";
            $valid = false;
        } else if(!preg_match("/^[0-9]*$/", $_POST["privilege"])){
            $privilegeErr = "Only numbers are allowed";
        }
        else
            $privilege = $_POST["privilege"];

        if (empty($_POST["name"])) {
            $nameErr = "Name is required!";
            $valid = false;
        } else if (!test_name($_POST["name"])) {
            $nameErr = "Only letters allowed!";
            $valid = false;
        } else {
            $name = $_POST["name"];
        }
        if (empty($_POST["surname"])) {
            $surnameErr = "Surname is required!";
            $valid = false;
        } else if (!test_name($_POST["surname"])) {
            $surnameErr = "Only letters allowed!";
            $valid = false;
        } else {
            $surname = $_POST["surname"];
        }
        if (empty($_POST["email"])) {
            $mailErr = "E-mail is required!";
            $valid = false;
        } else {
            // Checking if the email currently exists in the database
            $email = $_POST["email"];
            $query = mysqli_query($connection, "select * from users WHERE email = '$email'");
            $result = mysqli_num_rows($query);

            if ($result == 1) {
                $mailErr = "This E-mail already has an account!";
                $valid = false;
            } else {
                $email = $_POST["email"];
            }
        }
        if (empty($_POST["city"])) {
            $cityErr = "City is required";
            $valid = false;
        } else
            $city = $_POST["city"];
        if (empty($_POST["address1"])) {
            $address1Err = "Address is required";
            $valid = false;
        } else {
            $address1 = $_POST["address1"];
        }
        $address2 = $_POST["address2"];
        if(empty($_POST["email"]))
            $emailErr = "Email is required";
        if (empty($_POST["phone_number"])) {
            $telnrErr = "Number is required";
            $valid = false;
        } else if (!preg_match("/[0-9]{10}/", $_POST["phone_number"])) {
            $telnrErr = "The number must have only numbers";
            $valid = false;
        } else {
            $phone_number = $_POST["phone_number"];
        }
        if ($valid) {
            $pass = md5($pass);
            $query = mysqli_query($connection, "INSERT INTO users (username, password, _level_, _name_, surname, email, city, address_1, address_2, phone_number) VALUES ('$username', '$pass', '$privilege', '$name', '$surname', '$email', '$city', '$address1', '$address2','$phone_number')");
            header("Location: admin.php");
        }

    }
}

?>
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
    if(preg_match("/^.*(?=.{6,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $data)){
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
    <div>
        <p style="background-color: rgba(137,206,208,0.42)">Admin username: <?php echo $_SESSION["username"]?> <a href="logout.php"><button type="submit" class="add"><i id="icon" class="fas fa-sign-out-alt" style="font-size: 15px;"></i></button></a> </p>
    </div>
    <div>
        <table id="mytable">
            <tr style="background-color: lightskyblue">
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Privilege</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>City Address</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>Phone number</th>
                <th></th>
            </tr>
            <?php
            $query = mysqli_query($connection, "SELECT * FROM users");
            while($row = mysqli_fetch_assoc($query)){ ?>
                <tr class='rows' onmouseover='indexRow(this)'>
                    <td><?php echo $row["ID"] ?></td>
                    <td id="unselected" name="user" onclick="alterCell(this)"><?php echo $row["username"] ?></td>
                    <td id="unselected" name="password" onclick="alterCell(this)"><?php echo $row["password"] ?></td>
                    <td id="unselected" name="lvl" onclick="alterCell(this)"><?php echo $row["_level_"] ?> </td>
                    <td id="unselected" name="name" onclick="alterCell(this)"><?php echo $row["_name_"] ?></td>
                    <td id="unselected" name="surname" onclick="alterCell(this)"><?php echo $row["surname"] ?></td>
                    <td><?php echo $row["email"] ?></td>
                    <td id="unselected" name="city" onclick="alterCell(this)"><?php echo $row["city"] ?></td>
                    <td id="unselected" name="add1" onclick="alterCell(this)"><?php echo $row["address_1"] ?></td>
                    <td id="unselected" name="add2" onclick="alterCell(this)"><?php echo $row["address_2"] ?></td>
                    <td id="unselected" name="phoneNr" onclick="alterCell(this)"><?php echo $row["phone_number"] ?></td>
                <td><input onclick='deleteR()' class='delete_button' type='button' name='delete' value='Delete'></td>
            </tr>

            <?php
            }
            ?>
        </table>
    </div>
    <div style="margin-left: 40%">
        <input type="button" id="saveTable"  class="save" value="Save" name="save" onclick="update()">
    </div>
    <hr>

    <div>
        <table style="width: 50%">
            <tr style="background-color: lightskyblue">
                <th>Username</th>
                <th>Password</th>
                <th>Privilege</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>City Address</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>Phone number</th>
                <th></th>
            </tr>
            <tr>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                <td id="add"><input class="addUser" type="text" name="username"><br><span style="font-size: 13px"><?php echo $usernameErr; ?></span></td>
                <td id="add"><input class="addUser" type="text" name="password"><br><span style="font-size: 13px"><?php echo $passErr; ?></span></td>
                <td id="add"><input class="addUser" type="text" name="privilege"><br><span style="font-size: 13px"><?php echo $privilegeErr; ?></span></td>
                <td id="add"><input class="addUser" type="text" name="name"><br><span style="font-size: 13px"><?php echo $nameErr; ?></span></td>
                <td id="add"><input class="addUser" type="text" name="surname"><br><span style="font-size: 13px"><?php echo $surnameErr; ?></span></td>
                <td id="add"><input class="addUser" type="email" name="email"><br><span style="font-size: 13px"><?php echo $emailErr; ?></span></td>
                <td id="add"><input class="addUser" type="text" name="city"><br><span style="font-size: 13px"><?php echo $cityErr; ?></span></td>
                <td id="add"><input class="addUser" type="text" name="address1"><br><span style="font-size: 13px"><?php echo $address1Err; ?></span></td>
                <td id="add"><input class="addUser" type="text" name="address2"></td>
                <td id="add"><input class="addUser" type="text" name="phone_number"><br><span style="font-size: 13px"><?php echo $telnrErr; ?></span></td>
                <td id="add"><input type="submit" name="add" class="add" value="Add User"></td>
                </form>
            </tr>
        </table>
    </div>
</body>
</html>

