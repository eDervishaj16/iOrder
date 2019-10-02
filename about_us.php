<?php
session_start();
?>
<?php
    // Strings holing the error that the user input might have
    $unErr = $pwErr = "";
    $name = $pass = "";
        
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["login"])) {
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
                            $_SESSION["level"] = 2;
                            $_SESSION["logIn"] = true;
                            header("Location: user.php"); // User Privileges
                        }
                    }else{
                        $pwErr = "Incorrect username or password";
                    }
            }

        }

    }
?>

<html>
<head>
    <title>About us</title>
    <link type="text/css" rel="stylesheet" href="about_us_stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script>
        function changeNavigation(){
            var myLink = document.getElementsByClassName("dropdown-content")[0];

            while(myLink.hasChildNodes()){
                myLink.removeChild(myLink.firstChild);
            }

            myLink.innerHTML = "<a onclick = \"window.location.href = 'logout.php'\">Log Out</a>"
        }
    </script>
</head>
<body>
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

    <div id="mainDiv">
        <div id="imageHolder">
            <img src="https://thimpress.com/wp-content/uploads/2018/04/41993-das-loft-sofitel-19to1.jpeg" style = "width: 100%; border-radius: 10px; height: 70%; margin-bottom: 0px;">
        </div>
        <div id="textHolder">
            <div id="questions">
                <h1>Who are we?</h1>
                <hr><br>
                <p>
                    Pearl has been comfortably tucked away on the northern end of the Monadnock Community Plaza in Peterborough, NH for more than 8 years now. 
                    In April 2010, the young chef Harris Welden, a Greenfield, NH native, took the reigns and brought his unique style of cooking to this community establishment.
                    Chef Harris is a graduate of Loyola University and the Culinary Institute of America where he developed a passion for Italian and French cooking.
                </p>
            </div>

            <div id="questions">
                <h1>Where to find us</h1>
                <hr><br>
                <p style="font-style: italic">1 Jaffrey Road ,Peterborough, NH</p>
            </div>

            <div id="questions">
                <h1>For reservations</h1>
                <hr><br>
                <h5>Contact: (603) 924-5225</h5>
                <p>Reservations Recommended <br>

                    Mon – Thurs    5pm – 9pm  <br>

                    Fri & Sat      5pm – 10pm</p>
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
                    
                <button type="submit" name = "login">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

            <div class="container1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
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

<?php
    // If not logged in, Log In
    if(isset($_SESSION["logIn"]) && $_SESSION == true){
        echo '<script type="text/javascript">',
            'changeNavigation();',
            '</script>'
        ;
    }
?>


</html>
