<?php
$connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>iOrder</title>
    <!-- Use of icons from "Font awesome 5"-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- External CSS Stylesheet-->
    <link rel="stylesheet" type="text/css" href="restaurant_stylesheet.css">
</head>
<body>
    <!-- Creation of the navigation bar -->
    <nav class="navigation_bar">
        <ul>
            <!-- elements of the navigation bar-->
            <li class="item"><a href="restaurant_orders.php">Orders</a></li>
            <li class="item"><a href="completed_orders_restaurant.php">Completed Orders</a></li>
            <li class="item" id="logout"><a href="logout.php"><i style="font-size: 19px" class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    </nav>
    <!-- This div will contain the table with the items on the menu of the restaurant-->
    <div>
        <table id="orders">
            <tr>
                <th>Nr of Order</th>
                <th>Order</th>
                <th>Price</th>
                <th>Client</th>
                <th>Address 1</th>
                <th>Address 2</th>
            </tr>
            <?php
            $query = mysqli_query($connection, "SELECT * FROM completed_orders");
            while($row = mysqli_fetch_assoc($query)){  ?>
            <tr id="hover">
                <td><?php echo $row["ID"]?></td>
                <td><?php echo $row["_order_"]?></td>
                <td><?php echo $row["price"]?></td>
                <td><?php echo $row["client"]?></td>
                <td><?php echo $row["address_1"]?></td>
                <td><?php echo $row["address_2"]?></td>
            </tr>
            <?php
            }
             ?>
        </table>
    </div>
</body>
</html>