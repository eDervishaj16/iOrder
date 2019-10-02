<?php
$connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");
$id = $_POST["id"];
if(preg_match('/^[a-f0-9]{32}$/', $_POST["password"]))
    $password = $_POST["password"];
else
    $password = md5($_POST['password']);
mysqli_query($connection,"UPDATE users SET username ='".$_POST['username']."', password ='".$password."', _level_ ='".$_POST['privilege']."', _name_ ='".$_POST['name']."', surname ='".$_POST['surname']."', email ='".$_POST['email']."', city ='".$_POST['city']."', address_1 ='".$_POST['address1']."', address_2 ='".$_POST['address2']."', phone_number ='".$_POST['phoneNr']."' WHERE id='$id' ");
?>