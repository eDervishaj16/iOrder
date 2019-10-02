<?php
session_start();
?>
<?php
    // Strings holing the error that the user input might have
    $unErr = $pwErr = "";
    $name = $pass = "";
        
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["myLogin"])) {
            $connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");

            // Checking if the username is of the right format
            if (empty($_POST["username"])) {
                $unErr = "Username is required!";
            } else {
                    $username = mysqli_real_escape_string($connection, $_POST["username"]);
                    $_SESSION["username"] = $username;
                    $unErr = "";
            }

            // Checking if the password is of the right format
            if (empty($_POST["password"])) {
                $pwErr = "Password is required!";
            } else {
                    $pass = md5($_POST["password"]);
                    $_SESSION["pass"] = $pass;
                    $pwErr = "";
                    $query = mysqli_query($connection, "select * from users where username ='$username' and password='$pass'");
                    if (mysqli_num_rows($query) == 1) {
                        $row = mysqli_fetch_assoc($query);
                        if ($row["_level_"] == 0) {
                            $_SESSION["logIn"] = true;
                            $_SESSION["level"] = 0;
                            header("Location: admin.php"); // Admin Privileges
                        } else if($row["_level_"] == 1) {
                            $_SESSION["logIn"] = true;
                            $_SESSION["level"] = 1;
                            header("Location: restaurant_orders.php"); //  Restaurant Owner
                        } else if($row["_level_"] == 2){
                            $_SESSION["logIn"] = true;
                            $_SESSION["level"] = 2;
                            header("Location: myOrders.php"); // User Privileges
                        }
                    } else {
                        $pwErr = "Incorrect username or password";
                    }
            }

        }

    }
?>
<html>
    <head>
        <title>iOrder</title>
        <!--For the icons used in the navigatiob bar-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <!-- External Styles/Scripts-->
        <link rel = "stylesheet" type = "text/css" href = "myOrders.css"/>
        <script type = "text/javascript" src = "myOrders.js"></script>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
        <script type = "text/javascript">
            // Removes the "Order" button & the orders once clicked
            function removeBtn(){
                
                var place = document.getElementById("btnHolder");

                while(place.hasChildNodes()){
                    place.removeChild(place.firstChild);
                }

                place.innerHTML = "<lable name = \"finalised\">Thank you for ordering from iOrder!</label>";
            }
            function changeNavigation(){
                var myLink = document.getElementsByClassName("dropdown-content")[0];

                while(myLink.hasChildNodes()){
                    myLink.removeChild(myLink.firstChild);
                }

                myLink.innerHTML = "<a onclick = \"window.location.href = 'logout.php'\">Log Out</a>"
            }
        </script>
    </head>

    <!-- Table to display what the user has selected-->
    <body onload = "displayItems()">
        <!--Navigation Bar-->        
        <div class="navbar">
            <a href="user.php">Menu</a>
            <a href = "about_us.php">About Us</a>
            <a><i class="fab fa-artstation" id = "icon" style = "width: 30px; align: center; font-size: 30px;"></i></a>
            <a href="myOrders.php" style = "margin-left: 10px">My Order</a>
            <div class="dropdown">
                <button class="dropbtn" style = "margin-top: 3px;">My Profile<i class="fas fa-user-circle" style = "margin-left: 5px;"></i></button>
                <div class="dropdown-content">
                    <a onclick = "document.getElementById('id01').style.display='block'" style="width:auto;">Log In</a>
                </div>
            </div> 
        </div>

        <div id = "mainDIV">
            <!-- MY ORDERS-->
            <div id = "order_placeholder">
                <div id = "myOrdersname">My Orders</div>
                <div id = "orderedItems">
                </div>
                <div id = "price_holder">
                    Total: <label name = "totPrice">0</label>lek&euml;
                </div>
            </div> 
            
    <!--LOG IN INFO-->
    <div id = "logInInfo">
        <div id = "title">
            User Information
        </div>
        <div id = "userData">
            <!--Contains the login fields-->
            <div id = "loginForm">
                <form action = "<?php echo $_SERVER["PHP_SELF"]?>" method = "POST">
                </form>

                <div id = "signUp">
                </div>

                        <form action = "<?php echo $_SERVER["PHP_SELF"]?>" method = "POST" id = "btnHolder">
                            <?php
                                if(isset($_SESSION["logIn"]) && $_SESSION["logIn"] == true){
                                    echo "<button type = \"button\" name = \"confirmOrder\" id = \"orderBtn\" onclick = \"removeBtn();addToDB()\">Confirm Order</button>";
                                    $connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");

                                    $username = $_SESSION["username"];
                                    $pass = $_SESSION["pass"];

                                    $query = mysqli_query($connection, "select * from users where username ='$username' and password='$pass'");
                                    $row = mysqli_fetch_assoc($query);

                                    $_SESSION["name"] = $row["_name_"];
                                    $_SESSION["surname"] = $row["surname"];
                                    $_SESSION["address1"] = $row["address_1"];
                                    $_SESSION["address2"] = $row["address_2"];
                                    $_SESSION["city"] = $row["city"];
                                    $_SESSION["telephone"] = $row["phone_number"];
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!--LOG IN-->
    <div id="id01" class="modal">
<form class="modal-content animate" method = "POST" action = "<?php echo $_SERVER["PHP_SELF"];?>">
    <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="http://cdn.onlinewebfonts.com/svg/img_258083.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>
            
        <button type="submit" name = "myLogin">Login</button>
        <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
    </div>

    <div class="container1">
        <button style = "float: left" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <span class="psw"><a href="forgotPass.php">Forgot password?</a></span>
    </div>
</form>
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script> 
    </body>
</html>

<?php
    // If not logged in, Log In
    if(isset($_SESSION["logIn"]) && $_SESSION == true){
        echo '<script type="text/javascript">',
            'changeNavigation();',
            '</script>'
        ;
    }else{
        echo '<script type="text/javascript">',
        'displayLogInInfo();',
        '</script>'
        ;
    }
?>