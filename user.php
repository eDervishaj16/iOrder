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
                            $_SESSION["_level_"] = 0;
                            header("Location: admin.php"); // Admin Privileges
                        } else if($row["_level_"] == 1) {
                            $_SESSION["logIn"] = true;
                            $_SESSION["_level_"] = 1;
                            header("Location: restaurant_orders.php"); //  Restaurant Owner
                        } else if($row["_level_"] == 2){
                            $_SESSION["logIn"] = true;
                            $_SESSION["_level_"] = 2;
                            header("Location: user.php"); // User Privileges
                        }
                    }else{
                        $pwErr = "Incorrect username or password";
                    }
            }

        }

    }
?>

<!-- THIS IS THE DEFAULT PAGE -->
<html>
    <head>
        <title>iOrder</title>
        <!--For the icons used in the navigatiob bar-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <!-- External Styles/Scripts-->
        <link rel = "stylesheet" type = "text/css" href = "user.css"/>
        <script type = "text/javascript" src = "user.js"></script>
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

    <body onload = "writeToOrders()">
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

        <!-- MY ORDERS-->
        <div id = "order_placeholder">
            <div id = "myOrdersname">My Orders</div>
            <div id = "orderedItems">
                <table name = "defaultTable" id = "rowInformation">
                    <tr id = "mainRow">
                            <td name = "qtyRow">Qty.</td>
                            <td name = "itemRow">Item</td>
                            <td name = "priceRow">Price</td>
                            <td name = "dropRow"></td>
                    </tr>
                </table>
                <table name = "myItemsTable" id = "ordersTable">
                </table>
            </div>
            <div id = "price_holder">
                Total: <label name = "totPrice">0</label>lek&euml;
                <br>
                <button onclick = "goToOrdersPage()" type = "button" name = "finishOrder">Order</button>
            </div>
        </div>
        <!-- The main MENU-->
        <div id = "menu">

            <!--Row 1-->
            <div id = "row">
                <!--1-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://images.ricardocuisine.com/services/recipes/1074x1074_858933985531f5aaeb2ef0-background.jpg">
                    </div>
                    <div id = "name">Item_1</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--2-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "http://www.pasadenanow.com/main/wp-content/uploads/2015/11/MG_6441-480px.jpg">
                    </div>
                    <div id = "name">Item_2</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--3-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://cdn.britannica.com/s:300x500/08/177308-131-DFD947AD.jpg">
                    </div>
                    <div id = "name">Item_3</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--4-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://shop.countdown.co.nz/Content/Recipes/Pizza%20Margherita-540x327.jpg">
                    </div>
                    <div id = "name">Item_4</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--5-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "http://www.ptownpizza.com/images/Food/Pizza/Pizza01.jpg">
                    </div>
                    <div id = "name">Item_5</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
            </div>

            <!--Row 2-->
            <div id = "row">
                <!--1-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://www.kunzler.com/wp-content/uploads/2015/10/bacon-grilled-cheese.jpeg">
                    </div>
                    <div id = "name">TItem 6</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--2-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "http://assets.kraftfoods.com/recipe_images/opendeploy/Savory_Turkey_Sandwich_640x428.jpg">
                    </div>
                    <div id = "name">Item_7</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--3-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://charlotteslivelykitchen.com/wp-content/uploads/2016/10/Club-Sandwich-1.jpg">
                    </div>
                    <div id = "name">Item_8</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--4-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://www.foxvalleyfoodie.com/wp-content/uploads/2017/01/easy-crock-pot-french-dip-sandwiches-recipe.jpg">
                    </div>
                    <div id = "name">Item_9</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--5-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://www.dunkindonuts.com/content/dam/dd/img/products/sandwiches-wraps/sausage-egg-cheese/tiles/lp-promo-x2-sausage-egg-&-cheese-620x506.jpg">
                    </div>
                    <div id = "name">Item_10</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
            </div>

            <!--Row 3-->
            <div id = "row">
                <!--1-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://images.ricardocuisine.com/services/recipes/1074x1074_858933985531f5aaeb2ef0-background.jpg">
                    </div>
                    <div id = "name">Item_11</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--2-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "http://www.pasadenanow.com/main/wp-content/uploads/2015/11/MG_6441-480px.jpg">
                    </div>
                    <div id = "name">Item_12</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--3-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://cdn.britannica.com/s:300x500/08/177308-131-DFD947AD.jpg">
                    </div>
                    <div id = "name">Item_13</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--4-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "https://shop.countdown.co.nz/Content/Recipes/Pizza%20Margherita-540x327.jpg">
                    </div>
                    <div id = "name">Item_14</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
                <!--5-->
                <div id = "cell" name = "itemToSelect" class = "unselected" ondblclick = "this.setAttribute('name','clicked'); changeSelected()">
                    <div id = "image">
                        <img src = "http://www.ptownpizza.com/images/Food/Pizza/Pizza01.jpg">
                    </div>
                    <div id = "name">Item_15</div>
                    <div id = "desc">
                        <p >This is a short description of the product above. You can include here everything that the user might need to know.</p>
                    </div>
                    <div id = "quantity">
                        <i class="far fa-minus-square" id = "minusIcon" onclick = "this.setAttribute('name', 'decrease'); decreaseQty()" name = "minus"></i>
                        </i><label name = "qtyDisplay" id = "myQty">1</label>
                        <i class="far fa-plus-square" id = "plusIcon" onclick = "this.setAttribute('name', 'increase'); increaseQty()" name = "plus"></i>
                       <label name = "300" id = "myPrice">300</label>
                       <label name = "currency" id = "myCurrency">lek&euml;</label>
                    </div>
                    <div id = "displayParagraph">
                    </div>
                </div>
            </div>

        </div>

        <!-- Select the page -->
        <div id = "buttons">
            <div id = "previews">
                <button type = "button" name = "previews" onclick = "goToPrevPage()">Previews</button>
            </div>
            <div id = "pageCount">
                <label name = "currentPage">1</label>
                <label>/</label>
                <label name = "lastPage">2</label>
            </div>
            <div id = "next">
                <button type = "button" name = "next" onclick = "goToNextPage()">Next</button>
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
</html>

<?php
    // If not logged in, Log In
    if(isset($_SESSION["logIn"]) && $_SESSION == true){
        echo '<script type="text/javascript">',
            'changeNavigation();',
            '</script>'
        ;
    }
?>