<?php
session_start();
?>

<?php
    $connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");
    
    $order = $_POST["items"];
    $price = $_POST["price"];
    $client = $_SESSION["name"]." ".$_SESSION["surname"];
    $city = $_SESSION["city"];
    $address1 = $_SESSION["address1"];
    $address2 = $_SESSION["address2"];
    $telephone = $_SESSION["phone_number"];

    mysqli_query($connection, "INSERT INTO orders (_order_, price, client, city, address_1, address_2, telephone) VALUES ('$order', '$price', '$client', '$city', '$address1', '$address2', '$telephone')");
?>