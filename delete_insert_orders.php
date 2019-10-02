<?php
$connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");
$i = 0;
$id = $_POST["id"];
$order = $_POST["order"];
echo $order;
$price = $_POST["price"];
$client = $_POST["client"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
mysqli_query($connection, "INSERT INTO completed_orders (ID, _order_, price, client, address_1, address_2) VALUES ('$i', '$order', '$price', '$client', '$address1', '$address2')");
$i++;
mysqli_query($connection,"DELETE FROM orders WHERE ID='$id'");

?>